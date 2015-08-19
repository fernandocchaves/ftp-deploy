<?php
namespace fernandocchaves\ftpdeploy;

class FTPDeploy
{
	protected $host;
	protected $user;
	protected $pass;
	protected $ftp;
	protected $login;
	protected $ftp_folder;
	protected $files = array();

	public function __construct()
	{
		
	}

	public function connect(){
		$this->ftp = ftp_connect($this->host);
		$this->login = ftp_login($this->ftp, $this->user, $this->pass);
	}

	public function desconnect(){
		ftp_close($this->ftp);
	}

	public function deploy(){
		foreach ($this->files as $file) {
			if(file_exists($file)){
				$this->sedFile($this->ftp, $this->ftp_folder, $file);
				$this->checkIsEmpty($this->ftp, $this->ftp_folder, $file);
			}
		}
	}

	public function sedFile($ftp, $ftp_folder, $file){
		$directory = explode('/', $file);
		$real_file = $directory[count($directory) - 1];

		if(count($directory) > 1){
			unset($directory[count($directory) - 1]);
			$path = implode('/', $directory);

			addDir($ftp_folder, $path, $ftp);
		}

		if($real_file != ''){
			$send = ftp_put($ftp, $ftp_folder . $file, $file, FTP_ASCII);
		}
	}

	public function addDir($ftp_folder, $path, $ftp){
		$directories = explode('/', $path);
		$aux = 0;
		foreach ($directories as $directory) {
			if($aux > 0){
				$ftp_folder .= "/";	
			}
			$ftp_folder .= $directory;
			if (!@ftp_chdir($ftp, $ftp_folder)) {
	            ftp_mkdir($ftp, $ftp_folder);
	        }
	        $aux++;
		}
	}

	public function checkIsEmpty($ftp, $ftp_folder, $file){
		$directory = explode('/', $file);

		if(count($directory) > 1){
			unset($directory[count($directory) - 1]);
			$path = implode('/', $directory);

			removeDir($ftp_folder, $path, $ftp);
		}
	}

	public function removeDir($ftp_folder, $path, $ftp){
		$directories = explode('/', $path);
		foreach ($directories as $directory) {
			$files = ftp_nlist($ftp, $ftp_folder . $path);

			if(count($files) > 2){
				break;
			}

			if (count($files) == 2) {
	            ftp_rmdir($ftp, $ftp_folder . $path);
	            str_replace('/' . $directory, '', $path);
	        }
		}
	}

}	
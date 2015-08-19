<?php
/**
 * PHPCI - Continuous Integration for PHP
 *
 * @copyright    Copyright 2014, Block 8 Limited.
 * @license      https://github.com/Block8/PHPCI/blob/master/LICENSE.md
 * @link         https://www.phptesting.org/
 */

namespace fernandocchaves\ftpdeploy;

use PHPCI\Builder;
use PHPCI\Model\Build;

/**
* FTPDeployPHPCI
* @author       Dan Cryer <dan@block8.co.uk>
* @author       Steve Kamerman <stevekamerman@gmail.com>
* @package      PHPCI
* @subpackage   Plugins
*/
class FTPDeployPHPCI implements \PHPCI\Plugin
{
    
    public function __construct(Builder $phpci, Build $build, array $options = array())
    {
        $this->phpci = $phpci;
        $this->build = $build;
        $this->options = $options;

        //$phpci->getConfig('complete')
    }

    /**
    * Connects to MySQL and runs a specified set of queries.
    * @return boolean
    */
    public function execute()
    {
        return true;
    }
}

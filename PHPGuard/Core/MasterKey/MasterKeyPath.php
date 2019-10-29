<?php

/**
 * @author  Baha2r
 * @license MIT
 * Date: 30/Oct/2019 01:02 AM
 *
 * This trait find absolute path of master key directory
 **/

namespace PHPGuard\Core\MasterKey;


trait MasterKeyPath
{

    /**
     * Find absolute path of master key directory
     *
     * @return string returns absolute path of master key directory
     */
    private function getMasterKeyPath()
    {
        return __DIR__;
    }

}
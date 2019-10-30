<?php

/**
 * @author  Baha2r
 * @license MIT
 * Date: 18/Oct/2019 02:20 AM
 *
 * This trait find absolute path of assets directory
 **/

namespace PHPGuard\Core;


trait AssetPath
{

    /**
     * Find absolute path of assets directory
     *
     * @return string returns absolute path of assets directory
     */
    private function getAbsolutePath()
    {
        return __DIR__;
    }
}
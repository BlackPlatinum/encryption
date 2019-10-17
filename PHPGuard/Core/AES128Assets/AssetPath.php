<?php

/**
 * @author Baha2r
 * @license MIT
 * Date: 18/Oct/2019
 *
 * This class find absolute path of assets directory
 **/

namespace PHPGuard\Core\AES128Assets;


abstract class AssetPath
{

    /**
     * Find absolute path of assets directory
     * @return string returns absolute path of assets directory
     */
    public static function getAbsolutePath()
    {
        return __DIR__;
    }
}
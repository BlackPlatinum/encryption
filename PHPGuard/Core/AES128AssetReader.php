<?php

/**
 * @author Baha2r
 * @license MIT
 * Date: 16/Oct/2019
 *
 * Main Reader class to read encryption key and initial vector from file
 **/

namespace PHPGuard\Core;


use RuntimeException;
use PHPGuard\Core\AES128Assets\AssetPath;

abstract class AES128AssetReader
{

    /**
     * AssetsPath trait is active now
     */
    use AssetPath;

    /**
     * Decodes binary values to unsigned chars
     * @param array $bytes Input byte array
     * @return string returns decoded byte array $bytes
     */
    private function compute($bytes)
    {
        $m = -1;
        $s = 51;
        $buff = array();
        for ($i = 1; $i <= count($bytes); $i++)
            $buff[] = (($bytes[$i] * $m) + $s);
        return implode(array_map("chr", $buff));
    }


    /**
     * Converts binary file key to unsigned chars
     * @return string returns key value
     * @throws RuntimeException throws exception if key file is not found
     */
    protected function readKey()
    {
        $path = $this->getAbsolutePath() . "/k";
        if (!is_file($path) || !file_exists($path))
            throw new RuntimeException("File not found!");
        $size = filesize($path);
        $handle = fopen($path, "rb");
        $binary = fread($handle, $size);
        fclose($handle);
        $barr = unpack("c*", $binary);
        return $this->compute($barr);
    }


    /**
     * Convert binary file initial vector to unsigned chars
     * @return string returns initial vector value
     * @throws RuntimeException throws exception if initial vector file is not found
     */
    protected function readIV()
    {
        $path = $this->getAbsolutePath() . "/iv";
        if (!is_file($path) || !file_exists($path))
            throw new RuntimeException("File not found!");
        $size = filesize($path);
        $handle = fopen($path, "rb");
        $binary = fread($handle, $size);
        fclose($handle);
        $barr = unpack("c*", $binary);
        return $this->compute($barr);
    }
}
<?php

/**
 * @author  Baha2r
 * @license MIT
 * Date: 16/Oct/2019 22:16 PM
 *
 * Main Reader class to read encryption key and initial vector from file
 **/

namespace PHPGuard\Core;


use PHPGuard\Hash\Hash;
use RuntimeException;


abstract class AssetReader
{
    // Load AssetPath trait
    use AssetPath;

    /**
     * Decodes binary values to unsigned chars
     *
     * @param  array  $bytes  Input byte array
     *
     * @return string returns decoded byte array $bytes
     *
     * @deprecated since 1.2.0
     */
    private function compute($bytes)
    {
        $m = -1;
        $s = 51;
        $buff = array();
        for ($i = 1; $i <= count($bytes); $i++) {
            $buff[] = (($bytes[$i] * $m) + $s);
        }
        return implode(array_map("chr", $buff));
    }


    /**
     * Converts each element of an array to a character and concat them all to a binary or normal string
     *
     * @param  array  $array  the input array
     *
     * @return string return a binary or normal string
     *
     * @deprecated since 1.5.2
     */
    private function arrayToString($array)
    {
        return implode(array_map("chr", $array));
    }


    /**
     * Reads content of a binary file
     *
     * @param  string  $path  path of the binary file
     *
     * @return string return content of binary file
     */
    private function reader($path)
    {
        $masterKey = substr(Hash::sha512(shell_exec($this->getAbsolutePath()."/MasterKey/./mk")), 73, 32);
        $masterIV = substr(Hash::sha512(shell_exec($this->getAbsolutePath()."/MasterIV/./miv")), 87, 16);
        $size = filesize($path);
        $handle = fopen($path, "r");
        $content = fread($handle, $size);
        fclose($handle);
        $decrypted = openssl_decrypt($content, "AES-256-CBC", $masterKey, 0, $masterIV);
        return $decrypted;
    }


    /**
     * Converts binary file key to binary string
     *
     * @return string returns key value
     * @throws RuntimeException throws exception if key file is not found
     */
    protected function readKey128()
    {
        $path = $this->getAbsolutePath()."/AES128Assets/k";
        if (!is_file($path) || !file_exists($path)) {
            throw new RuntimeException("File $path not found!");
        }
        return $this->reader($path);
    }


    /**
     * Convert binary file initial vector to binary string
     *
     * @return string returns initial vector value
     * @throws RuntimeException throws exception if initial vector file is not found
     */
    protected function readIV128()
    {
        $path = $this->getAbsolutePath()."/AES128Assets/iv";
        if (!is_file($path) || !file_exists($path)) {
            throw new RuntimeException("File $path not found!");
        }
        return $this->reader($path);
    }


    /**
     * Converts binary file key to binary string
     *
     * @return string returns key value
     * @throws RuntimeException throws exception if key file is not found
     */
    protected function readKey256()
    {
        $path = $this->getAbsolutePath()."/AES256Assets/k";
        if (!is_file($path) || !file_exists($path)) {
            throw new RuntimeException("File $path not found!");
        }
        return $this->reader($path);
    }


    /**
     * Convert binary file initial vector to binary string
     *
     * @return string returns initial vector value
     * @throws RuntimeException throws exception if initial vector file is not found
     */
    protected function readIV256()
    {
        $path = $this->getAbsolutePath()."/AES256Assets/iv";
        if (!is_file($path) || !file_exists($path)) {
            throw new RuntimeException("File $path not found!");
        }
        return $this->reader($path);
    }
}
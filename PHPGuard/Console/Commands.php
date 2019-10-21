<?php

/**
 * @author Baha2r
 * @license MIT
 * Date: 22/Oct/2019
 *
 * Lead commands class
 **/

namespace PHPGuard\Console;


use Symfony\Component\Console\Command\Command;
use PHPGuard\Core\AssetPath;

class Commands extends Command
{
    // Load AssetPath
    use AssetPath;

    // Algorithm name
    private const AES128 = "AES-128-CBC";

    // Algorithm name
    private const AES256 = "AES-256-CBC";

    // Length of key
    private const KEY128Len = 16;

    // Length of key
    private const KEY256Len = 32;

    // Assets path
    private $path;

    // Constructor
    public function __construct(string $name = null)
    {
        parent::__construct($name);
    }

    protected function changeMode()
    {
        $this->path = $this->getAbsolutePath() . "/AES128Assets/k";
        chmod($this->path, 0400);
        $this->path = $this->getAbsolutePath() . "/AES128Assets/iv";
        chmod($this->path, 0400);
        $this->path = $this->getAbsolutePath() . "/AES256Assets/k";
        chmod($this->path, 0400);
        $this->path = $this->getAbsolutePath() . "/AES256Assets/iv";
        chmod($this->path, 0400);
    }


    protected function changeOwner()
    {
        $this->path = $this->getAbsolutePath() . "/AES128Assets/k";
        chown($this->path, "root");
        $this->path = $this->getAbsolutePath() . "/AES128Assets/iv";
        chown($this->path, "root");
        $this->path = $this->getAbsolutePath() . "/AES256Assets/k";
        chown($this->path, "root");
        $this->path = $this->getAbsolutePath() . "/AES256Assets/iv";
        chown($this->path, "root");
    }


    protected function generateKey()
    {
        // Generates key file for AES-128-CBC
        $this->path = $this->getAbsolutePath() . "/AES128Assets/k";
        $randoms = openssl_random_pseudo_bytes(self::KEY128Len);
        $handle = fopen($this->path, "w+b");
        fwrite($handle, $randoms);
        fclose($handle);

        // Generates key file for AES-256-CBC
        $this->path = $path = $this->getAbsolutePath() . "/AES256Assets/k";
        $randoms = openssl_random_pseudo_bytes(self::KEY256Len);
        $handle = fopen($this->path, "w+b");
        fwrite($handle, $randoms);
        fclose($handle);
    }


    protected function generateIv()
    {
        // Generates iv file for AES-128-CBC
        $this->path = $this->getAbsolutePath() . "/AES128Assets/iv";
        $randoms = openssl_random_pseudo_bytes(openssl_cipher_iv_length(self::AES128));
        $handle = fopen($this->path, "w+b");
        fwrite($handle, $randoms);
        fclose($handle);

        // Generates iv file for AES-256-CBC
        $this->path = $this->getAbsolutePath() . "/AES256Assets/iv";
        $randoms = openssl_random_pseudo_bytes(openssl_cipher_iv_length(self::AES256));
        $handle = fopen($this->path, "w+b");
        fwrite($handle, $randoms);
        fclose($handle);
    }


    protected function removeKeys()
    {
        $this->path = $this->getAbsolutePath() . "/AES128Assets/k";
        unlink($this->path);
        $this->path = $this->getAbsolutePath() . "/AES256Assets/k";
        unlink($this->path);
    }


    protected function removeIVs()
    {
        $this->path = $this->getAbsolutePath() . "/AES128Assets/iv";
        unlink($this->path);
        $this->path = $this->getAbsolutePath() . "/AES256Assets/iv";
        unlink($this->path);
    }
}
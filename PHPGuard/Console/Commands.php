<?php

/**
 * @author Baha2r
 * @license MIT
 * Date: 22/Oct/2019
 *
 * Lead commands class
 **/

namespace PHPGuard\Console;


use RuntimeException;
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


    private function fileExists($file)
    {
        return file_exists($file);
    }

    protected function changeMode()
    {
        $this->path = $this->getAbsolutePath() . "/AES128Assets/k";
        if (!$this->fileExists($this->path))
            throw new RuntimeException("File doesn't exist!");
        chmod($this->path, 0400);
        $this->path = $this->getAbsolutePath() . "/AES128Assets/iv";
        if (!$this->fileExists($this->path))
            throw new RuntimeException("File doesn't exist!");
        chmod($this->path, 0400);
        $this->path = $this->getAbsolutePath() . "/AES256Assets/k";
        if (!$this->fileExists($this->path))
            throw new RuntimeException("File doesn't exist!");
        chmod($this->path, 0400);
        $this->path = $this->getAbsolutePath() . "/AES256Assets/iv";
        if (!$this->fileExists($this->path))
            throw new RuntimeException("File doesn't exist!");
        $r = chmod($this->path, 0400);
        return $r;
    }


    protected function changeOwner($owner)
    {
        $this->path = $this->getAbsolutePath() . "/AES128Assets/k";
        if (!$this->fileExists($this->path))
            throw new RuntimeException("File doesn't exist!");
        chown($this->path, $owner);
        $this->path = $this->getAbsolutePath() . "/AES128Assets/iv";
        if (!$this->fileExists($this->path))
            throw new RuntimeException("File doesn't exist!");
        chown($this->path, $owner);
        $this->path = $this->getAbsolutePath() . "/AES256Assets/k";
        if (!$this->fileExists($this->path))
            throw new RuntimeException("File doesn't exist!");
        chown($this->path, $owner);
        $this->path = $this->getAbsolutePath() . "/AES256Assets/iv";
        if (!$this->fileExists($this->path))
            throw new RuntimeException("File doesn't exist!");
        $r = chown($this->path, $owner);
        return $r;
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
        return $handle;
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
        return $handle;
    }


    protected function removeKeys()
    {
        $this->path = $this->getAbsolutePath() . "/AES128Assets/k";
        if (!$this->fileExists($this->path))
            throw new RuntimeException("File doesn't exist!");
        unlink($this->path);
        $this->path = $this->getAbsolutePath() . "/AES256Assets/k";
        if (!$this->fileExists($this->path))
            throw new RuntimeException("File doesn't exist!");
        $r = unlink($this->path);
        return $r;
    }


    protected function removeIVs()
    {
        $this->path = $this->getAbsolutePath() . "/AES128Assets/iv";
        if (!$this->fileExists($this->path))
            throw new RuntimeException("File doesn't exist!");
        unlink($this->path);
        $this->path = $this->getAbsolutePath() . "/AES256Assets/iv";
        if (!$this->fileExists($this->path))
            throw new RuntimeException("File doesn't exist!");
        $r = unlink($this->path);
        return $r;
    }


    protected function config($mode, $owner)
    {
        $mode = intval($mode, 8);
        $this->path = $this->getAbsolutePath() . "/AES128Assets/k";
        if (!$this->fileExists($this->path))
            throw new RuntimeException("File doesn't exist!");
        chmod($this->path, $mode);
        $this->path = $this->getAbsolutePath() . "/AES128Assets/iv";
        if (!$this->fileExists($this->path))
            throw new RuntimeException("File doesn't exist!");
        chmod($this->path, $mode);
        $this->path = $this->getAbsolutePath() . "/AES256Assets/k";
        if (!$this->fileExists($this->path))
            throw new RuntimeException("File doesn't exist!");
        chmod($this->path, $mode);
        $this->path = $this->getAbsolutePath() . "/AES256Assets/iv";
        if (!$this->fileExists($this->path))
            throw new RuntimeException("File doesn't exist!");
        chmod($this->path, $mode);

        $this->path = $this->getAbsolutePath() . "/AES128Assets/k";
        if (!$this->fileExists($this->path))
            throw new RuntimeException("File doesn't exist!");
        chown($this->path, $owner);
        $this->path = $this->getAbsolutePath() . "/AES128Assets/iv";
        if (!$this->fileExists($this->path))
            throw new RuntimeException("File doesn't exist!");
        chown($this->path, $owner);
        $this->path = $this->getAbsolutePath() . "/AES256Assets/k";
        if (!$this->fileExists($this->path))
            throw new RuntimeException("File doesn't exist!");
        chown($this->path, $owner);
        $this->path = $this->getAbsolutePath() . "/AES256Assets/iv";
        if (!$this->fileExists($this->path))
            throw new RuntimeException("File doesn't exist!");
        $r = chown($this->path, $owner);
        return $r;
    }
}
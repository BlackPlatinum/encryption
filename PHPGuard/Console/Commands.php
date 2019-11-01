<?php

/**
 * @author  Baha2r
 * @license MIT
 * Date: 22/Oct/2019 23:28 PM
 *
 * Lead commands class
 **/

namespace PHPGuard\Console;


use PHPGuard\Crypto\Crypto;
use PHPGuard\Hash\Hash;
use PHPGuard\Core\AssetPath;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Command\Command;

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
        $this->path = $this->getAbsolutePath()."/AES128Assets/k";
        if (!$this->fileExists($this->path)) {
            throw new RuntimeException("[RuntimeException]:\n\nFile $this->path doesn't exist!");
        }
        $r = chmod($this->path, 0400);
        if (!$r) {
            return false;
        }
        $this->path = $this->getAbsolutePath()."/AES128Assets/iv";
        if (!$this->fileExists($this->path)) {
            throw new RuntimeException("[RuntimeException]:\n\nFile $this->path doesn't exist!");
        }
        $r = chmod($this->path, 0400);
        if (!$r) {
            return false;
        }
        $this->path = $this->getAbsolutePath()."/AES256Assets/k";
        if (!$this->fileExists($this->path)) {
            throw new RuntimeException("[RuntimeException]:\n\nFile $this->path doesn't exist!");
        }
        $r = chmod($this->path, 0400);
        if (!$r) {
            return false;
        }
        $this->path = $this->getAbsolutePath()."/AES256Assets/iv";
        if (!$this->fileExists($this->path)) {
            throw new RuntimeException("[RuntimeException]:\n\nFile $this->path doesn't exist!");
        }
        $r = chmod($this->path, 0400);
        return $r;
    }


    protected function changeOwner($owner)
    {
        $this->path = $this->getAbsolutePath()."/AES128Assets/k";
        if (!$this->fileExists($this->path)) {
            throw new RuntimeException("[RuntimeException]:\n\nFile $this->path doesn't exist!");
        }
        $r = chown($this->path, $owner);
        if (!$r) {
            return false;
        }
        $this->path = $this->getAbsolutePath()."/AES128Assets/iv";
        if (!$this->fileExists($this->path)) {
            throw new RuntimeException("[RuntimeException]:\n\nFile $this->path doesn't exist!");
        }
        $r = chown($this->path, $owner);
        if (!$r) {
            return false;
        }
        $this->path = $this->getAbsolutePath()."/AES256Assets/k";
        if (!$this->fileExists($this->path)) {
            throw new RuntimeException("[RuntimeException]:\n\nFile $this->path doesn't exist!");
        }
        $r = chown($this->path, $owner);
        if (!$r) {
            return false;
        }
        $this->path = $this->getAbsolutePath()."/AES256Assets/iv";
        if (!$this->fileExists($this->path)) {
            throw new RuntimeException("[RuntimeException]:\n\nFile $this->path doesn't exist!");
        }
        $r = chown($this->path, $owner);
        return $r;
    }


    protected function generateKey()
    {
        // Generates key file for AES-128-CBC
        if (!$this->fileExists($this->getAbsolutePath()."/AES128Assets")) {
            mkdir($this->getAbsolutePath()."/AES128Assets", 0400, true);
        }
        $this->path = $this->getAbsolutePath()."/AES128Assets/k";
        $randoms = openssl_random_pseudo_bytes(self::KEY128Len);
        $handle = fopen($this->path, "w+b");
        fwrite($handle, $randoms);
        $r = fclose($handle);
        if (!$r) {
            return false;
        }

        // Generates key file for AES-256-CBC
        if (!$this->fileExists($this->getAbsolutePath()."/AES256Assets")) {
            mkdir($this->getAbsolutePath()."/AES256Assets", 0400, true);
        }
        $this->path = $path = $this->getAbsolutePath()."/AES256Assets/k";
        $randoms = openssl_random_pseudo_bytes(self::KEY256Len);
        $handle = fopen($this->path, "w+b");
        fwrite($handle, $randoms);
        $r = fclose($handle);
        return $r;
    }


    protected function generateIv()
    {
        // Generates iv file for AES-128-CBC
        if (!$this->fileExists($this->getAbsolutePath()."/AES128Assets")) {
            mkdir($this->getAbsolutePath()."/AES128Assets", 0400, true);
        }
        $this->path = $this->getAbsolutePath()."/AES128Assets/iv";
        $randoms = openssl_random_pseudo_bytes(openssl_cipher_iv_length(self::AES128));
        $handle = fopen($this->path, "w+b");
        fwrite($handle, $randoms);
        $r = fclose($handle);
        if (!$r) {
            return false;
        }

        // Generates iv file for AES-256-CBC
        if (!$this->fileExists($this->getAbsolutePath()."/AES256Assets")) {
            mkdir($this->getAbsolutePath()."/AES256Assets", 0400, true);
        }
        $this->path = $this->getAbsolutePath()."/AES256Assets/iv";
        $randoms = openssl_random_pseudo_bytes(openssl_cipher_iv_length(self::AES256));
        $handle = fopen($this->path, "w+b");
        fwrite($handle, $randoms);
        $r = fclose($handle);
        return $r;
    }


    protected function removeKeys()
    {
        $this->path = $this->getAbsolutePath()."/AES128Assets/k";
        if (!$this->fileExists($this->path)) {
            throw new RuntimeException("[RuntimeException]:\n\nFile $this->path doesn't exist!");
        }
        $r = unlink($this->path);
        if (!$r) {
            return false;
        }
        $this->path = $this->getAbsolutePath()."/AES256Assets/k";
        if (!$this->fileExists($this->path)) {
            throw new RuntimeException("[RuntimeException]:\n\nFile $this->path doesn't exist!");
        }
        $r = unlink($this->path);
        return $r;
    }


    protected function removeIVs()
    {
        $this->path = $this->getAbsolutePath()."/AES128Assets/iv";
        if (!$this->fileExists($this->path)) {
            throw new RuntimeException("[RuntimeException]:\n\nFile $this->path doesn't exist!");
        }
        $r = unlink($this->path);
        if (!$r) {
            return false;
        }
        $this->path = $this->getAbsolutePath()."/AES256Assets/iv";
        if (!$this->fileExists($this->path)) {
            throw new RuntimeException("[RuntimeException]:\n\nFile $this->path doesn't exist!");
        }
        $r = unlink($this->path);
        return $r;
    }


    protected function config($mode, $owner)
    {
        $mode = intval($mode, 8);
        $this->path = $this->getAbsolutePath()."/AES128Assets/k";
        if (!$this->fileExists($this->path)) {
            throw new RuntimeException("[RuntimeException]:\n\nFile $this->path doesn't exist!");
        }
        $r = chmod($this->path, $mode);
        if (!$r) {
            return false;
        }
        $this->path = $this->getAbsolutePath()."/AES128Assets/iv";
        if (!$this->fileExists($this->path)) {
            throw new RuntimeException("[RuntimeException]:\n\nFile $this->path doesn't exist!");
        }
        $r = chmod($this->path, $mode);
        if (!$r) {
            return false;
        }
        $this->path = $this->getAbsolutePath()."/AES256Assets/k";
        if (!$this->fileExists($this->path)) {
            throw new RuntimeException("[RuntimeException]:\n\nFile $this->path doesn't exist!");
        }
        $r = chmod($this->path, $mode);
        if (!$r) {
            return false;
        }
        $this->path = $this->getAbsolutePath()."/AES256Assets/iv";
        if (!$this->fileExists($this->path)) {
            throw new RuntimeException("[RuntimeException]:\n\nFile $this->path doesn't exist!");
        }
        $r = chmod($this->path, $mode);
        if (!$r) {
            return false;
        }

        $this->path = $this->getAbsolutePath()."/AES128Assets/k";
        if (!$this->fileExists($this->path)) {
            throw new RuntimeException("[RuntimeException]:\n\nFile $this->path doesn't exist!");
        }
        $r = chown($this->path, $owner);
        if (!$r) {
            return false;
        }
        $this->path = $this->getAbsolutePath()."/AES128Assets/iv";
        if (!$this->fileExists($this->path)) {
            throw new RuntimeException("[RuntimeException]:\n\nFile $this->path doesn't exist!");
        }
        $r = chown($this->path, $owner);
        if (!$r) {
            return false;
        }
        $this->path = $this->getAbsolutePath()."/AES256Assets/k";
        if (!$this->fileExists($this->path)) {
            throw new RuntimeException("[RuntimeException]:\n\nFile $this->path doesn't exist!");
        }
        $r = chown($this->path, $owner);
        if (!$r) {
            return false;
        }
        $this->path = $this->getAbsolutePath()."/AES256Assets/iv";
        if (!$this->fileExists($this->path)) {
            throw new RuntimeException("[RuntimeException]:\n\nFile $this->path doesn't exist!");
        }
        $r = chown($this->path, $owner);
        return $r;
    }


    protected function moveKeys($newName128, $newName256)
    {
        $this->path = $this->getAbsolutePath()."/AES128Assets/k";
        if (!$this->fileExists($this->path)) {
            throw new RuntimeException("[RuntimeException]:\n\nFile $this->path doesn't exist!");
        }
        $r = rename($this->path, $newName128);
        if (!$r) {
            return false;
        }
        $this->path = $this->getAbsolutePath()."/AES256Assets/k";
        if (!$this->fileExists($this->path)) {
            throw new RuntimeException("[RuntimeException]:\n\nFile $this->path doesn't exist!");
        }
        $r = rename($this->path, $newName256);
        return $r;
    }


    protected function moveIvs($newName128, $newName256)
    {
        $this->path = $this->getAbsolutePath()."/AES128Assets/iv";
        if (!$this->fileExists($this->path)) {
            throw new RuntimeException("[RuntimeException]:\n\nFile $this->path doesn't exist!");
        }
        $r = rename($this->path, $newName128);
        if (!$r) {
            return false;
        }
        $this->path = $this->getAbsolutePath()."/AES256Assets/iv";
        if (!$this->fileExists($this->path)) {
            throw new RuntimeException("[RuntimeException]:\n\nFile $this->path doesn't exist!");
        }
        $r = rename($this->path, $newName256);
        return $r;
    }


    protected function test128($value)
    {
        $aes = new Crypto();
        $e = $aes->encryptString($value);
        return [$e, $aes->decryptString($e)];
    }


    protected function test256($value)
    {
        $aes = new Crypto("AES-256-CBC");
        $e = $aes->encryptString($value);
        return [$e, $aes->decryptString($e)];
    }


    protected function encryptKey()
    {
        // Encrypt AES 128 Key
        $masterKey = substr(Hash::sha512(shell_exec($this->getAbsolutePath()."/MasterKey/./mk")), 73, 32);
        $masterIV = substr(Hash::sha512(shell_exec($this->getAbsolutePath()."/MasterIV/./miv")), 87, 16);
        $this->path = $this->getAbsolutePath()."/AES128Assets/k";
        if (!$this->fileExists($this->path)) {
            throw new RuntimeException("[RuntimeException]:\n\nFile $this->path doesn't exist!");
        }
        $size = filesize($this->path);
        $handle = fopen($this->path, "r+b");
        $content = fread($handle, $size);
        fwrite($handle, "");
        fclose($handle);
        $encrypted = openssl_encrypt($content, "AES-256-CBC", $masterKey, 0, $masterIV);
        $handle = fopen($this->path, "r+");
        fwrite($handle, $encrypted);
        $r = fclose($handle);
        if (!$r) {
            return false;
        }

        // Encrypt AES 256 Key
        $this->path = $this->getAbsolutePath()."/AES256Assets/k";
        if (!$this->fileExists($this->path)) {
            throw new RuntimeException("[RuntimeException]:\n\nFile $this->path doesn't exist!");
        }
        $size = filesize($this->path);
        $handle = fopen($this->path, "r+b");
        $content = fread($handle, $size);
        fwrite($handle, "");
        fclose($handle);
        $encrypted = openssl_encrypt($content, "AES-256-CBC", $masterKey, 0, $masterIV);
        $handle = fopen($this->path, "r+");
        fwrite($handle, $encrypted);
        $r = fclose($handle);
        return $r;
    }


    protected function encryptIV()
    {
        // Encrypt AES 128 IV
        $masterKey = substr(Hash::sha512(shell_exec($this->getAbsolutePath()."/MasterKey/./mk")), 73, 32);
        $masterIV = substr(Hash::sha512(shell_exec($this->getAbsolutePath()."/MasterIV/./miv")), 87, 16);
        $this->path = $this->getAbsolutePath()."/AES128Assets/iv";
        if (!$this->fileExists($this->path)) {
            throw new RuntimeException("[RuntimeException]:\n\nFile $this->path doesn't exist!");
        }
        $size = filesize($this->path);
        $handle = fopen($this->path, "r+b");
        $content = fread($handle, $size);
        fwrite($handle, "");
        fclose($handle);
        $encrypted = openssl_encrypt($content, "AES-256-CBC", $masterKey, 0, $masterIV);
        $handle = fopen($this->path, "r+");
        fwrite($handle, $encrypted);
        $r = fclose($handle);
        if (!$r) {
            return false;
        }

        // Encrypt AES 256 IV
        $this->path = $this->getAbsolutePath()."/AES256Assets/iv";
        if (!$this->fileExists($this->path)) {
            throw new RuntimeException("[RuntimeException]:\n\nFile $this->path doesn't exist!");
        }
        $size = filesize($this->path);
        $handle = fopen($this->path, "r+b");
        $content = fread($handle, $size);
        fwrite($handle, "");
        fclose($handle);
        $encrypted = openssl_encrypt($content, "AES-256-CBC", $masterKey, 0, $masterIV);
        $handle = fopen($this->path, "r+");
        fwrite($handle, $encrypted);
        $r = fclose($handle);
        return $r;
    }


    protected function compileMasters()
    {
        $this->path = $this->getAbsolutePath()."/MasterKey/master_key.cpp";
        $des = $this->getAbsolutePath()."/MasterKey/mk";
        exec("g++ -o $des $this->path");
        chmod($des, 0100);
        if (!$this->fileExists($des)) {
            return false;
        }
        $this->path = $this->getAbsolutePath()."/MasterIV/master_iv.cpp";
        $des = $this->getAbsolutePath()."/MasterIV/miv";
        exec("g++ -o $des $this->path");
        chmod($des, 0100);
        $r = $this->fileExists($des);
        return $r;
    }
}
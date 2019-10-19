PHPGuard
=======
A security cryptography library for PHP. It can be used by different frameworks or pure PHP

Features
--------
Supports: AES-128-CBC, AES-256-CBC, MD5, SHA1, SHA224, SHA256, SHA384, SHA512

Installation
------------
Use [Composer] to install the package:

```
$ composer require baha2rmirzazadeh/phpguard
```

Example
-------

```php
use PHPGuard\AES\AES;


$aes = new AES();
$c = $aes->encrypt(["Name" => "Logan", "LastName" => "Lormen", "Age" => 22, "IsStudent" => true, "Courses"=>["Math", "Ecocnomy", "Chemistry"]]);
print $c . "\n";
print_r($aes->decrypt($c));


$aes = new AES("AES-128-CBC", true);
$c = $aes->encryptString("Hello! I am plaintext :)");
print $c . "\n";
print $aes->decryptString($c);


use PHPGuard\Hash\Hash;

print Hash::sha224([1, 3, 4, 5, 7], true);
print Hash::sha512("Hello PHPGuard!");
```

### Classes and Methods description
All of classes and methods have documentation, you can read them and figure out how they work

Authors
-------

* [Bahador Mirzazadeh]
* E-Mail: [baha2r.mirzazadeh98@gmail.com]

License
-------

All contents of this package library are licensed under the [MIT license].   

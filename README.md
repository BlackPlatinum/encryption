PHPGuard
=======
A security cryptography library for PHP. It can be used by different frameworks or pure PHP

Features
--------
Cryptography supports: AES-128-CBC, AES-192, AES-256-CBC, CAST5-CBC, BlowFish-CBC

Hashing supports: SHA3-512, SHA512, WHIRLPOOL

PHPGuard Console App
--------------------
A command line interface designed for this library due to set a encryption key, test system etc.

Some of commands:

* [php guard set:key]
* [php guard fresh]

`How to use console app?`

For using console app just open up a terminal where `guard` is and type: `php guard`.
All commands are documented and operational.


Installation
------------
Use [Composer] to install the package:

```
$ composer require baha2rmirzazadeh/phpguard
```

Examples
-------

```php
use PHPGuard\Core\Key;
use PHPGuard\Crypto\Crypto;

$cr = new Crypto("CAST5-CBC");
$cr->setKey(Key::getKey());
$c = $cr->encrypt([
        "Name"      => "Baha2r",
        "LastName"  => "Mirzazadeh",
        "Age"       => 22,
        "IsStudent" => true,
        "Courses"   => ["Math", "Ecocnomy", "Chemistry"]
]);
print $c."\n";
print_r($cr->decrypt($c));


$cr = $cr->setCipher("AES-192-CBC");
$cr->setKey(Crypto::generateKey());
$c = $cr->encrypt([
        "Name"      => "Baha2r",
        "LastName"  => "Mirzazadeh",
        "Age"       => 22,
        "IsStudent" => true,
        "Courses"   => ["Math", "Ecocnomy", "Chemistry"]
]);
print $c."\n";
print_r($cr->decrypt($c));

print_r(Crypto::supported());


use PHPGuard\Hashing\Hash;

print Hash::makeHash([1, 2, 3, 4])
print Hash::makeMAC("Hello PHPGuard!", "key");
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

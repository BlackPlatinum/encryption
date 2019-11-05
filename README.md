PHPGuard
=======
A security cryptography library for PHP. It can be used by different frameworks or pure PHP

Features
--------
Supports: AES-128-CBC, AES-256-CBC, RC4, CAST5-CBC, BlowFish-CBC, MD5, SHA1, SHA224, SHA256, SHA384, SHA512

PHPGuard Console App
--------------------
A command line interface designed for this library due to set a admin password.

Command:

* [php guard set:adminkey]

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
use PHPGuard\Crypto\Crypto;

$cr = new Crypto();

$cr->setKey("somthing");
$cr->setIV("somthing else");
$c = $cr->encrypt([
        "Name"      => "Baha2r",
        "LastName"  => "Mirzazadeh",
        "Age"       => 22,
        "IsStudent" => true,
        "Courses"   => ["Math", "Ecocnomy", "Chemistry"]
]);
print $c."\n";
print_r($cr->decrypt($c));

$cr = $cr->setCipher("RC4");

$cr->setKey("fbhff vsdfgjhg");
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

BlackPlatinum Encryption Component
=======
Features
--------
Cryptography supports: AES-128-CBC, AES-192, AES-256-CBC, CAST5-CBC, BlowFish-CBC

console app
--------------------
A command line interface designed for this component due to set a encryption key, test system etc.

Some of commands:

* [php guard key:set]
* [php guard key:generate]
* [php guard fresh]

`How to use console app?`

For using console app just open up a terminal where `guard` is and type: `php guard`.
All commands are documented and operational.


Installation
------------
Use [Composer] to install the package:

```
$ composer require blackplatinum/encryption
```

Examples
-------

```php
use BlackPlatinum\Encryption\Crypto\Key;
use BlackPlatinum\Encryption\Crypto\Crypto;

$cr = new Crypto("CAST5-CBC");
$cr->setKey(Key::getKey());
$c = $cr->encrypt([
        "Name"      => "John",
        "LastName"  => "White",
        "Age"       => 22,
        "IsStudent" => true,
        "Courses"   => ["Math", "Ecocnomy", "Chemistry"]
]);
print $c."\n";
print_r($cr->decrypt($c));


$cr = $cr->setCipher("AES-192-CBC");
$cr->setKey(Crypto::generateKey());
$c = $cr->encrypt([
        "Name"      => "John",
        "LastName"  => "White",
        "Age"       => 22,
        "IsStudent" => true,
        "Courses"   => ["Math", "Ecocnomy", "Chemistry"]
]);
print $c."\n";
print_r($cr->decrypt($c));

print_r(Crypto::supported());
```

### Classes and Methods description
All of classes and methods have documentation, you can read them and figure out how they work

Authors
-------

* [BlackPlatinum Developers]
* E-Mail: [blackplatinum2019@gmail.com]

License
-------

All contents of this component are licensed under the [MIT license].
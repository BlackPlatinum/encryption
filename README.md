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
use BlackPlatinum\Encryption\Crypto\Symmetric\Crypto;
use BlackPlatinum\Encryption\KeyManager\KeyManager;

$cipher = (new Crypto('CAST5-CBC'))->setKey(KeyManager::getKey())->encrypt(
    [
        'Name' => 'John',
        'LastName' => 'LastName',
        'Age' => 22,
        'IsStudent' => true,
        'Courses' => ['Math', 'Economy', 'Chemistry']
    ]
);
print $cipher;

$plainText = (new Crypto('BF-CBC'))->setKey(KeyManager::getKey())->decrypt('eyJpdiI6Ik05RE9...');
print_r($plainText);


use BlackPlatinum\Encryption\Crypto\Asymmetric\Crypto;
$crypto = new Crypto();

$cipher = $crypto->publicKeyEncrypt(
    [
        'Name' => 'John',
        'LastName' => 'LastName',
        'Age' => 22,
        'IsStudent' => true,
        'Courses' => ['Math', 'Economy', 'Chemistry']
    ], KeyManager::getRSAPublicKey()
);
print $cipher . "\n";

print_r($crypto->privateKeyDecrypt($cipher, KeyManager::getRSAPrivateKey()));
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
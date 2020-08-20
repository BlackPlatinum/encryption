<?php

/**
 * @author  BlackPlatinum Developers
 * @license MIT
 * Date: 2/Aug/2020 17:30
 **/

namespace BlackPlatinum\Encryption\Console;

use BlackPlatinum\Encryption\Core\Hashing\Hash;
use BlackPlatinum\Encryption\Support\InteractWithKeyFiles;
use BlackPlatinum\Encryption\Core\Crypto\Asymmetric\PairKeysManager;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

class Command extends SymfonyCommand
{
    use Hash;
    use InteractWithKeyFiles;
    use PairKeysManager;
}

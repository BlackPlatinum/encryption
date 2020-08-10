<?php

/**
 * @author  BlackPlatinum Developers
 * @license MIT
 * Date: 2/Aug/2020 17:30 PM
 **/

namespace BlackPlatinum\Encryption\Console;

use BlackPlatinum\Encryption\Core\Hashing\Hash;
use Symfony\Component\Console\Command\Command;

class BlackplatinumCommand extends Command
{
    use Hash;
}

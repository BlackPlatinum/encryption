<?php

/**
 * @author Baha2r
 * @license MIT
 * Date: 17/Oct/2019
 *
 * Base reader interface
 **/

namespace PHPGuard\Core;


interface Reader
{
    public function readKey();

    public function readIV();

}
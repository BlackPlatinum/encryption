<?php

/**
 * @author  Baha2r
 * @license MIT
 * Date: 13/Nov/2019 00:53 AM
 *
 * Event input handler class
 **/

namespace PHPGuard\Console\EventHandler;


use PHPScanner\Scanner\Scanner;
use Symfony\Contracts\EventDispatcher\Event;

class InputEvent extends Event
{

    /**
     * @var string Event name
     */
    public const EVENT_NAME = "input.event";

    /**
     * @var Scanner Gets input through commandline
     */
    private $scn;


    /**
     * Constructor
     *
     * Make new instance from Scanner object
     */
    public function __construct()
    {
        $this->scn = new Scanner();
    }


    /**
     * Gets entered admin key by admin in commandline
     *
     * @return string Return entered admin key
     */
    public function getInput()
    {
        return $this->scn->next();
    }
}
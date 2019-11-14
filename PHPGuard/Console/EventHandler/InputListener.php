<?php

/**
 * @author  Baha2r
 * @license MIT
 * Date: 13/Nov/2019 00:54 AM
 *
 * Event listener handler class
 **/

namespace PHPGuard\Console\EventHandler;


class InputListener
{

    /**
     * @var string Stores entered admin key
     */
    public static $adminKey;


    /**
     * Constructor
     */
    public function __construct()
    {
        //
    }


    /**
     * @param  InputEvent  $event
     */
    public function onInputEvent(InputEvent $event)
    {
        self::$adminKey = $event->getInput();
    }
}
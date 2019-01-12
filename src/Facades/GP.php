<?php

namespace arifsajal\GpSmsGateway\Facades;

use Illuminate\Support\Facades\Facade;

class GP extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'gpsmsgateway';
    }
}

<?php namespace Duckmk2\Ucenter\Facades;

use Illuminate\Support\Facades\Facade;

class Ucenter extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'ucenter';
    }
}

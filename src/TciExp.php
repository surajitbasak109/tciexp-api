<?php

namespace surajitbasak109\TciExpApi;

use Illuminate\Support\Facades\Facade;

class TciExp extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'tciexp';
    }
}

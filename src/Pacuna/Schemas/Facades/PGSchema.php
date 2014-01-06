<?php namespace Pacuna\Schemas\Facades;

use Illuminate\Support\Facades\Facade;

/**
 *
 */
class PGSchema extends Facade{
    protected static function getFacadeAccessor(){ return 'pgschema';}
}

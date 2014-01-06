<?php namespace Pacuna\Schemas;
use Config;
class Test{

    public function testConfig()
    {
        echo Config::get('schemas::var');
    }
}

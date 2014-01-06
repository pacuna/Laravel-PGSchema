<?php namespace Pacuna\Schemas;
/**
 *
 */
use DB;
class Schemas
{

    public function create($schemaName)
    {
        $query = DB::statement('CREATE SCHEMA '.$schemaName);
    }

    public function switchTo($schemaName = 'public')
    {
        $query = DB::statement('SET search_path TO '.$schemaName);
    }

    public function drop($schemaName)
    {
        $query = DB::statement('DROP SCHEMA '.$schemaName);
    }

}

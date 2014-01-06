<?php namespace Pacuna\Schemas;
/**
 *
 */
use DB;
class Schemas
{
    public function createSchema($schemaName)
    {
        $query = DB::statement('CREATE SCHEMA '.$schemaName);
    }

    public function switchToSchema($schemaName = 'public')
    {
        $query = DB::statement('SET search_path TO '.$schemaName);
    }

    public function dropSchema($schemaName)
    {
        $query = DB::statement('DROP SCHEMA '.$schemaName);
    }

}

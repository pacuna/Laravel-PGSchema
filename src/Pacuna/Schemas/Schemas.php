<?php namespace Pacuna\Schemas;
/**
 *
 */
use DB;
use Artisan;
use Schema;
class Schemas
{
    protected function listTables($schemaName)
    {
        $tables = DB::table('information_schema.tables')
            ->select('table_name')
            ->where('table_schema', '=', $schemaName)
            ->get();

        return $tables;
    }

    protected function tableExists($schemaName, $tableName)
    {
        $tables = $this->listTables($schemaName);
        foreach ($tables as $table) {
            if($table->table_name == $tableName) return true;
        }

        return false;
    }

    public function schemaExists($schemaName)
    {
        $schema = DB::table('information_schema.schemata')
            ->select('schema_name')
            ->where('schema_name', '=', $schemaName)
            ->count();

        return ($schema > 0);
    }

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
        $query = DB::statement('DROP SCHEMA '.$schemaName . ' CASCADE');
    }

    public function migrate($schemaName, $args=[])
    {
        $this->switchTo($schemaName);
        if(!$this->tableExists($schemaName, 'migrations'))
        {
            Artisan::call('migrate:install');
        }

        Artisan::call('migrate', $args);

    }

    public function migrateRefresh($schemaName, $args=[])
    {
        $this->switchTo($schemaName);

        Artisan::call('migrate:refresh', $args);
    }

    public function migrateReset($schemaName, $args=[])
    {
        $this->switchTo($schemaName);

        Artisan::call('migrate:reset', $args);
    }

    public function migrateRollback($schemaName, $args=[])
    {
        $this->switchTo($schemaName);

        Artisan::call('migrate:rollback', $args);
    }

}

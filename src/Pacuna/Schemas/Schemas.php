<?php

namespace Pacuna\Schemas;

use DB;
use Artisan;
use Schema;
use Config;

/**
 * Class Schemas
 *
 * @package Pacuna\Schemas
 */
class Schemas
{
    /**
     * List all the tables for a schema
     *
     * @param string $schemaName
     *
     * @return mixed
     */
    protected function listTables($schemaName)
    {
        $tables = DB::table('information_schema.tables')
            ->select('table_name')
            ->where('table_schema', '=', $schemaName)
            ->get();

        return $tables;
    }

    /**
     * Check to see if a table exists within a schema
     *
     * @param string $schemaName
     * @param string $tableName
     *
     * @return bool
     */
    protected function tableExists($schemaName, $tableName)
    {
        $tables = $this->listTables($schemaName);
        foreach ($tables as $table) {
            if ($table->table_name === $tableName) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check to see if a schema exists
     *
     * @param string $schemaName
     *
     * @return bool
     */
    public function schemaExists($schemaName)
    {
        $schema = DB::table('information_schema.schemata')
            ->select('schema_name')
            ->where('schema_name', '=', $schemaName)
            ->count();

        return ($schema > 0);
    }

    /**
     * Create a new schema
     *
     * @param string $schemaName
     */
    public function create($schemaName)
    {
        $query = DB::statement('CREATE SCHEMA ' . $schemaName);
    }

    /**
     * Set the search_path to the schema name
     *
     * @param string|array $schemaName
     */
    public function switchTo($schemaName = 'public')
    {
        $this->setSchemaInConnection($schemaName);

        if (!is_array($schemaName)) {
            $schemaName = [$schemaName];
        }

        $query = 'SET search_path TO ' . implode(',', $schemaName);


        $result = DB::statement($query);
    }
    
    private function setSchemaInConnection($schemaName)
    {
        $driver = DB::connection()->getConfig('driver');
        $config = Config::get("database.connections.$driver");
        $config['schema'] = $schemaName;

        DB::purge($driver);
        Config::set("database.connections.$driver", $config);
    }

    /**
     * Drop an existing schema
     *
     * @param string $schemaName
     */
    public function drop($schemaName)
    {
        $query = DB::statement('DROP SCHEMA '.$schemaName . ' CASCADE');
    }

    /**
     * Run migrations on a schema
     *
     * @param string $schemaName
     * @param array  $args
     */
    public function migrate($schemaName, $args = [])
    {
        $this->switchTo($schemaName);
        if (!$this->tableExists($schemaName, 'migrations')) {
            Artisan::call('migrate:install');
        }

        Artisan::call('migrate', $args);
    }

    /**
     * Re-run all the migrations on a schema
     *
     * @param string $schemaName
     * @param array  $args
     */
    public function migrateRefresh($schemaName, $args = [])
    {
        $this->switchTo($schemaName);

        Artisan::call('migrate:refresh', $args);
    }

    /**
     * Reverse all migrations on a schema
     *
     * @param string $schemaName
     * @param array  $args
     */
    public function migrateReset($schemaName, $args = [])
    {
        $this->switchTo($schemaName);

        Artisan::call('migrate:reset', $args);
    }

    /**
     * Rollback the latest migration on a schema
     *
     * @param string $schemaName
     * @param array  $args
     */
    public function migrateRollback($schemaName, $args = [])
    {
        $this->switchTo($schemaName);

        Artisan::call('migrate:rollback', $args);
    }

    /**
     * Return the current search path
     *
     * @return string
     */
    public function getSearchPath()
    {
        $query = DB::select('show search_path');
        $searchPath = array_pop($query)->search_path;

        return $searchPath;
    }
}

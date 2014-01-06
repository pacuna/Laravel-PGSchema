# Laravel PGSchema

With this package you can create, switch and drop postgresql schemas
easily. This is very useful when you are working with multi-tenants
applications.

## Installation 

1. Use composer to add the package into your project
using 
`composer require pacuna/schemas:dev-master`

2. Add 'Pacuna\Schemas\SchemasServiceProvider' to your app.php file in the
services providers section.
3. Add 'PGSchema' => 'Pacuna\Schemas\Facades\PGSchema' into the aliases
section

## Usage

Assuming that you have your db configuration ready, meaning that
your default connection is 'pgsql' and your pgsql credentials
are setted in the usual way, you can use the next functions:

### Create new Schema

`PGSchema::create($schemaName)`

### Switch to Schema

`PGSchema::switchTo($schemaName)`

if switchTo is call without arguments, it switches to the public
schema (default)

### Drop Schema

`PGSchema::drop($schemaName)`


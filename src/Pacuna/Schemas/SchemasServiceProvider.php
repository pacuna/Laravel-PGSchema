<?php namespace Pacuna\Schemas;

use Illuminate\Support\ServiceProvider;

class SchemasServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        \App::bind('pgschema', function()
        {
            return new Schemas;
        });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
    }

    public function boot()
    {
        $this->package('pacuna/schemas');
    }

}

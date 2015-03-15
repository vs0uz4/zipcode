<?php namespace Artesaos\ZipCode\Providers;

use Artesaos\ZipCode\ZipCode;
use Illuminate\Support\ServiceProvider;

class ZipCodeServiceProvider extends ServiceProvider {

    /**
     *
     */
    public function boot(){
        $this->loadTranslationsFrom(__DIR__.'/../../../lang', 'artesaos-zipcode');
    }

	/**
     * Register ServiceProvider GuzzleHttp\Client
     * Register ServiceProvider Artesaos\ZipCode\ZipCode
     *
     * @return void
     */
	public function register()
	{
					
		if (isset($this->app['GuzzleHttp\ClientInterface']) === false) 
		{
			$this->app->bind('GuzzleHttp\ClientInterface', 'GuzzleHttp\Client');
		}

		$this->app->bind('Artesaos\ZipCode\Contracts\ZipCodeContract', function($app)
		{			
			return new ZipCode($app['cache'], $app['GuzzleHttp\ClientInterface']);
		});
		
	}

}

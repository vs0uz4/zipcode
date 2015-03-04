<?php namespace Artesaos\ZipCode\Providers;

use Artesaos\ZipCode\ZipCode;
use Illuminate\Support\ServiceProvider;

class ZipCodeServiceProvider extends ServiceProvider {

	public function register()
	{
					
		if (isset($this->app['GuzzleHttp\ClientInterface']) === false) 
		{
			$this->app->bind('GuzzleHttp\ClientInterface', 'GuzzleHttp\Client');
		}

		$this->app->bind('Artesaos\ZipCode\ZipCodeContracts', function($app)
		{			
			return new ZipCode($app['cache'], $app['GuzzleHttp\ClientInterface']);
		});
		
	}

}

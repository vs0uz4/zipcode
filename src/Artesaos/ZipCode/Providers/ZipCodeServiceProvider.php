<?php namespace Artesaos\ZipCode\Providers;

use Artesaos\ZipCode\ZipCode;
use Illuminate\Support\ServiceProvider;

class ZipCodeServiceProvider extends ServiceProvider
{

	public function register()
	{
		$this->app->bind('Artesaos\ZipCode\ZipCodeContracts',function($app){
			return new ZipCode($app['cache']);
		});
	}

}

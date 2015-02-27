<?php namespace Canducci\ZipCode\Providers;

use Canducci\ZipCode\ZipCode;
use Illuminate\Support\ServiceProvider;

class ZipCodeServiceProvider extends ServiceProvider
{

	public function register()
	{
		$this->app->bind('Canducci\ZipCode\ZipCodeContracts',function($app){
			return new ZipCode($app['cache']);
		});
	}

}

<?php namespace Artesaos\ZipCode\Facades;

use Illuminate\Support\Facades\Facade;

class ZipCode extends Facade {

	/**
     * Register Facade of Artesaos\ZipCode\ZipCode
     *
     * @return string
     */
	protected static function getFacadeAccessor()
	{
		return 'Artesaos\ZipCode\ZipCode';
	}
	
}
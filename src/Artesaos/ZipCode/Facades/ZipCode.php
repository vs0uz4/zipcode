<?php namespace Artesaos\ZipCode\Facades;

use Illuminate\Support\Facades\Facade;

class ZipCode extends Facade {

	protected static function getFacadeAccessor()
	{
		return 'Artesaos\ZipCode\ZipCode';
	}
	
}
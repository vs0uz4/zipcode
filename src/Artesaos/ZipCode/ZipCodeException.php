<?php namespace Artesaos\ZipCode;

final class ZipCodeException extends \Exception {

	/**
	 * Construct ZipCodeException
	 *	 
	 * @param $message (string)
	 * @param $code (int)
	 * @param $previous (\Exception)
	 */
    public function __construct($message = "", $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
    
}
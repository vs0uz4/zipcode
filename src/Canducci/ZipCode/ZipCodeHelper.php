<?php namespace {

    if (!function_exists('zipcode'))
    {
        /**
         * @param $value
         * @return Canducci\ZipCode\ZipCode
         * @throws Canducci\ZipCode\ZipCodeException
         */
        function zipcode($value)
        {
            $zip_code = app('Canducci\ZipCode\ZipCodeContracts');
            return $zip_code->find($value);
        }

    }
	
}
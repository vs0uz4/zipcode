<?php namespace {

    if (!function_exists('zipcode'))
    {
        /**
         * @param $value
         * @return Artesaos\ZipCode\ZipCode
         * @throws Artesaos\ZipCode\ZipCodeException
         */
        function zipcode($value)
        {
            $zip_code = app('Artesaos\ZipCode\ZipCodeContracts');
            return $zip_code->find($value);
        }

    }
	
}
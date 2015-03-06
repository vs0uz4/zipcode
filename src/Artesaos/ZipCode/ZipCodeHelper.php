<?php namespace {

    if (!function_exists('zipcode'))
    {
        /**         
         * Helper zipcode
         *
         * @param $value (string)
         * @param @renew (bool)
         * @return Artesaos\ZipCode\ZipCodeInfo
         * @throws Artesaos\ZipCode\ZipCodeException
         */
        function zipcode($value, $renew = false)
        {
            $zip_code = app('Artesaos\ZipCode\Contracts\ZipCodeContract');
            return $zip_code->find($value, $renew);
        }

    }
	
}
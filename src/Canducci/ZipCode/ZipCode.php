<?php namespace Canducci\ZipCode;

use Illuminate\Cache\CacheManager;

class ZipCode implements ZipCodeContracts
{
    /**
     * @var $value
     */
    private $value;

    /**
     * @var Illuminate\Cache\CacheManager
     */
    private $cacheManager;

    /**
     * @param Illuminate\Cache\CacheManager $cacheManager
     */
    public function __construct(CacheManager $cacheManager)
    {
        $this->value = '';
        $this->cacheManager = $cacheManager;
    }

    /**
     * @param $value
     * @return Canducci\ZipCode\ZipCode
     * @throws Canducci\ZipCode\ZipCodeException
     */
    public function find($value)
    {
        if (is_string($value))
        {
            $value = str_replace('.', '', $value);
            $value = str_replace('-', '', $value);
            if (mb_strlen($value) === 8 && preg_match('/^(\d){8}$/', $value)) {
                $this->value = $value;
                return $this;
            }
        }
        throw new ZipCodeException("Invalid Zip");
    }

    /**
     * @return JSON Javascript
     * @throws Canducci\ZipCode\ZipCodeException
     */
    public function toJson()
    {
        if ($this->cacheManager->has('zipcode_'.$this->value))
        {
            $getCache = $this->cacheManager->get('zipcode_'.$this->value);
            if (is_array($getCache))
            {
                $getCache = json_encode($getCache, JSON_PRETTY_PRINT);
            }
            return $getCache;
        }
        else
        {
            $url   = 'http://viacep.com.br/ws/[cep]/json/';
            $url   = str_replace('[cep]', $this->value, $url);
            $error = null;
            try
            {
                $get   = file_get_contents($url);
                $error = json_decode($get);
                if (isset($error->erro) && $error->erro === true)
                {
                    return null;
                }
                $this->cacheManager->put('zipcode_' . $this->value, json_decode($get, true), 86400);
                return $get;
            }
            catch (ZipCodeException $e)
            {
                throw new ZipCodeException("Number and http are invalid", $e->getCode(), $e);
            }
        }
        return null;
    }

    /**
     * @return Array
     * @throws Canducci\ZipCode\ZipCodeException
     */
    public function toArray()
    {
        return json_decode($this->toJson(), true);
    }

    /**
     * @return stdClass
     * @throws Canducci\ZipCode\ZipCodeException
     */
    public function toObject()
    {
        return json_decode($this->toJson(), false);
    }

    /**
     * Remove item from cache
     * @return Canducci\ZipCode\ZipCode
     */
    public function renew()
    {
        if ($this->value != '')
        {
            if ($this->cacheManager->has('zipcode_' . $this->value))
            {
                $this->cacheManager->forget('zipcode_' . $this->value);
            }
        }
        return $this;
    }
}
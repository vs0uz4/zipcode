<?php namespace Artesaos\ZipCode;

use Illuminate\Cache\CacheManager;
use GuzzleHttp\ClientInterface;

class ZipCode implements ZipCodeContracts {
    
    /**
     * @var $value
     */
    private $value;

    /**
     * @var Illuminate\Cache\CacheManager
     */
    private $cacheManager;

    /**
     * @var GuzzleHttp\ClientInterface
     */
    private $clientInterface;

    /**
     * Construct
     *
     * @param Illuminate\Cache\CacheManager $cacheManager
     */
    public function __construct(CacheManager $cacheManager, ClientInterface $clientInterface)
    {
        $this->value           = '';
        $this->cacheManager    = $cacheManager;        
        $this->clientInterface = $clientInterface;
    }

    /**
     * find method fluent
     *
     * @param $value
     * @return Artesaos\ZipCode\ZipCode
     * @throws Artesaos\ZipCode\ZipCodeException
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
     * return JSON Javascript 
     * 
     * @return JSON Javascript
     * @throws Artesaos\ZipCode\ZipCodeException
     */
    public function toJson()
    {
        if ($this->cacheManager->has('zipcode_'.$this->value))
        {            
            $getCache = $this->cacheManager->get('zipcode_'.$this->value);            
            if (isset($getCache) && is_array($getCache))
            {   
                if (isset($getCache['erro']) && $getCache['erro'] == true)
                {
                    return null;
                }
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
                $response = $this->clientInterface->get($url);
                $get      = $response->json();                                               
                $this->cacheManager->put('zipcode_' . $this->value, $get, 86400);                
                if (isset($get['erro']) && $get['erro'] == true)
                {
                    return null;
                }                
                return json_encode($get);
            }
            catch (ZipCodeException $e)
            {
                throw new ZipCodeException("Number and http are invalid", $e->getCode(), $e);
            }
        }
        return null;
    }

    /**
     * return Array
     *
     * @return Array
     * @throws Artesaos\ZipCode\ZipCodeException
     */
    public function toArray()
    {
        return json_decode($this->toJson(), true);
    }

    /**
     * return stdClass (Object)
     *
     * @return stdClass
     * @throws Artesaos\ZipCode\ZipCodeException
     */
    public function toObject()
    {
        return json_decode($this->toJson(), false);
    }

    /**
     * remove item from cache
     *
     * @return Artesaos\ZipCode\ZipCode
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
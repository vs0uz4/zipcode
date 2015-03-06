<?php namespace Artesaos\ZipCode;

use Illuminate\Cache\CacheManager;
use GuzzleHttp\ClientInterface;
use Artesaos\ZipCode\Contracts\ZipCodeContract;

class ZipCode implements ZipCodeContract {
    
    /**
     * @var $value
     */
    protected $value;

    /**
     * @var $renew
     */
    protected $renew;

    /**
     * @var $cacheManager (Illuminate\Cache\CacheManager)
     */
    protected $cacheManager;

    /**
     * @var $clientInterface (GuzzleHttp\ClientInterface)
     */
    protected $clientInterface;

    /**
     * Construct ZipCode
     *
     * @param $cacheManager (Illuminate\Cache\CacheManager)
     * @param $clientInterface (GuzzleHttp\ClientInterface)
     */
    public function __construct(CacheManager $cacheManager, ClientInterface $clientInterface)
    {        
        $this->value           = '';
        $this->renew           = false;
        $this->cacheManager    = $cacheManager;        
        $this->clientInterface = $clientInterface;
    }

    /**
     * return ZipCodeInfo
     *
     * @param string $value
     * @param bool $renew
     * @return Artesaos\ZipCode\ZipCodeInfo
     * @throws ZipCodeException
     */
    public function find($value, $renew = false)
    {
        if (is_string($value))
        {
            $value = str_replace('.', '', $value);
            $value = str_replace('-', '', $value);
            if (mb_strlen($value) === 8 && preg_match('/^(\d){8}$/', $value)) {
                $this->value = $value;
                $this->renew = $renew;
                $valueInfo   = $this->getZipCodeInfo();
                if ($valueInfo === null) 
                {
                    return null;
                }
                return new ZipCodeInfo($valueInfo);
            }
        }
        throw new ZipCodeException("Invalid Zip. The format valid: 01001-000 or 01001000");
    }

    /**
     * return JSON javascript
     *
     * @return JSON javascript
     * @throws ZipCodeException
     */
    private function getZipCodeInfo()
    {
        if ($this->renew)
        {
            $this->renew = false;
            $this->renew();
        }
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
     * remove item from cache
     *
     * @return void
     */
    private function renew()
    {   
        if (!is_null($this->value)) 
        {           
            if ($this->cacheManager->has('zipcode_' . $this->value))
            {
                $this->cacheManager->forget('zipcode_' . $this->value);
            }           
        }        
    }
}
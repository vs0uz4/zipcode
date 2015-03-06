<?php

$dir1 = str_replace('tests','src/Artesaos/ZipCode/ZipCodeTrait.php', __DIR__);
$dir2 = str_replace('tests','src/Artesaos/ZipCode/ZipCodeException.php', __DIR__);

include $dir1;
include $dir2;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Client;

class ZipCodeTest extends TestCase
{
    use Artesaos\ZipCode\ZipCodeTrait;
    
    public function setUp()
    {       
        parent::setUp();        
    }

    /**
     * @return GuzzleHttp\ClientInterface     
     */
    public function getGuzzleHttpClient() 
    {
        return $this->app->make('GuzzleHttp\ClientInterface');
    }

    /**
     * @return Artesaos\ZipCode\ZipCode     
     */
    public function getZipCodeInstance() 
    {
        return new Artesaos\ZipCode\ZipCode(new Illuminate\Cache\CacheManager(app()), $this->getGuzzleHttpClient());
    }

    /**
     * Test of Instance
     */
    public function testInstance()
    {                
        $this->assertInstanceOf('Artesaos\ZipCode\Contracts\ZipCodeContract', $this->getZipCodeInstance());

    }

    /**
     * Test Facade
     */
    public function testFacadeToZipCodeInfoInstance()
    {
        $this->app->bind('GuzzleHttp\ClientInterface','GuzzleHttp\Client');
        $this->assertInstanceOf('Artesaos\ZipCode\Contracts\ZipCodeInfoContract',
            \Artesaos\ZipCode\Facades\ZipCode::find('01414000'));

    }

    /**
     * Test Helper
     */
    public function testHelperToZipCodeInfoInstance()
    {
        $this->assertInstanceOf('Artesaos\ZipCode\Contracts\ZipCodeInfoContract', zipcode('01414000'));
    }

    /**
     * Test Traits
     */
    public function testTraitToZipCodeInfoInstance()
    {
        $this->assertInstanceOf('Artesaos\ZipCode\Contracts\ZipCodeInfoContract', $this->zipcode('01414000'));
    }

    /**
     * Tests the same return null
     */
    public function testZipCodeInfoNull()
    {
        $zipCode = $this->getZipCodeInstance();
        $this->assertTrue(is_null($zipCode->find('00000000')));
    }

    /**
     * Tests the return not null
     */
    public function testZipCodeInfoNotNull()
    {
        $zipCode = $this->getZipCodeInstance();
        $this->assertFalse(is_null($zipCode->find('01414000')));
    }

    /**
     * Tests the return JSON Javascript
     */
    public function testZipCodeInfoReturnJSON()
    {
        $zipCode     = $this->getZipCodeInstance();
        $zipCodeInfo = $zipCode->find('01414000');
        $this->assertJson($zipCodeInfo->getJson());

    }

    /**
     * Tests the return Array
     */
    public function testZipCodeInfoReturnArray()
    {
        $zipCode     = $this->getZipCodeInstance();
        $zipCodeInfo = $zipCode->find('01414000');
        $this->assertInternalType('array', $zipCodeInfo->getArray());
    }

    /**
     * Tests the return Key of Array
     */
    public function testZipCodeInfoKeyOfArray()
    {
        $zipCode = $this->getZipCodeInstance();
        $zipCodeInfo = $zipCode->find('01414000');
        $this->assertArrayHasKey('cep', $zipCodeInfo->getArray());
    }

    /**
     * Tests thrown messages "Invalid Zip"
     */
    public function testZipCodeException()
    {
        $zipCode = $this->getZipCodeInstance();
        $this->setExpectedException('Artesaos\ZipCode\ZipCodeException','Invalid Zip');
        $zipCode->find('');
    }

    /**
     * Tests no found
     */
    public function testZipCodeInfoNoFind()
    {
        $zipCode = $this->getZipCodeInstance();
        $this->assertTrue(is_null($zipCode->find('11111111')));
    }
}

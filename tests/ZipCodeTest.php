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

    private $clientInterface;
    
    public function setUp()
    {       
        parent::setUp();        
    }

    public function getGuzzleHttpClient() 
    {
        return $this->app->make('GuzzleHttp\ClientInterface');
    }
    
    public function getZipCodeInstance() 
    {
        return new Artesaos\ZipCode\ZipCode(new Illuminate\Cache\CacheManager(app()), $this->getGuzzleHttpClient());
    }
    
    public function testInstance()
    {                
        $this->assertInstanceOf('Artesaos\ZipCode\ZipCodeContracts', $this->getZipCodeInstance());

    }

    public function testFacadeInstance()
    {
        $this->app->bind('GuzzleHttp\ClientInterface','GuzzleHttp\Client');

        $this->assertInstanceOf('Artesaos\ZipCode\ZipCodeContracts',
            \Artesaos\ZipCode\Facades\ZipCode::find('01414000'));

    }

    public function testHelperInstance()
    {
        $this->assertInstanceOf('Artesaos\ZipCode\ZipCodeContracts', zipcode('01414000'));
    }

    public function testTraitInstance()
    {
        $this->assertInstanceOf('Artesaos\ZipCode\ZipCodeContracts', $this->zipcode('01414000'));
    }

    public function testZipCodeNull()
    {
        $zipCode = $this->getZipCodeInstance();
        $this->assertTrue(is_null($zipCode->find('00000000')->toObject()));
    }

    public function testZipCodeNotNull()
    {
        $zipCode = $this->getZipCodeInstance();
        $this->assertFalse(is_null($zipCode->find('01414000')->toObject()));
    }

    public function testZipCodeReturnJSON()
    {
        $zipCode = $this->getZipCodeInstance();
        $this->assertJson($zipCode->find('01414000')->toJson());

    }

    public function testZipCodeReturnArray()
    {
        $zipCode = $this->getZipCodeInstance();
        $this->assertInternalType('array', $zipCode->find('01414000')->toArray());
    }

    public function testZipCodeKeyOfArray()
    {
        $zipCode = $this->getZipCodeInstance();
        $this->assertArrayHasKey('cep', $zipCode->find('01414000')->toArray());
    }

    public function testZipCodeException()
    {
        $zipCode = $this->getZipCodeInstance();
        $this->setExpectedException('Artesaos\ZipCode\ZipCodeException','Invalid Zip');
        $zipCode->find('');
    }

    public function testZipCodeNoFind()
    {
        $zipCode = $this->getZipCodeInstance();
        $this->assertTrue(is_null($zipCode->find('11111111')->toObject()));
    }
}

<?php

$dir1 = str_replace('tests','src/Artesaos/ZipCode/ZipCodeTrait.php', __DIR__);
$dir2 = str_replace('tests','src/Artesaos/ZipCode/ZipCodeException.php', __DIR__);
//$dir3 = str_replace('artesaos\zipcode\tests','guzzlehttp/guzzle/src/Client.php', __DIR__);
//$dir4 = str_replace('artesaos\zipcode\tests','guzzlehttp/guzzle/src/ClientInterface.php', __DIR__);


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

    public function testInstance()
    {                
        $this->assertInstanceOf('Artesaos\ZipCode\ZipCodeContracts',
            new Artesaos\ZipCode\ZipCode(new Illuminate\Cache\CacheManager(app()), $this->getGuzzleHttpClient()));

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
        $zipCode = new Artesaos\ZipCode\ZipCode(new Illuminate\Cache\CacheManager(app()), $this->getGuzzleHttpClient());
        $this->assertTrue(is_null($zipCode->find('00000000')->toObject()));
    }

    public function testZipCodeNotNull()
    {
        $zipCode = new Artesaos\ZipCode\ZipCode(new Illuminate\Cache\CacheManager(app()), $this->getGuzzleHttpClient());
        $this->assertFalse(is_null($zipCode->find('01414000')->toObject()));
    }

    public function testZipCodeReturnJSON()
    {
        $zipCode = new Artesaos\ZipCode\ZipCode(new Illuminate\Cache\CacheManager(app()), $this->getGuzzleHttpClient());
        $this->assertJson($zipCode->find('01414000')->toJson());

    }

    public function testZipCodeKeyOfArray()
    {
        $zipCode = new Artesaos\ZipCode\ZipCode(new Illuminate\Cache\CacheManager(app()), $this->getGuzzleHttpClient());
        $this->assertArrayHasKey('cep', $zipCode->find('01414000')->toArray());
    }

    public function testZipCodeException()
    {
        $zipCode = new Artesaos\ZipCode\ZipCode(new Illuminate\Cache\CacheManager(app()), $this->getGuzzleHttpClient());
        $this->setExpectedException('Artesaos\ZipCode\ZipCodeException','Invalid Zip');
        $zipCode->find('');
    }

    public function testZipCodeNoFind()
    {
        $zipCode = new Artesaos\ZipCode\ZipCode(new Illuminate\Cache\CacheManager(app()), $this->getGuzzleHttpClient());
        $this->assertTrue(is_null($zipCode->find('11111111')->toObject()));
    }
}
<?php

$dir = __DIR__;
$dir1 = str_replace('tests','src/Artesaos/ZipCode/ZipCodeTrait.php', $dir);
$dir2 = str_replace('tests','src/Artesaos/ZipCode/ZipCodeException.php', $dir);

include $dir1;
include $dir2;

class ZipCodeTest extends TestCase
{
    use Artesaos\ZipCode\ZipCodeTrait;

    public function testInstance()
    {
        $this->assertInstanceOf('Artesaos\ZipCode\ZipCodeContracts',
            new Artesaos\ZipCode\ZipCode(new Illuminate\Cache\CacheManager(app())));

    }

    public function testFacadeInstance()
    {
        $this->assertInstanceOf('Artesaos\ZipCode\ZipCodeContracts',
            \Artesaos\ZipCode\Facades\ZipCode::find('01414000'));

    }

    public function testHelperInstance()
    {
        $this->assertInstanceOf('Artesaos\ZipCode\ZipCodeContracts',
            zipcode('01414000'));
    }

    public function testTraitInstance()
    {
        $this->assertInstanceOf('Artesaos\ZipCode\ZipCodeContracts',
            $this->zipcode('01414000'));
    }

    public function testZipCodeNull()
    {
        $zipCode = new Artesaos\ZipCode\ZipCode(new Illuminate\Cache\CacheManager(app()));
        $this->assertTrue(is_null($zipCode->find('00000000')->toObject()));
    }

    public function testZipCodeNotNull()
    {
        $zipCode = new Artesaos\ZipCode\ZipCode(new Illuminate\Cache\CacheManager(app()));
        $this->assertFalse(is_null($zipCode->find('01414000')->toObject()));
    }

    public function testZipCodeReturnJSON()
    {
        $zipCode = new Artesaos\ZipCode\ZipCode(new Illuminate\Cache\CacheManager(app()));
        $this->assertJson($zipCode->find('01414000')->toJson());

    }

    public function testZipCodeKeyOfArray()
    {
        $zipCode = new Artesaos\ZipCode\ZipCode(new Illuminate\Cache\CacheManager(app()));
        $this->assertArrayHasKey('cep', $zipCode->find('01414000')->toArray());
    }

    public function testZipCodeException()
    {
        $zipCode = new Artesaos\ZipCode\ZipCode(new Illuminate\Cache\CacheManager(app()));
        $this->setExpectedException('Artesaos\ZipCode\ZipCodeException','Invalid Zip');
        $zipCode->find('');
    }

    public function testZipCodeNoFind()
    {
        $zipCode = new Artesaos\ZipCode\ZipCode(new Illuminate\Cache\CacheManager(app()));
        $this->assertTrue(is_null($zipCode->find('11111111')->toObject()));
    }
}
<?php

$dir = __DIR__;
$dir1 = str_replace('tests','src/Canducci/ZipCode/ZipCodeTrait.php', $dir);
$dir2 = str_replace('tests','src/Canducci/ZipCode/ZipCodeException.php', $dir);

include $dir1;
include $dir2;

class ZipCodeTest extends TestCase
{
    use Canducci\ZipCode\ZipCodeTrait;

    public function testInstance()
    {
        $this->assertInstanceOf('Canducci\ZipCode\ZipCodeContracts',
            new Canducci\ZipCode\ZipCode(new Illuminate\Cache\CacheManager(app())));

    }

    public function testFacadeInstance()
    {
        $this->assertInstanceOf('Canducci\ZipCode\ZipCodeContracts',
            \Canducci\ZipCode\Facades\ZipCode::find('01414000'));

    }

    public function testHelperInstance()
    {
        $this->assertInstanceOf('Canducci\ZipCode\ZipCodeContracts',
            zipcode('01414000'));
    }

    public function testTraitInstance()
    {
        $this->assertInstanceOf('Canducci\ZipCode\ZipCodeContracts',
            $this->zipcode('01414000'));
    }

    public function testZipCodeNull()
    {
        $zipCode = new Canducci\ZipCode\ZipCode(new Illuminate\Cache\CacheManager(app()));
        $this->assertTrue(is_null($zipCode->find('00000000')->toObject()));
    }

    public function testZipCodeNotNull()
    {
        $zipCode = new Canducci\ZipCode\ZipCode(new Illuminate\Cache\CacheManager(app()));
        $this->assertFalse(is_null($zipCode->find('01414000')->toObject()));
    }

    public function testZipCodeReturnJSON()
    {
        $zipCode = new Canducci\ZipCode\ZipCode(new Illuminate\Cache\CacheManager(app()));
        $this->assertJson($zipCode->find('01414000')->toJson());

    }

    public function testZipCodeKeyOfArray()
    {
        $zipCode = new Canducci\ZipCode\ZipCode(new Illuminate\Cache\CacheManager(app()));
        $this->assertArrayHasKey('cep', $zipCode->find('01414000')->toArray());
    }

    public function testZipCodeException()
    {
        $zipCode = new Canducci\ZipCode\ZipCode(new Illuminate\Cache\CacheManager(app()));
        $this->setExpectedException('Canducci\ZipCode\ZipCodeException','Invalid Zip');
        $zipCode->find('');
    }

    public function testZipCodeNoFind()
    {
        $zipCode = new Canducci\ZipCode\ZipCode(new Illuminate\Cache\CacheManager(app()));
        $this->assertTrue(is_null($zipCode->find('11111111')->toObject()));
    }
}
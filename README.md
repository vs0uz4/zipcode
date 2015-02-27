# ARTESÃOS ZIPCODE (CEP BRASIL)

__Web Service provided by http://viacep.com.br/__

[![Canducci Cep](https://fulviocanducci.files.wordpress.com/2015/01/1948132_691123557596602_6995479600312612395_n.png)](https://packagist.org/packages/canducci/cep)

## Quick start

### Required setup

In the `require` key of `composer.json` file add the following

```PHP
"artesaos/zipcode": "dev-master"
```

Run the Composer update comand

    $ composer update

In your `config/app.php` add `'Artesaos\ZipCode\Providers\ZipCodeServiceProvider'` to the end of the `providers` array:

```PHP
'providers' => array(
    ...,
    'Illuminate\Workbench\WorkbenchServiceProvider',
    'Artesaos\ZipCode\Providers\ZipCodeServiceProvider',

),
```

At the end of `config/app.php` add `'ZipCode' => 'Artesaos\ZipCode\Facade\ZipCode'` to the `aliases` array:

```PHP
'aliases' => array(
    ...,
    'View'       => 'Illuminate\Support\Facades\View',
    'ZipCode'    => 'Artesaos\ZipCode\Facades\ZipCode',

),
```

##How to Use

To use is very simple, pass the ZIP and calls the various types of returns, like this:

##Facade

__Add namespace:__
```PHP
use Artesaos\ZipCode\Facades\ZipCode;
```
__Code Example__
```PHP
$cep = ZipCode::find('01414-001');
```

##Helper

```PHP
$cep = zipcode('01414000');
```

##Injection
__Add Namespace__
```PHP
use Artesaos\ZipCode\ZipCodeContracts;
```
__Code Example__
```PHP
public function index(ZipCodeContracts $zipcode)
{
      $cep = $zipcode->find('01414000');
```

##Traits
__Add Namespace__
```PHP
use Artesaos\ZipCode\ZipCodeTrait;
```
__Code Example__
```PHP
class WelcomeController extends Controller {

	use ZipCodeTrait;
	
	public function index()
	{
      		$cep =	$this->zipcode('01414000');
```

##Type returns:

__Json__
```PHP    
$cep->toJson();

    {
        "cep": "01414-001",
        "logradouro": "Rua Haddock Lobo",
        "bairro": "Cerqueira César",
        "localidade": "São Paulo",
        "uf": "SP",
        "ibge": "3550308", 
        "complemento": ""
    }
```
__Array__
```PHP    
$cep->toArray();
    
    Array
    (
        [cep] => 01414-001
        [logradouro] => Rua Haddock Lobo
        [bairro] => Cerqueira César
        [localidade] => São Paulo
        [uf] => SP
        [ibge] => 3550308,
        [complemento] => 
    )
```
__Object__
```PHP    
$cep->toObject();
    
    
    stdClass Object
    (
        [cep] => 01414-001
        [logradouro] => Rua Haddock Lobo
        [bairro] => Cerqueira César
        [localidade] => São Paulo
        [uf] => SP
        [ibge] => 3550308
        [complemento] => 
    )
```

##Renew item from cache

```PHP
$cep   = ZipCode::find('01414001');			
$dados = $cep->renew()->toArray();
```

##To check if any errors had to do:

```PHP
$cep   = ZipCode::find('01414001');			
$dados = $cep->toArray();

if ($dados) {
	//ZIP EXISTING
} else {
	//POSTAL CODE NO EXISTING 
}
```

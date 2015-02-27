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
Add namespace:

```PHP
use Artesaos\ZipCode\Facades\ZipCode;
```

To use is very simple, pass the ZIP and calls the various types of returns, like this:

##Facade

```PHP
$cep = ZipCode::find('01414-001');
```

##Helper

```PHP
$cep = zipcode('01414000');
```

##Injection

```PHP
public function index(\Artesaos\ZipCode\ZipCodeContracts $zipcode)
{
      $cep = $zipcode->find('01414000');
```

##Traits
```PHP
class WelcomeController extends Controller {

	use \Artesaos\ZipCode\ZipCodeTrait;
	
	public function index()
	{
      		$cep =	$this->zipcode('01414000');
```


__Type returns:__

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
__Renew item from cache__

```PHP
$cep   = ZipCode::find('01414001');			
$dados = $cep->renew()->toArray();
```

__To check if any errors had to do:__

```PHP
$cep   = ZipCode::find('01414001');			
$dados = $cep->toArray();

if ($dados) {
	//ZIP EXISTING
} else {
	//POSTAL CODE NO EXISTING 
}
```

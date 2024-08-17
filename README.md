
# Token Replacer

![Build Status](https://github.com/jesseschutt/token-replacer/actions/workflows/run-tests.yml/badge.svg)
![Code Coverage](https://img.shields.io/codecov/c/github/jesseschutt/token-replacer)
![Dependencies](https://img.shields.io/librariesio/github/jesseschutt/token-replacer)

### Credit
This package is a fork of the [original](https://github.com/HollyIT/token-replacer), which was created by Jamie Holly of HollyIT. I've used it in a few projects and decided to add some features and keep it compatible with more recent versions of Laravel. Thank you for creating it Jamie!

### Installation
    
```
composer require jesseschutt/token-replacer
```

### Configuration

You can publish the configuration file by running the following command:

```
php artisan vendor:publish --provider="JesseSchutt\TokenReplacer\TokenReplacerServiceProvider"
```

This will create a `token-replacer.php` file in your `config` directory. Here you can set the default token start and end characters, the default token separator, and the default transformers.

### Instructions

This package allows you to define tokens that can be replaced in strings. Instead of a simple `str_replace`, Token Replacer lets you add options to each token. Let's start with an example.

```  
use \JesseSchutt\TokenReplacer\Facades\TokenReplacer;
use \JesseSchutt\TokenReplacer\Transformers\DateTransformer;

$input="Today is {{ date:m }}/{{ date:d }}/{{ date:y }}.";  
  
echo TokenReplacer::from($input)->with('date', DateTransformer::class)  
      
// Results in: Today is 11/11/21.      
```  

There is a certain anatomy to tokens, so let's take a look at the `{{ date:m }}`. This is a default token format, but this format is configurable globally and per instance.

| Part |  Name | Global Setting                                      | Local Setting
|--|--|-----------------------------------------------------|--|
| {{ | Token Start | `config('token-replacer.default_start_token')`      | $instance->startToken() |
| date | Token Name | --- |--- |
| : | Token Separator | `config('token-replacer.default_ token_separator')` | $instance->tokenSeparator() |
| m | Options | --- | --- |
| }} | Token End | `config('token-replacer.default_end_token')`        | $instance->endToken() |

### Transformers

The replacement of tokens is handled via a transformer. A transformer can be a closure or a simple class.

Transformers can be added to each instance of the TokenReplacer or added globally by adding them to the `default_transformers` array in the configuration file. 

**Note:** Global transformers do not receive any data when instantiated. `DateTransformer` and `AuthTransformer` are the only two built-in transformers that are eligible for global use.

Per instance tokens are added via `$instance->with({token name}, {class name, transformer instance or closure});` For closure based transformers the signature is:

```
function(string $options)
``` 

#### Included Transformers
All these transformers live under the `\JesseSchutt\TokenReplacer\Transformers` namespace.

| Transformer | Description | Instantiating |
| --- | --- | -- |
| ArrayTransformer | Extracts a value from an array based on a key.| The array |
| DateTransfomer | Extract parts of a date by [PHP date format](https://www.php.net/manual/en/datetime.format.php) tokens. | Date object, Carbon, date string or null (assumes now()) |
|FileTransformer | Extract parts from a file based on pathinfo(). | The path string |
| ObjectTransformer| Extract a property from an object. | The object |
|UrlTransformer | Extract based on `parse_url()` | The URL string |

There are also special Laravel transformers residing in `\JesseSchutt\TokenReplacer\Transformers\Laravel`

| Transformer | Description | Instantiating |
| --- | --- | -- |
| AuthTransformer | Extract a property from the auth (user) object | none |
| DotArrayTransformer | Extract a property using Laravel's dot syntax | the array |
| ModelTransformer | Extract a property from an Eloquent model. For date properties, you can add the date part by specifying the format after the property name (ie: model:created_at,m) | The model |
| UploadFileTransformer | Extract the basename or extension from an UploadedFile object | The upload |

### Post-processing
None of the transformers do any further processing except extracting the item. If you want to do further processing, such as escaping the replacements, you can define an `onReplace` callback:
```
$replacer->onReplace(function(string $result, string $token, string $options){  
  return strtoupper($result);  
});
```
This callback will run for every token occurrence found, so you can further filter down what tokens
to operate on by checking the `$token` property.

### Invalid or missing tokens
By default, invalid and missing tokens will remain in the string. To prevent this, you can set `removeEmpty()` on the TokenReplacer.

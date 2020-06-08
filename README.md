# Language Detection

The following different strategies are used to detect the language. 

- by Accept-Language-Header (e.g. 'de-CH,en;q=0.8,en-US;q=0.5,fr;q=0.3')
- by Cookie (e.g Cookie 'lang', value 'en')
- by UriPath (e.g. /shop/en/article/3453452)
- by QueryParam (e.g. index.php?lang=en)

These methods can be chained independently after each other. 
The last method that detects an available language wins.
If no language can be detected, the default language will be returned.


### Installing

Use composer:

```
composer require unicate/language-detection
```

### Usage

```php
<?php

require_once "vendor/autoload.php";

// Available Languages: First entry is assumed to be the default language.
$availableLang = ['en', 'de', 'fr'];

$langDetection = new \Unicate\LanguageDetection\LanguageDetection($availableLang);
$lang = $langDetection->byHeader()->byCookie()->byUri()->byParam()->getLang();

// Only by Param ?lang=en
$langDetection = new \Unicate\LanguageDetection\LanguageDetection($availableLang);
$lang = $langDetection->byParam()->getLang();

// Only by Uri /shop/en/article/3453452
$langDetection = new \Unicate\LanguageDetection\LanguageDetection($availableLang);
$lang = $langDetection->byUri()->getLang();

```
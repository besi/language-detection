# Language Detection

Chainable language detection.
- Cookie
- QueryParam
- UriPath
- Accept-Language-Header

otherwise
- set Default-Language


### Installing

Use composer:

```
composer require unicate/language-detection
```

### Usage

```php
<?php

require_once "vendor/autoload.php";

$defaultLang = 'de';
$availableLang = ['de', 'en', 'fr'];

$langDetection = new \Unicate\LanguageDetection\LanguageDetection($defaultLang, $availableLang);
$lang = $langDetection->byHeader()->byCookie()->byUri()->byParam()->getLang();

// Only by Param ?lang=en
$langDetection = new \Unicate\LanguageDetection\LanguageDetection($defaultLang, $availableLang);
$lang = $langDetection->byParam()->getLang();

// Only by Uri /shop/en/article/3453452
$langDetection = new \Unicate\LanguageDetection\LanguageDetection($defaultLang, $availableLang);
$lang = $langDetection->byUri()->getLang();

```
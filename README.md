# Language Detection

Simple language detection, based on the following information.
- Cookie:  
- QueryParam:
- UriPath: 
- Accept-Language-Header:

otherwise
- set Default-Language


### Installing

Use composer:

```
composer require unicate/language-detection
```

### Example

#### v1.0

```php
<?php

require_once "vendor/autoload.php";

$lang = new \Unicate\LanguageDetection\Detection();
$lang->getLang();

```
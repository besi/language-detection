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

### Example

#### v1.0

```php
<?php

require_once "vendor/autoload.php";


$langDetection = new \Unicate\LanguageDetection\LanguageDetection();
$langDetection->byHeader()->byCookie()->byUri()->byParam()->getLang();

```
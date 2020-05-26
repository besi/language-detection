<?php

declare(strict_types=1);

namespace Unicate\LanguageDetection;

use Laminas\Diactoros\ServerRequestFactory;

class Detection {
    private $lang;
    private $defaultLang;
    private $availableLang;

    public function __construct(string $defaultLang, array $availableLang) {
        $this->defaultLang = $defaultLang;
        $this->availableLang = $availableLang;
    }

    public function detectLang(): string {
        $request = ServerRequestFactory::fromGlobals(
            $_SERVER, $_GET, $_COOKIE
        );

        // Check if 'lang' cookie was set
        $cookie = $request->getCookieParams();
        if (isset($cookie["lang"])) {
            return $cookie["lang"];
        }

        // Check if there is a 'lang' query param.
        $queryParam = $request->getQueryParams();
        if (array_key_exists('lang', $queryParam)) {
            return $queryParam['lang'];
        }

        // Check if any part of the URL matches an available language.
        $uriPath = $request->getUri()->getPath();
        $uriArray = explode('/', $uriPath);
        $langArray = array_intersect($uriArray, $this->availableLang);
        if (!empty($langArray)) {
            return array_values($langArray)[0];
        }

        // Try to get Language from Accept-Language Header
        $header = $request->getHeader('accept-language');
        if (!empty($header)) {
            $acceptFromHttp = \Locale::acceptFromHttp($header[0]);
            $headerLang = explode('_', $acceptFromHttp)[0];
            if (in_array($headerLang, $this->availableLang)) {
                return $headerLang;
            }
        }

        // Set the default language, if no other rule matches..
        return $this->defaultLang;

    }


}
<?php

declare(strict_types=1);

namespace Unicate\LanguageDetection;

use Laminas\Diactoros\ServerRequestFactory;

class LanguageDetection {
    private $lang;
    private $availableLang;
    private $request;

    public function __construct(string $defaultLang, array $availableLang) {
        $this->availableLang = $availableLang;
        $this->lang = $defaultLang;
        $this->request = ServerRequestFactory::fromGlobals(
            $_SERVER, $_GET, $_COOKIE
        );

    }

    public function byCookie(): LanguageDetection {
        $cookie = $this->request->getCookieParams();
        if (isset($cookie["lang"])) {
            $this->lang = $cookie["lang"];
        }
        return $this;
    }

    public function byParam(): LanguageDetection {
        $queryParam = $this->request->getQueryParams();
        if (array_key_exists('lang', $queryParam)) {
            $this->lang = $queryParam['lang'];
        }
        return $this;
    }

    public function byUri(): LanguageDetection {
        $uriPath = $this->request->getUri()->getPath();
        $uriArray = explode('/', $uriPath);
        $langArray = array_intersect($uriArray, $this->availableLang);
        if (!empty($langArray)) {
            $this->lang = array_values($langArray)[0];
        }
        return $this;
    }

    public function byHeader(): LanguageDetection {
        $header = $this->request->getHeader('accept-language');
        if (!empty($header)) {
            $acceptFromHttp = \Locale::acceptFromHttp($header[0]);
            $headerLang = explode('_', $acceptFromHttp)[0];
            if (in_array($headerLang, $this->availableLang)) {
                $this->lang = $headerLang;
            }
        }
        return $this;
    }

    public function getLang(): string {
        return $this->lang;
    }


}


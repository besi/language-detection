<?php
/**
 * @author https://unicate.ch
 * @copyright Copyright (c) 2020
 * @license Released under the MIT license
 */

declare(strict_types=1);

namespace Unicate\LanguageDetection;

use Laminas\Diactoros\ServerRequestFactory;

class LanguageDetection {
    private $lang;
    private $availableLang;
    private $request;

    public function __construct(array $availableLang) {
        if (empty($availableLang)) {
            throw new \RuntimeException('Array must contain at least one Language-Code.');
        }
        $this->availableLang = $availableLang;

        // The first entry in $availableLang is assumed to be the default language.
        $this->lang = $availableLang[0];

        $this->request = ServerRequestFactory::fromGlobals(
            $_SERVER, $_GET, $_COOKIE
        );

    }

    public function byCookie(): LanguageDetection {
        $cookie = $this->request->getCookieParams();
        if (isset($cookie["lang"])) {
            $lang = $cookie["lang"];
            if (in_array($lang, $this->availableLang)) {
                $this->lang = $lang;
            }
        }
        return $this;
    }

    public function byParam(): LanguageDetection {
        $queryParam = $this->request->getQueryParams();
        if (array_key_exists('lang', $queryParam)) {
            $lang = $queryParam['lang'];
            if (in_array($lang, $this->availableLang)) {
                $this->lang = $lang;
            }
        }
        return $this;
    }

    public function byUri(): LanguageDetection {
        $uriPath = $this->request->getUri()->getPath();
        $uriArray = explode('/', $uriPath);
        $langArray = array_intersect($uriArray, $this->availableLang);
        if (!empty($langArray)) {
            $lang = array_values($langArray)[0];
            if (in_array($lang, $this->availableLang)) {
                $this->lang = $lang;
            }
        }
        return $this;
    }

    public function byHeader(): LanguageDetection {
        $header = $this->request->getHeader('accept-language');
        if (!empty($header)) {
            $acceptFromHttp = \Locale::acceptFromHttp($header[0]);
            $lang = explode('_', $acceptFromHttp)[0];
            if (in_array($lang, $this->availableLang)) {
                $this->lang = $lang;
            }
        }
        return $this;
    }

    public function getLang(): string {
        return $this->lang;
    }


}


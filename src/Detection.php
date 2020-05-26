<?php

namespace Unicate\LanguageDetection;

class Detection {
    private $lang;

    public function __construct() {
    }

    /**
     * @return mixed
     */
    public function getLang() {
        return $this->lang;
    }

    /**
     * @param mixed $lang
     */
    public function setLang($lang) {
        $this->lang = $lang;
    }


}
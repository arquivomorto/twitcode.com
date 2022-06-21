<?php

use PhpMyAdmin\MoTranslator\Loader;
use app\lib\Utils;

if (!function_exists('__')) {
    function __($in, $print=true)
    {
        $loader = new Loader();
        $utils=new Utils();
        $defaultLanguage=$utils->cfg()['defaultLanguage'];
        $loader->setlocale($defaultLanguage);
        $loader->textdomain('i18n');
        $root=$utils->cfg()['root'];
        $loader->bindtextdomain('i18n', $root. '/locale/');
        $translator = $loader->getTranslator();
        $out=$translator->gettext($in);
        if ($print) {
            $utils->e($out);
        } else {
            return $out;
        }
    }
}

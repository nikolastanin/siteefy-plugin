<?php

use eftec\bladeone\BladeOne;



class Siteefy {
    private static $blade = null;

    public static function blade() {
        if (self::$blade === null) {
            $views = __DIR__ . '/templates/blade';  // Template files
            $cache = __DIR__ . '/cache';      // Cache folder
            self::$blade = new BladeOne($views, $cache, BladeOne::MODE_DEBUG);
        }
        return self::$blade;
    }

}
//$t = new TwigLoader();
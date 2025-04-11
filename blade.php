<?php

use eftec\bladeone\BladeOne;



class Siteefy {
    private static $blade = null;

    /**
     * @throws Exception
     */
    public static function blade() {
        if (self::$blade === null) {
            $views = __DIR__ . '/templates/blade';  // Template files
            $cache = __DIR__ . '/cache';      // Cache folder
            if(Siteefy::get_env()==='prod' || Siteefy::get_env() ==='stg'){
                self::$blade = new BladeOne($views, $cache, BladeOne::MODE_FAST);
            }else{
                self::$blade = new BladeOne($views, $cache, BladeOne::MODE_DEBUG);
            }
        }
        return self::$blade;
    }

    public static function get_env() {
        $transient_key = 'site_env';
        $env = get_transient($transient_key);

        if ($env === false) {
            $url = $_SERVER['HTTP_HOST'] ?? '';
            if (strpos($url, 'localhost') !== false) {
                $env = 'dev';
            } elseif (strpos($url, 'wordpress-') !== false) {
                $env = 'stg';
            } elseif (strpos($url, 'siteefy') !== false) {
                $env = 'prod';
            } else {
                $env = 'unknown';
            }

            set_transient($transient_key, $env, 12 * HOUR_IN_SECONDS); // Cache for 12 hours
        }

        return $env;
    }

    public static function get_plugin_version(){
        $env = self::get_env();

        if($env === 'dev'){
            return time();
        }else{
            return '1.55';
        }
    }

}
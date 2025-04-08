<?php
define('CATEGORY_PAGE_SLUG', 'categories');
define('CATEGORY_PAGE_PATH', '/categories');
define('SOLUTION_PAGE_SLUG', 'solutions');
define('SOLUTION_PAGE_PATH', '/solutions');

function get_siteefy_settings($array_key){
    if(Siteefy::get_env()==='dev'){
        $use_cache = false;
    }else{
        $use_cache = true;
    }
    $array =  array(
        'use_cache'=>$use_cache,
    );
    if(array_key_exists($array_key, $array)){
        return $array[$array_key];
    }else{
        throw new Exception('error - no siteefy settings set.');
    }
}
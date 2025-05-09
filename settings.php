<?php
//how is the tax called and used in %category%
define('CATEGORY_TAX_NAME', 'category');
define('SOLUTION_TAX_NAME', 'solution');

//page slug wihout /
define('CATEGORY_PAGE_SLUG', 'categories');
define('SOLUTION_PAGE_SLUG', 'solutions');

//page path
define('CATEGORY_PAGE_PATH', '/categories');
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
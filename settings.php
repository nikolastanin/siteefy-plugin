<?php


function get_siteefy_settings($array_key){
    $array =  array(
        'use_cache'=>false,
    );
    if(array_key_exists($array_key, $array)){
        return $array[$array_key];
    }else{
        throw new Exception('error - no siteefy settings set.');
    }
}
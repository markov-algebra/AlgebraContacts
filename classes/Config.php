<?php

class Config{

//defoltna vrijednost je null ako netko zove get da ne pukneS
       
public static function get($path = null){

    if ($path){
        $items = require_once 'config/' . $path . '.php';
        return $items;

        }
        return false;
    }

}

?>
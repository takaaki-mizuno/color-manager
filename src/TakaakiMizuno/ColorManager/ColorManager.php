<?php

namespace TakaakiMizuno\ColorManager;

class ColorManager {

    private static $instance = null;
    private static $categories = array();

    function __construct() {
        self::$categories = array
            (
             "dic"  => ColorCategoryDIC::getInstance(),
             "dic2" => ColorCategoryDIC2::getInstance(),
             );
    }

    function __destruct() {
    }

	public static function getInstance() {
        if (is_null(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    function getSimilarColor($color, $categories=array()) {
        if( is_string( $color ) ){
            $color = new Color($color);
        }
        if( count($categories) === 0 ){
            $categories = array_keys(self::$categories);
        }
        $candidates = array();
        foreach( $categories as $name ){
            if( array_key_exists($name, self::$categories) ){
                $candidates[] = self::$categories[$name];
            }
        }
        if( count($candidates) == 0 ){
            return null;
        }
        $min_dist = 1000;
        $min_name = null;
        foreach( $candidates as $value ){
            $name = $value->getSimilarColor($color);
            if( $name !== null ){
                $dist = $value->getDistance($color, $name);
                if( $dist < $min_dist ){
                    $min_dist = $dist;
                    $min_name = $name;
                }
            }
        }
        return $min_name;
    }

    function getColor($colorName) {
        foreach( self::$categories as $name => $instance ) {
            $color = $instance->getColor($colorName);
            if( $color !== null ){
                return $color;
            }
        }
        return null;
    }
}

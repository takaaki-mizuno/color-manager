<?php

namespace TakaakiMizuno\ColorManager;

class ColorCategory {

    protected static $instance = null;
    protected static $colors = array ();

    function __construct() {
    }

    function __destruct() {
    }

    public static function getInstance() {
        if (is_null(static::$instance)) {
            self::$instance = new static;
        }
        return self::$instance;
    }

    function getColor($name) {
        $name = strtolower($name);
        if( array_key_exists($name, static::$colors) ){
            return new Color(static::$colors[$name]["hex"]);
        }
        return null;
    }

    private function _calcDistance( $yuv, $carray ) {
        $dist = pow( ( $yuv["y"] - $carray["y"] ) , 2)
            + pow( ( $yuv["u"] - $carray["u"] ) , 2)
            + pow( ( $yuv["v"] - $carray["v"] ) , 2);
        return $dist;
    }

    private function _checkColorObject( $color ){
        if( is_string( $color ) ){
            $color = new Color($color);
        }
        if( !($color instanceof Color) ){
            throw new UnexpectedValueException('String or Color object expected');
        }
        return $color;
    }

    function getSimilarColor($color) {
        $color = $this->_checkColorObject($color);
        $min_dist = 1000;
        $min_name = null;
        foreach( static::$colors as $name => $carray ){
            $dist = $this->_calcDistance($color->getYUV(), $carray);
            if( $dist < $min_dist ){
                $min_dist = $dist;
                $min_name = $name;
            }
        }
        return $min_name;
    }

    function getDistance($color, $name) {
        $color = $this->_checkColorObject($color);
        if( !array_key_exists($name, static::$colors) ){
            throw new UnexpectedValueException('Color Name "'.$name.'" is not a member of this category');
        }
        return $this->_calcDistance($color->getYUV(), static::$colors[$name]);
    }
}
<?php

namespace TakaakiMizuno\ColorManager;

use UnexpectedValueException;

class Color {

    private $_hex;
    private $_hsv;
    private $_rgb;
    private $_yuv;

    function __construct($hex) {
        if( is_string( $hex ) && preg_match('/^\#?(([A-Fa-f0-9]{3})|([A-Fa-f0-9]{6}))$/',$hex,$matches) ){
            $hex = $matches[1];
            if( strlen($hex) === 3 ) {
                $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
            }
        }else{
            throw new UnexpectedValueException('You need to specify 6 digit hex string like "FFFFFF"');
        }
        $this->_hex = $hex;
        $this->_rgb = array(
                            "red"   => ((int) hexdec($hex[0].$hex[1]) / 255 ),
                            "green" => ((int) hexdec($hex[2].$hex[3]) / 255 ),
                            "blue"  => ((int) hexdec($hex[4].$hex[5]) / 255 ),
                             );
        $this->_setHSV();
        $this->_setYUV();
    }

    function __destruct() {
    }

    private function _setHSV() {
        $r = $this->_rgb["red"];
		$g = $this->_rgb["green"];
		$b = $this->_rgb["blue"];

		$max = max($r, $g, $b);
		$min = min($r, $g, $b);
		$delta = $max - $min;

		$h = 0;
		$s = ($max === 0) ? 0 : $delta / $max;
		$v = $max;

		if ($max !== $min) {
            if( $max === $r ){
				$h = 60 * ($g - $b) / $delta;
            }else if( $max === $g ){
				$h = 60 * ($b - $r) / $delta + 120;
			}else {
				$h = 60 * ($r - $g) / $delta + 240;
			}
			$h = ( $h < 0 ) ? $h + 360 : $h;
		}

        $this->_hsv = array(
                            "hue"        => $h,
                            "saturation" => $s,
                            "value"      => $v
                            );
    }

    private function _setYUV() {
        $r = $this->_rgb["red"];
		$g = $this->_rgb["green"];
		$b = $this->_rgb["blue"];
        $this->_yuv = array(
                            "y" => 0.299 * $r + 0.587 * $g + 0.114 * $b,
                            "u" => -0.14713 * $r - 0.28886 * $g + 0.436 * $b,
                            "v" => 0.615 * $r - 0.51499 * $g - 0.10001 * $b
                            );
    }

    function getHEX() {
        $clone = $this->_hex;
        return $clone;
    }

    function getRGB() {
        $clone = $this->_rgb;
        return $clone;
    }

    function getHSV() {
        $clone = $this->_hsv;
        return $clone;
    }

    function getYUV() {
        $clone = $this->_yuv;
        return $clone;
    }

}

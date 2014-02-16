<?php

$superGlobals = array();

class ColorManagerTest extends \PHPUnit_Framework_TestCase
{

	public function setUp() {
        $this->colorManager = TakaakiMizuno\ColorManager\ColorManager::getInstance();
	}

    public function testGetColor(){
        $color = $this->colorManager->getColor("dic-151");
        $this->assertTrue(($color instanceof TakaakiMizuno\ColorManager\Color), "getColor does'nt return Color object");
        $this->assertEquals("C01F9D", $color->getHex());
    }

    public function testGetSimilarColor() {
        $color = new TakaakiMizuno\ColorManager\Color("01B698");
        $dic_name = $this->colorManager->getSimilarColor($color);
        $this->assertEquals("dic-649 b", $dic_name);

        $dic_name = $this->colorManager->getSimilarColor($color, array( "dic2" ));
        $this->assertEquals("dic-2128", $dic_name);

    }

}
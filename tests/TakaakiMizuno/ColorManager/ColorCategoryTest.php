<?php

$superGlobals = array();

class ColorCategoryTest extends \PHPUnit_Framework_TestCase
{

	public function setUp() {
		$this->colorCategories = array
            (
             "dic"  => TakaakiMizuno\ColorManager\ColorCategoryDIC::getInstance(),
             "dic2" => TakaakiMizuno\ColorManager\ColorCategoryDIC2::getInstance()
             );
	}

    public function testColor() {
        $color = new TakaakiMizuno\ColorManager\Color("FFFF00");
        $rgb = $color->getRGB();
        $this->assertEquals(1, $rgb["red"]);
        $this->assertEquals(1, $rgb["green"]);
        $this->assertEquals(0, $rgb["blue"]);
    }

    public function testGetColorDIC() {
        $dic2 = $this->colorCategories['dic']->getColor("dic-2");
		$this->assertTrue($dic2 instanceof TakaakiMizuno\ColorManager\Color, "getColor does'nt return Color object");
        $this->assertEquals("F4C5B6", $dic2->getHEX(), "Hex Color is different from DIC-2");
        $dic2 = $this->colorCategories['dic']->getColor("DIC-2");
		$this->assertTrue($dic2 instanceof TakaakiMizuno\ColorManager\Color, "getColor does'nt return Color object");
        $this->assertEquals("F4C5B6", $dic2->getHEX(), "Hex Color is different from DIC-2");
    }

    public function testGetColorDIC2() {
        $dic2003 = $this->colorCategories['dic2']->getColor("dic-2003");
		$this->assertTrue($dic2003 instanceof TakaakiMizuno\ColorManager\Color, "getColor does'nt return Color object");
        $this->assertEquals("F79FBA", $dic2003->getHEX(), "Hex Color is different from DIC-2003");
        $dic2003 = $this->colorCategories['dic2']->getColor("DIC-2003");
		$this->assertTrue($dic2003 instanceof TakaakiMizuno\ColorManager\Color, "getColor does'nt return Color object");
        $this->assertEquals("F79FBA", $dic2003->getHEX(), "Hex Color is different from DIC-2003");
    }

    public function testGetSimilarColorDIC() {
        $color = new TakaakiMizuno\ColorManager\Color("01B698");
        $dic_name = $this->colorCategories['dic']->getSimilarColor($color);
        $this->assertEquals("dic-649 b", $dic_name);
    }

    public function testGetSimilarColorDIC2() {
        $color = new TakaakiMizuno\ColorManager\Color("C9E572");
        $dic_name = $this->colorCategories['dic2']->getSimilarColor($color);
        $this->assertEquals("dic-2100", $dic_name);
    }

}

<?php
/**
 * 外观模式
 */

interface Product
{
	public function produce();
}

class ProductA implements Product
{
	public function produce()
	{
		echo "product A\n";
	}
}

class ProductB implements Product
{
	public function produce()
	{
		echo "product B\n";
	}
}

class ProductFacade
{
	private $productA;
	private $productB;

	function __construct()
	{
		$this->productA = new ProductA();
		$this->productB = new ProductB();
	}

	public function produceA()
	{
		$this->productA->produce();
	}

	public function produceB()
	{
		$this->productB->produce();
	}
}


//test
$facade = new ProductFacade();

$facade->produceA();
$facade->produceB();
<?php
/**
 * 组合模式
 * 将一组对象组合为可以像单个对象一样被使用的结构
 */

class UnitException extends Exception
{

}

/**
 * 战斗单元
 */
abstract class Unit
{
	abstract public function bombardStrength();

	public function addUnit(Unit $unit)
	{
		throw new UnitException(get_class($this) . "is a leaf");
	}

	public function removeUnit(Unit $unit)
	{
		throw new UnitException(get_class($this) . "is a leaf");
	}
}

/**
 * 射手
 */
class Archer extends Unit
{
	public function bombardStrength()
	{
		return 4;
	}
}

/**
 * 激光炮
 */
class LaserCannon extends Unit
{
	public function bombardStrength()
	{
		return 40;
	}
}

/**
 * 军队
 */
class Army extends Unit
{
	private $units = [];

	public function addUnit(Unit $unit)
	{
		if (in_array($unit, $this->units, true)) {
			return;
		}
		$this->units[] = $unit;
	}

	public function removeUnit(Unit $unit)
	{
		$this->units = array_udiff($this->units, [$unit], function ($a, $b) {
			return ($a === $b) ? 0 : 1;
		});
	}

	public function bombardStrength()
	{
		$ret = 0;
		foreach ($this->units as $unit) {
			$ret += $unit->bombardStrength();
		}
		return $ret;
	}
}


//test

$mainArmy = new Army();
$mainArmy->addUnit(new Archer());
$mainArmy->addUnit(new LaserCannon());
echo $mainArmy->bombardStrength() . "\n";


$subArmy = new Army();
$subArmy->addUnit(new Archer());
$subArmy->addUnit(new Archer());
echo $subArmy->bombardStrength() . "\n";

$mainArmy->addUnit($subArmy);
echo $mainArmy->bombardStrength() . "\n";
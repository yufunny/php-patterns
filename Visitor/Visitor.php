<?php
/**
 * 访问者模式
 */

 class UnitException extends Exception
 {

 }

 /**
  * 战斗单元
  */
 abstract class Unit
 {
     protected $depth;
 	abstract public function bombardStrength();

 	public function addUnit(Unit $unit)
 	{
 		throw new UnitException(get_class($this) . "is a leaf");
 	}

 	public function removeUnit(Unit $unit)
 	{
 		throw new UnitException(get_class($this) . "is a leaf");
 	}

    /**
     * 定义accept方法
     */
     public function accept(ArmyVisitor $visitor)
     {
         $method = "visit" . get_class($this);
         $visitor->$method($this);
     }

     protected function setDepth($depth)
     {
         $this->depth = $depth;
     }

     public function getDepth()
     {
         return $this->depth;
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
  * 在组合类中定义accpet方法
  */
 class Army extends Unit
 {
 	private $units = [];

 	public function addUnit(Unit $unit)
 	{
 		if (in_array($unit, $this->units, true)) {
 			return;
 		}
        $unit->setDepth($this->depth + 1);
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

    public function accept(ArmyVisitor $visitor)
    {
        parent::accept($visitor);
        foreach ($this->units as $unit) {
            $unit->accept($visitor);
        }
    }
 }

abstract class ArmyVisitor
{
    abstract function visit(Unit $node);
    public function visitArcher(Archer $node)
    {
        $this->visit($node);
    }

    public function visitLaserCannon(LaserCannon $node)
    {
        $this->visit($node);
    }

    public function visitArmy(Army $node)
    {
        $this->visit($node);
    }
}

class TextDumpArmyVisitor extends ArmyVisitor
{
    private $text = "";

    public function visit(Unit $node)
    {
        $ret = "";
        $pad = 4 * $node->getDepth();
        $ret .= sprintf("%{$pad}s", " ");
        $ret .= get_class($node) . ": ";
        $ret .= "bombard: " . $node->bombardStrength() . "\n";
        $this->text .= $ret;
    }

    public function getText()
    {
        return $this->text;
    }
}


//test
$mainArmy = new Army();
$mainArmy->addUnit(new Archer());
$mainArmy->addUnit(new LaserCannon());

$subArmy = new Army();
$mainArmy->addUnit($subArmy);
$subArmy->addUnit(new Archer());
$subArmy->addUnit(new Archer());
$subArmy->addUnit(new Archer());


$textDump = new TextDumpArmyVisitor();
$mainArmy->accept($textDump);
echo $textDump->getText();

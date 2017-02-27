<?php
/**
 * 原型模式
 */

interface Prototype
{
    public function copy();
}

class ColorPrototype
{
    private $R;
    private $G;
    private $B;

    public function __construct($r = 0, $g = 0, $b = 0)
    {
        $this->R = $r;
        $this->G = $g;
        $this->B = $b;
    }

    public function setR($r)
    {
        $this->R = $r;
        return $this;
    }

    public function getR()
    {
        return $this->R;
    }

    public function setG($g)
    {
        $this->G = $g;
        return $this;
    }

    public function getG()
    {
        return $this->G;
    }

    public function setB($b)
    {
        $this->B = $b;
        return $this;
    }

    public function getB()
    {
        return $this->B;
    }

    public function printRGB()
    {
        echo "({$this->R}, {$this->G}, {$this->B})\n";
    }

    public function copy()
    {
        return clone $this; //浅复制
        // return unserialize(serialize($this)); //深复制
    }
}

//test

$black = new ColorPrototype();
$red = $black->copy()->setR(255);
$black->printRGB();
$red->printRGB();

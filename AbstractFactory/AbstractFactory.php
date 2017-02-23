<?php
/**
 * 抽象工厂模式
 * 同一工厂生成一系列产品，保证产品的一致性
 */

interface Factory
{
    public function createProductA();
    public function createProductB();
    public function createProductC();
}

class FactoryX implements Factory
{
    public function createProductA()
    {
        return new ProductA_X();
    }
    public function createProductB()
    {
        return new ProductB_X();
    }
    public function createProductC()
    {
        return new ProductC_X();
    }
}

class FactoryY implements Factory
{
    public function createProductA()
    {
        return new ProductA_Y();
    }
    public function createProductB()
    {
        return new ProductB_Y();
    }
    public function createProductC()
    {
        return new ProductC_Y();
    }
}


interface ProductA
{

}

interface ProductB
{

}

interface ProductC
{

}

class ProductA_X implements ProductA
{
    public function __construct()
    {
        echo "I am product A_X\n";
    }
}

class ProductA_Y implements ProductA
{
    public function __construct()
    {
        echo "I am product A_Y\n";
    }
}

class ProductB_X implements ProductB
{
    public function __construct()
    {
        echo "I am product B_X\n";
    }
}

class ProductB_Y implements ProductB
{
    public function __construct()
    {
        echo "I am product B_Y\n";
    }
}

class ProductC_X implements ProductC
{
    public function __construct()
    {
        echo "I am product C_X\n";
    }
}

class ProductC_Y implements ProductC
{
    public function __construct()
    {
        echo "I am product C_Y\n";
    }
}


//test
//
$factoryX = new FactoryX();
$productAX = $factoryX->createProductA();
$productBX = $factoryX->createProductB();
$productCX = $factoryX->createProductC();


$factoryY = new FactoryY();
$productAY = $factoryY->createProductA();
$productBY = $factoryY->createProductB();
$productCY = $factoryY->createProductC();

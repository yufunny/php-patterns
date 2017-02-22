<?php
/**
 * 工厂方法模式
 */

interface Factory
{
    public function createProduct();
}

class FactoryA implements Factory
{
    public function createProduct()
    {
        return new ProductA();
    }
}

interface Product
{

}

class ProductA implements Product
{
    public function __construct()
    {
        echo "product A\n";
    }
}

/**
 * 参数化工厂方法
 */
class FactoryWithArgs implements Factory
{
    public function createProduct($type='')
    {
        switch ($type) {
            case 'A' :
                return new ProductA();
                break;
            case 'B' :
                return new ProductB();
                break;
            default :
                echo "不支持的产品";
                break;
        }
    }
}

class ProductB implements Product
{
    public function __construct()
    {
        echo "product B\n";
    }
}

//test

$factory = new FactoryA();
$product = $factory->createProduct();

$factory = new FactoryWithArgs();
$product = $factory->createProduct('B');

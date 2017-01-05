<?php

/**
 * 单例模式
 */

class Singleton{
	private $props = [];
	private static $instance;	//私有静态属性

	/**
	 * 禁止外部生成对象
	 */
	private function __construct()
	{

	}

	/**
	 * 禁止克隆对象
	 */
  	public function __clone()
  	{

  	}

  	/**
  	 * 通过静态方法获取单一实例
  	 */
	public static function getInstance()
	{
		if (empty( self::$instance )) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	public function setProperty($key, $val)
	{
		$this->props[$key] = $val;
	}

	public function getProperty($key)
	{
		return $this->props[$key];
	}
}


//test

$obj = Singleton::getInstance();
$obj->setProperty("name", "foo");

unset($obj);	//注销$obj

$obj2 = Singleton::getInstance();

echo $obj2->getProperty('name'); //仍然输出foo
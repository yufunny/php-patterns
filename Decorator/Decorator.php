<?php
/**
 * 装饰模式
 * 通过在运行时合并对象来扩展功能
 */

/**
 * 请求类
 */
class RequestHelper
{

}

/**
 * 处理请求的抽象基类
 */
abstract class ProcessRequest
{
	abstract function process(RequestHelper $request);
}

/**
 * 具体的请求处理
 */
class MainProcess extends ProcessRequest
{
	function process(RequestHelper $request)
	{
		echo __CLASS__ . ": doing something useful with request\n";
	}
}

/**
 * 抽象装饰类
 */
abstract class DecorateProcess extends ProcessRequest
{
	protected $processRequest;

	function __construct(ProcessRequest $process)
	{
		$this->processRequest = $process;
	}
}

/**
 * 具体的装饰类
 */
class LogRequest extends DecorateProcess
{
	function process(RequestHelper $request)
	{
		echo __CLASS__ . ": logging request\n";
		$this->processRequest->process($request);
	}
}

class AuthenticateRequest extends DecorateProcess
{
	function process(RequestHelper $request)
	{
		echo __CLASS__ . ": authenticating request\n";
		$this->processRequest->process($request);
	}
}

class StructureRequest extends DecorateProcess
{
	function process(RequestHelper $request)
	{
		echo __CLASS__ . ": structing request data\n";
		$this->processRequest->process($request);
	}
}



//test

$process = new AuthenticateRequest(new StructureRequest(new LogRequest(new MainProcess())));
$process->process(new RequestHelper());
echo "\n\nprocess2:\n";
$process2 = new LogRequest(new AuthenticateRequest(new StructureRequest(new MainProcess())));
$process2->process(new RequestHelper());
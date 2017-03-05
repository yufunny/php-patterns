<?php
/**
 * 命令模式
 */

/**
 * 命令接口
 */
 interface Command
 {
     public function execute(CommandContext $context);
 }

/**
 * 登录命令
 */
 class LoginCommand implements Command
 {
     public function execute(CommandContext $context)
     {
         $user = $context->get('username');
         $pass = $context->get('pass');
         echo "user:{$user}\npass:{$pass}\n";
         return true;
     }
 }

/**
 * 要处理的对象
 */
 class CommandContext
 {
     private $params = [];
     private $error = "";
     function __construct()
     {
         $this->params = $_REQUEST;
     }

     public function addParam($key, $value)
     {
         $this->params[$key] = $value;
     }

     public function get($key)
     {
         return $this->params[$key];
     }

     public function setError($error)
     {
         $this->error = $error;
     }

     public function getError($error)
     {
         return $this->error;
     }
 }

 class CommandNotFoundException extends Exception
 {

 }

/**
 * 生成命令对象，实例化命令对象的客户端（client）
 */
 class CommandFactory
 {
     public static function getCommand($action = 'Default')
     {
         if (preg_match('/\W/', $action)) {
             throw new Exception("illegal characters in action");
         }
         $class = ucfirst(strtolower($action)) . "Command";
         if (!class_exists($class)) {
             throw new CommandNotFoundException("no '$class' class");
         }
         return new $class();
     }
 }

/**
 * 调用命令（invoker）
 */
 class Controller
 {
     private $context;
     function __construct()
     {
         $this->context = new CommandContext();
     }

     public function getContext()
     {
         return $this->context;
     }

     public function process()
     {
         $cmd = CommandFactory::getCommand($this->context->get('action'));
         if ($cmd->execute($this->context)) {
             echo "execute success\n";
         } else {
             echo "execute failed\n";
         }
     }
 }

 $controller = new Controller();
 $context = $controller->getContext();
 $context->addParam("action", "Login");
 $context->addParam("username", "cat");
 $context->addParam("pass", "dog");

 $controller->process();

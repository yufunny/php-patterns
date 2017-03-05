<?php
/**
 * 观察者模式
 */

/**
 * Observable接口 被观察者
 */
 interface Observable
 {
     public function attach(Observer $observer);
     public function detach(Observer $observer);
     public function notify();
 }

/**
 * 登录
 */
 class Login implements Observable
 {
     private $observers;

     function __construct()
     {
         $this->observers = [];
     }

     const LOGIN_USER_UNKNOW = 1;
     const LOGIN_WRONG_PASS = 2;
     const LOGIN_ACCESS = 3;

     public function handleLogin($user, $pass, $ip)
     {
         switch (rand(1, 3)) {
             case 1:
                 $this->setStatus(self::LOGIN_USER_UNKNOW, $user, $ip);
                 $ret = false;
                 break;
             case 2:
                 $this->setStatus(self::LOGIN_WRONG_PASS, $user, $ip);
                 $ret = false;
                 break;
             case 3:
                 $this->setStatus(self::LOGIN_ACCESS, $user, $ip);
                 $ret = true;
                 break;
         }
         $this->notify();
         return $ret;
     }

     public function setStatus($status, $user, $ip)
     {
         $this->status = array($status, $user, $ip);
     }

     public function getStatus(){
         return $this->status;
     }

     public function attach(Observer $observer)
     {
         $this->observers[] = $observer;
     }

     public function detach(Observer $observer)
     {
         $newObservers = [];
         foreach ($this->observers as $obs) {
             if ($obs !== $observer) {
                 $newObservers[] = $obs;
             }
         }
         $this->observers = $newObservers;
     }

     public function notify()
     {
         foreach ($this->observers as $obs) {
             $obs->update($this);
         }
     }
 }

/**
 * Observer接口
 */
 interface Observer
 {
     public function update(Observable $observable);
 }

 abstract class LoginObserver implements Observer
 {
     private $login;
     function __construct(Login $login)
     {
         $this->login = $login;
         $login->attach($this);
     }

     public function update(Observable $observable)
     {
         if ($observable === $this->login) {
             $this->doUpdate($observable);
         }
     }

     abstract public function doUpdate(Login $login);
 }

 class SecurityMonitor extends LoginObserver
 {
     public function doUpdate(Login $login)
     {
         $status = $login->getStatus();
         if ($status[0] === Login::LOGIN_WRONG_PASS) {
             echo __CLASS__ . ":\t sending mail to system admin\n";
         }
     }
 }

 class GeneralLogger extends LoginObserver
 {
     public function doUpdate(Login $login)
     {
         $status = $login->getStatus();
         echo __CLASS__ . ":\t add login data to log\n";
     }
 }

 class PartnershipTool extends LoginObserver
 {
     public function doUpdate(Login $login)
     {
         $status = $login->getStatus();
         echo __CLASS__ . ":\t set cookie if IP matches a list\n";
     }
 }

$login = new Login();
new SecurityMonitor($login);
new GeneralLogger($login);
new PartnershipTool($login);

$login->handleLogin("cat", "123456", "127.0.0.1");

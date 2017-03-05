<?php
/**
 * 策略模式
 */

 interface Strategy
 {
   public function deal();
 }

 class StrategyA implements Strategy
 {
   public function deal()
   {
     echo "Strategy A\n";
   }
 }

 class StrategyB implements Strategy
 {
   public function deal()
   {
     echo "Strategy B\n";
   }
 }

 abstract class Substance
 {
   private $strategy;

   function __construct(Strategy $strategy)
   {
     $this->strategy = $strategy;
   }

   public function deal()
   {
     $this->strategy->deal();
   }
 }

 class SubstanceA extends Substance
 {
   //do something
 }

 class SubstanceB extends Substance
 {
   //do something
 }


 //test
 $substanceA1 = new SubstanceA(new StrategyA());
 $substanceA1->deal();
 $substanceA2 = new SubstanceA(new StrategyB());
 $substanceA2->deal();

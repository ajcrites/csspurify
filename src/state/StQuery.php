<?php
/**
 * The purpose of this file is to in-query state
 * @author Andrew Crites <explosion-pills@aysites.com>
 * @copyright 2012
 * @package csspurify
 */

/**
 * Non-empty query state class
 */
class StQuery implements Statable {

   public function startValue() {
      return new OpQuery;
   }

   public function startQuery() {
      return new OpQuery;
   }

   public function startRuleset() {
      return new OpInitQuery;
   }

   /**
    * Report error for inconsistent state
    * @param string
    */
   public function err($attempted) {
      throw new InconsistentStateException("Attempting to move to state $attempted, but"
         . " this is invalid.  We are currently in the Query state.");
   }

   /**#@+
    * Inconsistent states
    */
   public function endRule() {
      $this->err('end rule');
   }
   public function endRuleset() {
      $this->err('end ruleset');
   }
   public function startRule() {
      $this->err('start rule');
   }
   /**#@-*/
}
?>

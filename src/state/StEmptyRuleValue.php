<?php
/**
 * The purpose of this file is to define the empty rule value state class
 * @author Andrew Crites <andrew@gleim.com>
 * @copyright 2012
 * @package csspurify
 */

/**
 * Empty Rule Value class.  Rule-completing token was just received
 */
class StEmptyRuleValue implements Statable {
   /**
    * Move to rule value state.  A value for this rule has been received, so it is no longer empty
    */
   public function startValue() {
      return new StRuleValue;
   }

   /**
    * Error reporting for inconsistent state
    */
   public function err($attempted) {
      throw new InconsistentStateException("Attempting to move to state $attempted, but"
         . " this is invalid.  We are currently in the Empty Rule Value state.");
   }

   /**#@+
    * Inconsistent states
    */
   public function startRuleset() {
      $this->err('start ruleset');
   }
   public function startRule(CssPurify $parser) {
      $this->err('start rule');
   }
   public function endRule() {
      $this->err('end rule');
   }
   public function endRuleset() {
      $this->err('end ruleset');
   }
   /**#@-*/
}
?>

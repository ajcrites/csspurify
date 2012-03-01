<?php
/**
 * The purpose of this file is to define the rule value state
 * @author Andrew Crites <andrew@gleim.com>
 * @copyright 2012
 * @package csspurify
 */

/**
 * Rule Value state class (actual value of a rule, not its definition)
 */
class StRuleValue implements Statable {
   /**
    * Move to the empty rule state.  Rule has ended, so we must now start to define a new rule, or
    * end the ruleset
    */
   public function endRule() {
      return new StEmptyRule;
   }

   /**
    * Report error for inconsistent state
    * @param string
    */
   public function err($attempted) {
      throw new InconsistentStateException("Attempting to move to state $attempted, but"
         . " this is invalid.  We are currently in the Empty Rule Value state.");
   }

   /**#@+
    * Inconsistent states
    */
   public function startRule(CssPurify $parser) {
      $this->err('start value');
   }
   public function startValue() {
      $this->err('start value');
   }
   public function startRuleset() {
      $this->err('start ruleset');
   }
   public function endRuleset() {
      $this->err('end ruleset');
   }
   /**#@-*/
}
?>

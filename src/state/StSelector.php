<?php
/**
 * The purpose of this file is to define the in-selector state
 * @author Andrew Crites <andrew@gleim.com>
 * @copyright 2012
 * @package csspurify
 */

/**
 * Non-empty selector state class
 */
class StSelector implements Statable {
   /**
    * Move to the empty rule state.  The selector is completed -- this is indicated by a start ruleset
    * token, so now we need to start defining rules
    */
   public function startRuleset() {
      return new StEmptyRule;
   }

   /**
    * Add rule start to value.  The rule-start token is valid in selectors and its value should be added.
    * This does not change the state from selector, though.
    */
   public function startRule(CssPurify $parser) {
      $parser->startRuleInSelector();
      return $this;
   }

   /**
    * Report error for inconsistent state
    * @param string
    */
   public function err($attempted) {
      throw new InconsistentStateException("Attempting to move to state $attempted, but"
         . " this is invalid.  We are currently in the Non-empty selector state.");
   }

   /**#@+
    * Inconsistent states
    */
   public function startValue() {
      $this->err('start value');
   }
   public function endRule() {
      $this->err('end ruleset');
   }
   public function endRuleset() {
      $this->err('end ruleset');
   }
   /**#@-*/
}
?>

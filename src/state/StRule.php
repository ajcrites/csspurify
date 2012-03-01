<?php
/**
 * The purpose of this file is to define the rule state class
 * @author Andrew Crites <andrew@gleim.com>
 * @copyright 2012
 * @package csspurify
 */

/**
 * Rule state class (this defines a rule, not a rule value)
 */
class StRule implements Statable {
   /**
    * Move to the rule value state; no value is to be appended to the tree
    */
   public function startRule(CssPurify $parser) {
      return $parser->startRuleValueInRule();
   }

   /**
    * Do not move state.  Values are valid in rule definitions
    */
   public function startValue() {
      return $this;
   }

   /**
    * Report error for inconsistent state
    * @param string
    */
   public function err($attempted) {
      throw new InconsistentStateException("Attempting to move to state $attempted, but"
         . " this is invalid.  We are currently in the Rule state.");
   }

   /**#@+
    * Inconsistent states
    */
   public function startRuleset() {
      $this->err('start ruleset');
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

<?php
/**
 * The purpose of this file is to define the empty-selector state class
 * @author Andrew Crites <andrew@gleim.com>
 * @copyright 2012
 * @package csspurify
 */

/**
 * Class for state where no selector entry is defined
 * initial state, or immediately after a ruleset
 */
class StEmptySelector implements Statable {
   /**
    * Move to selector state.  Value received; we are no longer an empty selector
    * @return StSelector
    */
   public function startValue() {
      return new StSelector;
   }

   public function startQuery() {
      return new StQuery;
   }

   /**
    * Handle start-rule token in selector.  This is a valid selector component, so we are now in the
    * selector state
    */
   public function startRule(CssPurify $parser) {
      $parser->startRuleInSelector();
      return new StSelector;
   }

   public function endRuleset(CssPurify $parser) {
      $parser->exitQuery();
      return $this;
   }

   /**
    * Report error for inconsistent state
    * @param string
    */
   public function err($attempted) {
      throw new InconsistentStateException("Attempting to move to state $attempted, but"
         . " this is invalid.  We are currently in the Empty Selector state.");
   }

   /**#@+
    * Inconsistent states
    */
   public function startRuleset(CssPurify $parser) {
      $this->err('start ruleset');
   }
   public function endRule() {
      $this->err('end rule');
   }
   /**#@-*/
}
?>

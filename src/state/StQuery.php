<?php
/**
 * The purpose of this file is to in-query state
 * @author Andrew Crites <andrew@gleim.com>
 * @copyright 2012
 * @package csspurify
 */

/**
 * Non-empty query state class
 */
class StQuery implements Statable {
   public function startRule(CssPurify $parser) {
      $this->err('start rule');
   }

   public function startValue() {
      return $this;
   }

   public function startQuery() {
      return $this;
   }

   public function startRuleset(CssPurify $parser) {
      $parser->initQuery();
      return new StEmptySelector;
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
   public function endRuleset(CssPurify $parser) {
      $this->err('end ruleset');
   }
   /**#@-*/
}
?>

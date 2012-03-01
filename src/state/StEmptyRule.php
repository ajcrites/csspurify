<?php
/**
 * The purpose of this file is to define the Empty Rule state class
 * @author Andrew Crites <explosion-pills@aysites.com>
 * @copyright 2012
 * @package csspurify
 */

/**
 * Empty rule (rule definition has just finished; we are beginning a new rule)
 */
class StEmptyRule implements Statable {
   /**
    * Move to Start Rule state.  Value has been received for the new rule; it is no longer empty
    * @return StRule
    */
   public function startValue() {
      return new StRule;
   }

   /**
    * Move to Empty Selector state.  Ruleset is finished.  No more rules defined.  Empty ruleset.
    * @return StEmptySelector
    */
   public function endRuleset() {
      return new StEmptySelector;
   }

   public function err($attempted) {
      throw new InconsistentStateException("Attempting to move to state $attempted, but"
         . " this is invalid.  We are currently in the Empty Rule state.");
   }

   /**#@+
    * Invalid states
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
   /**#@-*/
}
?>

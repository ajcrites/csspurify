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
    * @return OpRule
    */
   public function startValue() {
      return new OpRule;
   }

   /**
    * 
    */
   public function startQuery() {
      return new OpRule;
   }

   /**
    * Move to Empty Selector state.  Ruleset is finished.  No more rules defined.  Empty ruleset.
    * @return OpEmptySelector
    */
   public function endRuleset() {
      return new OpEmptySelector;
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
   public function startRule() {
      $this->err('start rule');
   }
   public function endRule() {
      $this->err('end rule');
   }
   /**#@-*/
}
?>

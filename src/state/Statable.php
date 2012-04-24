<?php
/**
 * The purpose of this file is to define the State-control interface
 * @author Andrew Crites <explosion-pills@aysites.com>
 * @copyright 2012
 * @package csspurify
 */

/**
 * State control class
 */
interface Statable {
   /**
    * Move to the query start state
    */
   function startQuery();

   /**
    * Move to a state where a value has initialized
    */
   function startValue();

   /**
    * Move to a state where a ruleset has been initialized
    */
   function startRuleset(CssPurify $parser);

   /**
    * Move to a state where a rule defnition has been initialized
    *
    * The start rule state can occur in the middle of a selector (it is not actually starting
    * a rule in this case, but the same token is used).  The Parser needs to either add the
    * token value to the selector or to discard the value and add the created rule to the tree
    * @param CssPurify
    */
   function startRule(CssPurify $parser);

   /**
    * Move to a state where a rule definition has just been completed
    */
   function endRule();

   /**
    * Move to a state where a ruleset definition has just been completed
    */
   function endRuleset(CssPurify $parser);
}

/**
 * Indicates that the current state is trying to move to a state that it cannot access
 */
class InconsistentStateException extends CssPurifyException {}
?>

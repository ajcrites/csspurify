<?php
/**
 * The purpose of this file is to define the token ending a ruleset (rules tied to a specific selector)
 * @author Andrew Crites <explosion-pills@aysites.com>
 * @copyright 2012
 * @package csspurify
 */

/**
 * Ruleset ending token
 */
final class EndRules implements Tokenable {
   /**
    * Do nothing
    */
   public function append($chars) {}

   /**
    * Retrieve the ruleset-ending token
    */
   public function get() {
      return '}';
   }

   /**
    * Ruleset enders contribute no value and are only valid in a ruleset
    * without any open rules
    * @param CssPurify
    */
   public function expect(CssPurify $parser) {
      return $parser->endRuleset($parser);
   }
}
?>

<?php
/**
 * The purpose of this file is to define the rule-ending token
 * @author Andrew Crites <andrew@gleim.com>
 * @copyright 2012
 * @package csspurify
 */

/**
 * Rule Ending token class
 */
final class EndRule implements Tokenable {
   /**
    * Do nothing
    */
   public function append($chars) {}

   /**
    * Retrieve the css rule-ending token
    */
   public function get() {
      return ';';
   }

   /**
    * Ending Rules are only valid in rules.  They contribute no value.
    * @param CssPurify
    */
   public function expect(CssPurify $parser) {
      $parser->endRule();
   }
}
?>

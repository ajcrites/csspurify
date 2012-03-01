<?php
/**
 * The purpose of this file is to define a class representing the start of a rule
 * @author Andrew Crites <explosion-pills@aysites.com>
 * @copyright 2012
 * @package csspurify
 */

/**
 * Rule starting class
 */
final class StartRule implements Tokenable {
   /**
    * Do nothing
    */
   public function append($chars) {}

   /**
    * Retrieve the rule-ending token
    */
   public function get() {
      return ':';
   }

   /**
    * Rule starters may also be pseudo-classes; Parser knows where it is
    * @param CssPurify
    */
   public function expect(CssPurify $parser) {
      return $parser->startRule();
   }
}
?>

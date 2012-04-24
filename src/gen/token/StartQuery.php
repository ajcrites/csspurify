<?php
/**
 * The purpose of this file is to define a class representing the start of a query
 * @author Andrew Crites <andrew@gleim.com>
 * @copyright 2012
 * @package csspurify
 */

/**
 * Query starting class
 */
final class StartQuery implements Tokenable {
   /**
    * Do nothing
    */
   public function append($chars) {}

   /**
    * Retrieve query starting token
    */
   public function get() {
      return '@';
   }

   /**
    * Start gathering characters for query's own selector
    */
   public function expect(CssPurify $parser) {
      return $parser->startQuery();
   }
}
?>

<?php
/**
 * The purpose of this file is to define a value or "identifier" token
 * @author Andrew Crites <explosion-pills@aysites.com>
 * @copyright 2012
 * @package csspurify
 */

/**
 * Value token class
 */
final class Value implements Tokenable {
   /**
    * @var string contents of the value
    */
   private $token;

   /**
    * Create a value token with some initial content
    * @var string
    */
   public function __construct($token = '') {
      $this->token = $token;
   }

   /**
    * Add content to the value
    * @param string
    */
   public function append($chars) {
      $this->token .= $chars;
   }

   /**
    * Retrieve the value
    * @return string
    */
   public function get() {
      return $this->token;
   }

   /**
    * Values can be selectors, rule declarations, or rules themselves!
    * Values are valid in most places
    * @param CssPurify
    */
   public function expect(CssPurify $parser) {
      $parser->contributeValue($this);
   }
}
?>

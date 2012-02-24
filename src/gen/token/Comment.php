<?php
/**
 * The purpose of this file is to define a token representing a comment
 * @author Andrew Crites <explosion-pills@aysites.com>
 * @copyright 2012
 * @package csspurify
 */

/**
 * Comment token
 */
final class Comment implements Tokenable {
   /**
    * @var string contents of the comment
    */
   private $token;

   /**
    * Create a comment token
    * @param initial token characters
    */
   public function __construct($start) {
      $this->token = $start;
   }

   /**
    * Add content to the comment
    * @param string
    */
   public function append($chars) {
      $this->token .= $chars;
   }

   /**
    * Retrieve the comment
    * @return string
    */
   public function get() {
      return $this->token;
   }

   /**
    * Comments are valid anywhere, but they don't contribute any value
    * @param CssPurify
    */
   public function expect(CssPurify $parser) {
      $parser->addComment($this->get());
   }
}
?>

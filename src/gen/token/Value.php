<?php
final class Value implements Tokenable {
   private $token;

   public function __construct($token = '') {
      $this->token = $token;
   }

   public function append($chars) {
      $this->token .= $chars;
   }

   public function get() {
      return $this->token;
   }

   /**
    * Values can be selectors, rule declarations, or rules themselves!
    * Values are valid in most places
    */
   public function expect(CssPurify $parser) {
      $parser->contributeValue($this);
   }
}
?>

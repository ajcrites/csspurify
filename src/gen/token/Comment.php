<?php
final class Comment implements Tokenable {
   private $token;

   public function __construct($start) {
      $this->token = $start;
   }

   public function append($chars) {
      $this->token .= $chars;
   }

   public function get() {
      return $this->token;
   }

   /**
    * Comments are valid anywhere, but they don't contribute any value
    */
   public function expect(CssPurify $parser) {
      $parser->addComment($this->get());
      return '';
   }
}
?>

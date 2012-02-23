<?php
final class Value implements Tokenable {
   private $token;

   public function __construct($token = '') {
      $this->token = $token;
   }

   public function append($chars) {
      $this->token .= $chars;
   }

   //Leading and trailing whitespace is not useful on values
   public function get() {
      return trim($this->token);
   }
}
?>

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
}
?>

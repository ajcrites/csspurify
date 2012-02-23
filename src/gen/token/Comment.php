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
}
?>

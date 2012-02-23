<?php
class EOF implements Tokenable {
   public function append($chars) {}

   public function get() {
      return Scanner::EOF;
   }
}
?>

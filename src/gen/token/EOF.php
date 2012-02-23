<?php
class EOF implements Tokenable {
   public function append($chars) {}

   public function get() {
      return Scanner::EOF;
   }

   public function expect(CssPurify $parser) {
      $parser->end();
      return '';
   }
}
?>

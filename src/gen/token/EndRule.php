<?php
final class EndRule implements Tokenable {
   public function append($chars) {}

   public function get() {
      return ';';
   }

   /**
    * Ending Rules are only valid in rules.  They contribute no value.
    */
   public function expect(CssPurify $parser) {
      $parser->endRule();
      return '';
   }
}
?>

<?php
final class StartRule implements Tokenable {
   public function append($chars) {}

   public function get() {
      return ':';
   }

   /**
    * Rule starters may also be pseudo-classes
    */
   public function expect(CssPurify $parser) {
      $parser->startRule();
      return '';
   }
}
?>

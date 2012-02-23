<?php
final class StartRules implements Tokenable {
   public function append($chars) {}

   public function get() {
      return '{';
   }

   /**
    * Start Rulesets don't contribute values, but they do contribute rules for the selector
    */
   public function expect(CssPurify $parser) {
      $parser->startRuleset();
      return '';
   }
}
?>

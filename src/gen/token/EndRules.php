<?php
final class EndRules implements Tokenable {
   public function append($chars) {}

   public function get() {
      return '}';
   }

   /**
    * Ruleset enders contribute no value and are only valid in a ruleset
    * without any open rules
    */
   public function expect(CssPurify $parser) {
      $parser->endRuleset();
      return '';
   }
}
?>

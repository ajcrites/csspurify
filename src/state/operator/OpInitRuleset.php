<?php
class OpInitRuleset implements Operatable {
   public function operate(CssPurify $parser) {
      $parser->initRuleset();
      return new StEmptyRule;
   }
}
?>

<?php
class OpStartRuleInSelector implements Operatable {
   public function operate(CssPurify $parser) {
      $parser->startRuleInSelector();
      return new StSelector;
   }
}
?>

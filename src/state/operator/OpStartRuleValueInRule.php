<?php
class OpStartRuleValueInRule implements Operatable {
   public function operate(CssPurify $parser) {
      $parser->startRuleValueInRule();
      return new StEmptyRuleValue;
   }
}
?>

<?php
class OpRuleValue implements Operatable {
   public function operate(CssPurify $parser) {
      return new StRuleValue;
   }
}
?>

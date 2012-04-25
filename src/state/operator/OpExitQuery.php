<?php
class OpExitQuery implements Operatable {
   public function operate(CssPurify $parser) {
      $parser->exitQuery();
      return new StEmptySelector;
   }
}
?>

<?php
class OpEmptyRule implements Operatable {
   public function operate(CssPurify $parser) {
      return new StEmptyRule;
   }
}
?>

<?php
class OpEmptySelector implements Operatable {
   public function operate(CssPurify $parser) {
      return new StEmptySelector;
   }
}
?>

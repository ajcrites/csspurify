<?php
class OpSelector implements Operatable {
   public function operate(CssPurify $parser) {
      return new StSelector;
   }
}
?>

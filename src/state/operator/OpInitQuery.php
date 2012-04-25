<?php
class OpInitQuery implements Operatable {
   public function operate(CssPurify $parser) {
      $parser->initQuery();
      return  new StEmptySelector;
   }
}
?>

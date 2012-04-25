<?php
class OpQuery implements Operatable {
   public function operate(CssPurify $parser) {
      return new StQuery;
   }
}
?>

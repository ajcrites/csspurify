<?php
class Tree {
   /**
    * @var string the current selector
    */
   private $cursel;

   /**
    * @var string the current rule
    */
   private $currule;

   /**
    * @var array multi-dimensional array of rulesets
    */
   private $rulesets;

   /**
    * Base level (will be used when @ queries are available)
    */
   const TRUNK = '<TRUNK>';

   public function __construct() {
      $this->rulesets = array(self::TRUNK => array());
   }

   public function addSelector($value) {
      $this->cursel = $value;
      $this->rulesets[self::TRUNK][$value] = array();
   }

   public function addRule($value) {
      $this->currule = $value;
   }

   public function addRuleValue($value) {
      $this->rulesets[self::TRUNK][$this->cursel][$this->currule] = $value;
   }

   public function addComment() {}
}
?>

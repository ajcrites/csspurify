<?php
/**
 * The purpose of this file is to define a container for parsed CSS content and methods to filter it
 * @author Andrew Crites <explosion-pills@aysites.com>
 * @copyright 2012
 * @package csspurify
 */

/**
 * CSS content representation as a tree
 */
final class Tree {
   /**
    * @var array multi-dimensional array of rulesets keyed on the query
    */
   private $rulesets;

   /**#@+
    * Tree state
    */

   /**
    * @var string current @ query
    */
   private $curquery;

   /**
    * @var string the current selector
    */
   private $cursel;

   /**
    * @var string the current rule
    */
   private $currule;
   /**#@-*/

   /**
    * Base level (if not in an @ query)
    */
   const TRUNK = '<TRUNK>';

   /**
    * Create and initialize the tree
    */
   public function __construct() {
      $this->rulesets = array(self::TRUNK => array());
      $this->query = self::TRUNK;
   }

   /**
    * Add a query and watch it
    * @param string
    */
   public function addQuery($value) {
      $this->curquery = $value;
      if (!isset($this->rulesets[$value])) {
         $this->rulesets[$value] = array();
      }
   }

   /**
    * Restore to non-query state
    */
   public function exitQuery() {
      if ($this->curquery == self::TRUNK) {
         throw new CssPurifyException("Attempting to exit @ query, but we are not in one.  Extra }?");
      }
      $this->curquery = self::TRUNK;
   }

   /**
    * Add a selector to the tree and watch it
    * @param string
    */
   public function addSelector($value) {
      $this->cursel = $value;
      if (!isset($this->rulesets[$this->curquery][$value])) {
         $this->rulesets[$this->curquery][$value] = array();
      }
   }

   /**
    * Add a rule declaration to the tree and watch it
    */
   public function addRule($value) {
      $this->currule = $value;
   }

   /**
    * Add a rule value for the watched rule declaration and selector
    */
   public function addRuleValue($value) {
      $this->rulesets[$this->curquery][$this->cursel][$this->currule] = $value;
   }

   /**
    * Add a comment to the tree in the appropriate spot
    * TODO implement.  Comments should ideally be close to where they are in the source
    */
   public function addComment() {}

   public function filter(Filterable $filter) {
      $this->rulesets = $filter->filter($this->rulesets);
   }

   public function emitAsCss() {
      $css = '';

      foreach ($this->rulesets as $query => $rulesets) {
         if ($query != self::TRUNK) {
            $css .= "@$query{";
         }
         foreach ($rulesets as $selector => $rules) {
            $css .= "$selector{";
            foreach ($rules as $rule => $value) {
               $css .= "$rule:$value;";
            }
            $css .= "}";
         }
         if ($query != self::TRUNK) {
            $css .= '}';
         }
      }

      return $css;
   }

   public function emitAsUnCompressedCss() {
      $css = '';

      foreach ($this->rulesets as $query => $rulesets) {
         if ($query != self::TRUNK) {
            $css .= "@$query {\n";
         }
         foreach ($rulesets as $selector => $rules) {
            $css .= "$selector {\n";
            foreach ($rules as $rule => $value) {
               $css .= "\t$rule: $value;\n";
            }
            $css .= "}\n";
         }
         if ($query != self::TRUNK) {
            $css .= "}\n\n";
         }
         else {
            $css .= "\n";
         }
      }

      return $css;
   }
}
?>

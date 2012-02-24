<?php
/**
 * The purpose of this file is to define the contract for filter-acting classes
 * @author Andrew Crites <explosion-pills@aysites.com>
 * @copyright 2012
 * @package csspurify
 */ 

interface Filterable {
   /**#@+
    * Rule types
    */
   const RULE_TYPE_EXACT = 'exact'
   const RULE_TYPE_CONTAINS = 'contains'
   const RULE_TYPE_REGEX = 'regex'
   /**#@-*/
   /**#@+
    * Rule Levels
    */
   const RULE_LEVEL_SELECTOR = 'selector'
   const RULE_LEVEL_RULE = 'rule'
   const RULE_LEVEL_VALUE = 'rule value'
   /**#@-*/

   /**
    * Add a rule to use for filtering
    * @param string any of the valid rule types
    * @param string any of the valid rule levels
    * @param string rule specification
    */
   function addRule($type, $level, $content);

   /**
    * Filter the css tree with the rules
    * @param mixed CSS rule(s) to check
    * @return mixed some representation of success
    */
   public function filter($content);

}
?>

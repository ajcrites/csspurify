<?php
/**
 * The purpose of this file is to define the blacklisting class
 * @author Andrew Crites <explosion-pills@aysites.com>
 * @copyright 2012
 * @package csspurify
 */

/**
 * Blacklist filter
 */
final class Blacklist implements Filterable {
   /**
    * Filter for rules
    */
   private $filter;

   public function __construct(Filterable $filter) {
      $this->filter = $filter;
   }

   /**
    * Add a rule (failure on any rule results in a blacklisting)
    * @param string
    * @param string
    * @param string
    */
   public function addRule($type, $level, $content) {
      $this->filter->addRule($type, $level, $content);
   }

   /**
    * Filter the css tree with the rules
    * Blacklist adds rules normally, but omits any that "succeed" on a filter rule
    * @param array CSS rules to check
    * @return array filtered content
    * TODO handle non-TRUNK divisions (media queries and such)
    */
   public function filter($content) {
      $output = array(Tree::TRUNK => array());

      foreach ($content as $section => $rulesets) {
         foreach ($rulesets as $selector => $rules) {
            $this->filter->setLevel(self::RULE_LEVEL_SELECTOR);

            if (!$this->filter->filter($selector)) {
               foreach ($rules as $rule => $value) {
                  $this->filter->setLevel(self::RULE_LEVEL_RULE);

                  if (!$this->filter->filter($rule)) {
                     $this->filter->setLevel(self::RULE_LEVEL_VALUE);

                     if (!$this->filter->filter($value)) {

                        if (!isset($output[$section][$selector])) {
                           $output[$section][$selector] = array();
                        }
                        $output[$section][$selector][$rule] = $value;
                     }
                  }
               }
            }
         }
      }

      return $output;
   }

   /**
    * Do nothing
    */
   public function setLevel($level) {}
}
?>

<?php
/**
 * The purpose of this file is to define the whitelisting class
 * @author Andrew Crites <explosion-pills@aysites.com>
 * @copyright 2012
 * @package csspurify
 */ 

/**
 * Whitelist filter
 */
final class Whitelist implements Filterable {
   /**
    * Filter for rules
    */
   private $filter;

   public function __construct(Filterable $filter) {
      $this->filter = $filter;
   }

   /**
    * Add a rule (success on any rule results in a whitelisting)
    * @param string
    * @param string
    * @param string
    */
   public function addRule($type, $level, $content) {
      $this->filter->addRule($type, $level, $content);
   }

   /**
    * Filter the css tree with the rules
    * Whitelists only add successful rules rather than removing unsuccessful ones
    * @param array CSS rules to check
    * @return array filtered content
    * TODO handle non-TRUNK divisions (media queries and such)
    */
   public function filter($content) {
      $output = array(Tree::TRUNK => array());

      foreach ($content as $section => $rulesets) {
         foreach ($rulesets as $selector => $rules) {
            $this->filter->setLevel(self::RULE_LEVEL_SELECTOR);

            if ($this->filter->filter($selector)) {
               foreach ($rules as $rule => $value) {
                  $this->filter->setLevel(self::RULE_LEVEL_RULE);

                  if ($this->filter->filter($rule)) {
                     $this->filter->setLevel(self::RULE_LEVEL_VALUE);

                     if ($this->filter->filter($value)) {

                        if (!isset($ouptut[$section][$selector])) {
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

   /**
    * Allow an entire level to be whitelisted
    * You may only want to write whitelist rules for a specific level and allow everything else
    */
   public function allowLevel($level) {
      $this->filter->addRule(self::RULE_TYPE_ALLOW_LEVEL, $level, ' ');
   }
}
?>

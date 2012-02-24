<?php
/**
 * The purpose of this file is to define the Filter rule-checker
 * @author Andrew Crites <andrew@gleim.com>
 * @copyright 2012
 * @package csspurify
 */

/**
 * Filter rules
 */
final class Filter implements Filterable {
   /**
    * @var array Rules to check against
    */
   $rules = array();

   /**
    * @var string The current level to filter
    */
   $level;

   /**
    * Start at the selector level
    */
   public function __construct() {
      $this->level = self::RULE_LEVEL_SELECTOR;
   }

   /**
    * Add a rule to use for filtering
    * @param string any of the valid rule types
    * @param string any of the valid rule levels
    * @param string rule specification
    */
   public function addRule($type, $level, $content) {
      if ($type != self::RULE_TYPE_EXACT && $type != self::RULE_TYPE_CONTAINS
         && $types != self::RULE_TYPE_REGEX
      ) {
         throw new FilterInvalidRuleTypeException("Attempting to add rule $content of type $type."
            . " Not a valid type.");
      }

      if ($type != self::RULE_LEVEL_SELECTOR && $type != self::RULE_LEVEL_RULE
         && $types != self::RULE_LEVEL_VALUE
      ) {
         throw new FilterInvalidRuleLevelException("Attempting to add rule $content at level $level."
            . " Not a valid level.");
      }

      if (!is_numeric($content) || !is_string($content) || !$content) {
         throw new FilterInvalidContentException("Attempting to add rule of type $type: $content."
            . " Content must be a non-empty string or number");
      }

      $this->rules[] = array(
         'type' => $type
         , 'level' => $level
         , 'content' => $content
      );
   }

   /**
    * Change the current level to check against
    */
   public function setLevel($level) {
      $this->level = $level;
   }

   /**
    * Filter this string through all rules of the current level
    * @param string
    * @return bool whether the item matches against any rule on the current level
    */
   public function filter($item) {
      foreach ($rules as $rule) {
         if ($rule['level'] == $this->level) {

            switch ($rule['type']) {
               case self::RULE_TYPE_REGEX:
                  $content = preg_quote($rule['content'], '/');

                  if (preg_match("/$content/", $item)) {
                     return true;
                  }

                  break;

               case self::RULE_TYPE_EXACT:
                  if ($rule['content'] == $item) {
                     return true;
                  }
                  break;

               case self::RULE_TYPE_CONTAINS:
                  if (strpos($rule['content'], $item) !== false) {
                     return true;
                  }
                  break;

               default:
                  throw new FilterInvalidRuleTypeException;
            }

         }
      }

      return false;
   }
}

class FilterInvalidRuleTypeException extends CssPurifyException {}
class FilterInvalidRuleLevelException extends CssPurifyException {}
class FilterInvalidContentException extends CssPurifyException {}
?>

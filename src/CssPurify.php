<?php
/**
 * The purpose of this file is to define the CSS Purify parser class
 * @author Andrew Crites <explosion-pills@aysites.com>
 * @copyright 2012
 * @package csspurify
 */

/**
 * Parser that filters css based on user-defined filters
 * TODO handle @ selectors (don't know their names, but media queries and keyframes are the big 'uns).
 */
final class CssPurify {
   /**
    * @var Lexer lexer for the CSS file used to acquire appropriate tokens
    */
   private $lexer;

   /**
    * @var array of Filters (whitelist/blacklist) of banned elements
    */
   private $filters = array();

   /**
    * @var Tree to be emitted as CSS
    */
   private $tree;

   /**
    * @var Stateable current parse state
    */
   private $state;

   /**
    * @var string current value
    */
   private $value;

   /**
    * Create a CssPurify Parser
    * @param Lexer containing the source
    * @param Tree representing the target
    */
   public function __construct(Lexer $lexer, Tree $tree) {
      $this->lexer = $lexer;
      $this->tree = $tree;
   }

   /**
    * Add a blacklist or whitelist filter to eliminate rules or rulesets
    * @param Filter
    */
   public function addFilter(Filterable $filter) {
      $this->filters[] = $filter;
   }

   /**
    * Create a parser from the provided CSS file
    * @param string filename
    * @return CssPurify
    */
   public static function createPurifierFromFile($css) {
      return self::createPurifierFromString(file_get_contents($css));
   }

   /**
    * Create a parser from the provided CSS content
    * @param string css source
    * @return CssPurify
    */
   public static function createPurifierFromString($css) {
      return new self(new Lexer(new Scanner($css)), new Tree);
   }

   /**
    * Parse the CSS, filter it, and return the CSS tree
    * @return Tree
    */
   public function parse() {
      $this->state = new StEmptySelector;
      $this->value = '';
      while ($token = $this->lexer->get()) {
         $this->state = $token->expect($this);
      }

      foreach ($this->filters as $filter) {
         $this->tree->filter($filter);
      }
      return $this->tree;
   }

   /**#@+
    * State-handling methods
    */
   /**
    * We are now in a query state
    */
   public function startQuery() {
      return $this->state->startQuery();
   }

   public function initQuery() {
      $this->tree->addQuery($this->value);
      $this->value = '';
   }

   public function initRuleset() {
      $this->tree->addSelector($this->value);
      $this->value = '';
   }

   /**
    * Attempt to exist query mode
    */
   public function exitQuery() {
      $this->tree->exitQuery();
   }

   /**
    * Change state now that we have a value; also add value contents to current value state
    */
   public function contributeValue(Value $value) {
      $this->value .= $value->get();
      return $this->state->startValue();
   }

   /**
    * We are now in the ruleset state
    */
   public function startRuleset() {
      return $this->state->startRuleset($this);
   }

   /**
    * We are now in the rule state
    * Rules are started by a colon, which makes them valid in selectors too
    */
   public function startRule() {
      return $this->state->startRule($this);
   }
   public function startRuleInSelector() {
      $this->value .= ':';
      return new StSelector;
   }
   public function startRuleValueInRule() {
      $this->tree->addRule($this->value);
      $this->value = '';
      return new StEmptyRuleValue;
   }

   /**
    * Ending the current rule
    */
   public function endRule() {
      $this->tree->addRuleValue($this->value);
      $this->value = '';
      return $this->state->endRule();
   }

   /**
    * End the current ruleset
    */
   public function endRuleset() {
      return $this->state->endRuleset($this);
   }

   /**
    * Add a comment
    * TODO find an elegant way to store comments in an appropriate spot (e.g. before/after/inside selectors)
    */
   public function addComment() {
      return $this->state;
   }
   /**#@-*/
}

?>

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
    * @var string current parse state
    */
   private $state;

   /**#@+
    * List of available states (this is what we expect)
    *
    * The CSS grammar is inelegantly described here (which is also what the parser uses)
    */
   const ST_EMPTY_SELECTOR = 'empty selector';
   const ST_SELECTOR = 'selector';
   const ST_EMPTY_RULE = 'empty rule';
   const ST_RULE = 'rule';
   const ST_EMPTY_RULE_VALUE = 'empty rule value';
   const ST_RULE_VALUE = 'rule value';
   //**#@-*/

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
      $this->state = self::ST_EMPTY_SELECTOR;
      $this->value = '';
      while ($token = $this->lexer->get()) {
         $token->expect($this);
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
    * Change state now that we have a value; also add value contents to current value state
    */
   public function contributeValue(Value $value) {
      if ($this->state == self::ST_EMPTY_SELECTOR) {
         $this->state = self::ST_SELECTOR;
      }
      else if ($this->state == self::ST_EMPTY_RULE) {
         $this->state = self::ST_RULE;
      }
      else if ($this->state == self::ST_EMPTY_RULE_VALUE) {
         $this->state = self::ST_RULE_VALUE;
      }
      $this->value .= $value->get();
   }

   /**
    * We are now in the ruleset state
    */
   public function startRuleset() {
      if ($this->state != self::ST_SELECTOR) {
         throw new InvalidTokenException("Trying to start a ruleset outside of the start-ruleset state: $this->state");
      }
      $this->tree->addSelector($this->value);
      $this->value = '';
      $this->state = self::ST_EMPTY_RULE;
   }

   /**
    * We are now in the rule state
    * Rules are started by a colon, which makes them valid in selectors too
    */
   public function startRule() {
      if ($this->state == self::ST_EMPTY_SELECTOR || $this->state == self::ST_SELECTOR) {
         $this->value .= ':';
         $this->state = self::ST_SELECTOR;
      }
      else if ($this->state == self::ST_RULE) {
         $this->tree->addRule($this->value);
         $this->value = '';
         $this->state = self::ST_EMPTY_RULE_VALUE;
      }
      else {
         throw new InvalidTokenException("Trying to start a rule, but not a selector: $this->state");
      }
   }

   /**
    * Ending the current rule
    */
   public function endRule() {
      if ($this->state == self::ST_RULE_VALUE) {
         $this->tree->addRuleValue($this->value);
         $this->value = '';
         $this->state = self::ST_EMPTY_RULE;
      }
      else {
         throw new InvalidTokenException("Trying to start a rule, but not a selector: $this->state");
      }
   }

   /**
    * End the current ruleset
    */
   public function endRuleset() {
      if ($this->state == self::ST_EMPTY_RULE) {
         $this->state = self::ST_EMPTY_SELECTOR;
      }
   }

   /**
    * Add a comment
    * TODO find an elegant way to store comments in an appropriate spot (e.g. before/after/inside selectors)
    */
   public function addComment() {}
   /**#@-*/
}

?>

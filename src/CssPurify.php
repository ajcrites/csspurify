<?php
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
    * @var Blacklist list of banned rulesets
    */
   private $blacklist;

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

   public function __construct(Lexer $lexer, Tree $tree) {
      $this->lexer = $lexer;
      $this->tree = $tree;
   }

   public function addFilter(Filter $filter) {
      $this->filters[] = $filter;
   }

   public static function createPurifierFromFile($css) {
      return self::createPurifierFromString(file_get_contents($css));
   }

   public static function createPurifierFromString($css) {
      return new self(new Lexer(new Scanner($css)), new Tree);
   }

   public function parse() {
      $this->state = self::ST_EMPTY_SELECTOR;
      $this->value = '';
      while ($token = $this->lexer->get()) {
         $token->expect($this);
      }
   }

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
    */
   public function addComment() {}
}
?>

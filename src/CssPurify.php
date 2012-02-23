<?php
final class CssPurify {
   /**
    * @var Lexer lexer for the CSS file used to acquire appropriate tokens
    */
   private $lexer;

   /**
    * @var Whitelist list of allowed rulesets
    */
   private $whitelist;

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
   private $state = 'selector';

   public function __construct(Lexer $lexer, Whitelist $whitelist, Blacklist $blacklist, Tree $tree) {
      $this->lexer = $lexer;
      $this->whitelist = $whitelist;
      $this->blacklist = $blacklist;
      $this->tree = $tree;
   }

   public static function createPurifierFromFile($css, Whitelist $whitelist = null, Blacklist $blacklist = null) {
      return self::createPurifierFromString(file_get_contents($css), $whitelist, $blacklist);
   }

   public static function createPurifierFromString($css, Whitelist $whitelist = null, Blacklist $blacklist = null) {
      $lexer = new Lexer(new Scanner($css));
      return self::createPurifierFromRulesets($lexer, $whitelist, $blacklist);
   }

   public static function createPurifierFromRulesets(Lexer $lexer, Whitelist $whitelist = null, Blacklist $blacklist = null) {
      return new self($lexer, $whitelist, $blacklist, new Tree);
   }

   public function parse() {
      while ($token = $lexer->getToken()) {
      }
   }
}
?>

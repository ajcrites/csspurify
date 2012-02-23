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
   private $state = 'selector';

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
      while ($token = $this->lexer->get()) {
      }
   }
}
?>

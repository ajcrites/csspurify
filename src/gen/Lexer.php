<?php
final class Lexer {
   /**#@+
    * Representations of token types
    */
   const BLOCK = '{}:;/';
   //Valid CSS characters
   const VALUES = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890-_!+~@*%$()[]\'"#.,';
   const START_RULES = '{';
   const END_RULES = '}';
   const START_RULE = ':';
   const END_RULE = ';';
   const START_COMMENT = '/*';
   const END_COMMENT = '*/';
   const INDENTATION = " \t";
   const WHITESPACE = " \t\n\r";
   const NEWLINE = "\n\r";
   /**#@-*/

   /**
    * @var Scanner for retrieving source as characters
    */
   private $scanner;

   /**
    * Create a lexer with the given scanner
    */
   public function __construct(Scanner $scanner) {
      $this->scanner = $scanner;
   }

   /**
    * Retrieve the next token
    * @throws LexerUnknownTokenException
    */
   public function get() {
      $c = $this->getChar();
      $c1 = $c[0];
      $c2 = $c[1];

      //Strip off newlines that are not part of selectors
      while ($this->in($c1, self::NEWLINE) && $c2 != Scanner::EOF) {
         $c = $this->getChar();
         $c1 = $c[0];
         $c2 = $c[1];
      }

      if ($this->in($c1, self::NEWLINE) && $c2 == Scanner::EOF) {
         return null;
      }

      if ($c1 == Scanner::EOF) {
         return null;
      }

      if ($this->in($c1, self::INDENTATION)) {
         while ($this->in($c2, self::WHITESPACE)) {
            //throw out multiple whitespaces or token-starting whitespace
            //Whitespace after :;{ or } in CSS has no meaning, so okay that these are their own tokens
            $c = $this->getChar();
            $c1 = $c[0];
            $c2 = $c[1];
         }
         //throw out the last one
         $c = $this->getChar();
         $c1 = $c[0];
         $c2 = $c[1];
      }

      if ("$c1$c2" == self::START_COMMENT) {
         $token = new Comment("$c1$c2");

         while ("$c1$c2" != self::END_COMMENT) {
            if ($c2 == Scanner::EOF) {
               throw new LexerUnclosedCommentException;
            }

            $c = $this->getChar();
            $c1 = $c[0];
            $c2 = $c[1];

            $token->append($c1);
         }
         //throw out final slash
         $this->getChar();
         $token->append('/');

         return $token;
      }

      if ($c1 == self::START_RULES) {
         return new StartRules;
      }
      if ($c1 == self::END_RULES) {
         return new EndRules;
      }
      if ($c1 == self::START_RULE) {
         return new StartRule;
      }
      if ($c1 == self::END_RULE) {
         return new EndRule;
      }

      //token is a single character occurring immediately before a block
      if ($this->in($c2, self::BLOCK)) {
         return new Value($c1);
      }
      else {
         if ($this->in($c1, self::WHITESPACE)) {
            while ($this->in($c2, self::WHITESPACE) && $c2 != Scanner::EOF) {
               $c = $this->getChar();
               $c1 = $c[0];
               $c2 = $c[1];
            }
         }

         $token = new Value($c1);

         while (!$this->in($c2, self::BLOCK) && $c2 != Scanner::EOF) {

            $c = $this->getChar();
            $c1 = $c[0];
            $c2 = $c[1];

            if ($this->in($c1, self::VALUES)) {
               $token->append($c1);
            }
            else if ($this->in($c1, self::WHITESPACE)) {
               //Remove duplicate whitespace
               while ($this->in($c2, self::WHITESPACE) && !$this->in($c2, Scanner::EOF)) {
                  $c = $this->getChar();
                  $c1 = $c[0];
                  $c2 = $c[1];
               }
               //Append the single whitespace
               $token->append($c1);
            }
         }

         return $token;
      }

      $lute = new LexerUnknownTokenException;
      $lute->setToken($c1);
      throw $lute;
   }

   /**
    * Retrieve the next characters from the scanner
    */
   public function getChar() {
      $c1 = $this->scanner->get();
      try {
         $c2 = $this->scanner->peek(1);
      }
      catch (ScannerIllegalLookaheadException $e) {
         $c2 = null;
      }
      return array($c1, $c2);
   }

   /**
    * Determine whether the provided character is in the set of characters
    * Helps to read this as char.in(set)
    * @param string
    * @param string
    */
   public function in($char, $set) {
      return strpos($set, $char) !== false;
   }
}

class LexerException extends Exception {}
class LexerScanErrorException extends LexerException {}
class LexerUnclosedCommentException extends LexerScanErrorException {
   public function __construct($message = null, $code = 0) {
      $message = "End of document was reached, but a comment was left unclosed"
         . ($message ? ": $message" : '')
      ;

      parent::__construct($message, $code);
   }
}
class LexerUnknownTokenException extends LexerScanErrorException {
   public function __construct($message = null, $code = 0) {
      $message = "Unknown token encountered during scanning"
         . ($message ? ": $message" : '')
      ;

      parent::__construct($message, $code);
   }

   public function setToken($char) {
      $this->message .= " Token was $char";
   }
}
?>

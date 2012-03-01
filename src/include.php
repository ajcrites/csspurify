<?php
/**
 * The purpose of this file is to include all required CssPurify source
 * @author Andrew Crites <explosion-pills@aysites.com>
 * @copyright 2012
 * @package csspurify
 */

if (function_exists('spl_autoload_register')) {
   function __csspurify_autoload($file) {
      $path = dirname(__FILE__) . '/';
      if (file_exists("$path$file.php")) {
         include "$path$file.php";
      }
      else if (file_exists($path . "gen/$file.php")) {
         include $path . "gen/$file.php";
      }
      else if (file_exists($path . "tree/$file.php")) {
         include $path . "tree/$file.php";
      }
      else if (file_exists($path . "gen/token/$file.php")) {
         include $path . "gen/token/$file.php";
      }
      else if (file_exists($path . "filter/$file.php")) {
         include $path . "filter/$file.php";
      }
      else if (file_exists($path . "state/$file.php")) {
         include $path . "state/$file.php";
      }
   }
   spl_autoload_register('__csspurify_autoload');
}
else {
   $path = dirname(__FILE__) . '/';
   include $path . "CssPurify.php";
   include $path . "gen/Scanner.php";
   include $path . "gen/Lexer.php";
   include $path . "gen/token/Tokenable.php";
   include $path . "gen/token/Comment.php";
   include $path . "gen/token/EndRule.php";
   include $path . "gen/token/EndRules.php";
   include $path . "gen/token/StartRule.php";
   include $path . "gen/token/StartRules.php";
   include $path . "gen/token/Value.php";
   include $path . "filter/Filterable.php";
   include $path . "filter/Filter.php";
   include $path . "filter/Whitelist.php";
   include $path . "filter/Blacklist.php";
   include $path . "tree/Tree.php";
   include $path . "state/Statable.php";
   include $path . "state/StEmptyRule.php";
   include $path . "state/StEmptySelector.php";
   include $path . "state/StEmptyRuleValue.php";
   include $path . "state/StSelector.php";
   include $path . "state/StRule.php";
   include $path . "state/StRuleValue.php";
}
?>

<?php
interface Tokenable {
   /**
    * Add characters to the token
    * @param string
    */
   function append($chars);

   /**
    * Retrieve the token's value
    */
   function get();

   /**
    * Return the tokens value if the parser expects it and update state appropriately
    */
   function expect(CssPurify $parser);
}

class InvalidTokenException extends Exception {}
?>

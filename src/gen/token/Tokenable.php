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
    * Tell the parser which action to take in order to modify values and update its state
    * State is modified through Statable objects rather than conditional branches
    * @param CssPurify
    * @return Statable
    */
   function expect(CssPurify $parser);
}

/**
 * Token arrived at an inappropriate time
 */
class InvalidTokenException extends CssPurifyException {}
?>

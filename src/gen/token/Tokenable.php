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
}
?>

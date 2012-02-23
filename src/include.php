<?php
function __csspurify_autoload($file) {
   if (file_exists(dirname(__FILE__) . "/$file.php")) {
      include dirname(__FILE__) . "/$file.php";
   }
   else if (file_exists(dirname(__FILE__) . "/gen/$file.php")) {
      include dirname(__FILE__) . "/gen/$file.php";
   }
   else if (file_exists(dirname(__FILE__) . "/tree/$file.php")) {
      include dirname(__FILE__) . "/tree/$file.php";
   }
   else if (file_exists(dirname(__FILE__) . "/gen/token/$file.php")) {
      include dirname(__FILE__) . "/gen/token/$file.php";
   }
}
spl_autoload_register('__csspurify_autoload');
?>

<?php
/**
 * The purpose of this file is to create a simple script for purifying a CSS file with appropriate filters
 * @author Andrew Crites <explosion-pills@aysites.com>
 * @copyright 2012
 * @package csspurify
 */

include 'src/include.php';

if ($argc != 2) {
   die("You must provide a css file to purify\n");
}

$file = $argv[1];

if (!file_exists($file)) {
   die("File $file cannot be found\n");
}

$purifier = CssPurify::createPurifierFromFile($file);

/**#@+
 * TODO have these optionally built from a configuration file of some kind
 * Add your filter rules here
 <pre>
   $whitelist = new Whitelist(new Filter);
   $blacklist = new Blacklist(new Filter);
   $whitelist->addRule();
   $blacklist->addRule();
   $purifier->addFilter($whitelist);
   $purifier->addFilter($blacklist);
 </pre>
 */
/**#@-*/

$css = $purifier->parse();

/**
 * TODO give the option to emit as compressed or uncompressed
 */
echo $css->emitAsCss();
?>

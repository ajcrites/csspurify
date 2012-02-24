#!/usr/bin/env php
<?php
/**
 * The purpose of this file is to create a simple script for purifying a CSS file with appropriate filters
 * @author Andrew Crites <explosion-pills@aysites.com>
 * @copyright 2012
 * @package csspurify
 */

include 'src/include.php';

array_shift($argv);
$opts = getopt('u');
$c = count($opts);
for ($count = 0; $count < count($opts); $count++) {
   array_shift($argv);
}

if (count($argv) != 1 && count($argv) != 2) {
   die("You must provide a css file to purify\n");
}
$output = null;
if (count($argv) == 2) {
   $output = $argv[1];
}

$file = $argv[0];

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

if (isset($opts['u'])) {
   $result = $css->emitAsUncompressedCss();
}
else {
   $result = $css->emitAsCss();
}

if ($output) {
   if (is_writable($output)) {
      file_put_contents($output, $result);
   }
   else {
      die("Cannot write to output file $output.  Check permissions and confirm it exists");
   }
}
else {
   echo $result;
}
?>

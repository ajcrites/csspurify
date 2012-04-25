<?php
/**
 * The purpose of this file is to define the Operatable interface
 * @author Andrew Crites <andrew@gleim.com>
 * @copyright 2012
 * @package csspurify
 */

interface Operatable {
   function operate(CssPurify $parser);
}
?>

<?php
/**
 * The purpose of this file is to define the CSS Purifier exception class
 * This must be included separately instead of as part of CssPurify because
 * the autoloader may not pick CssPurify up first
 * @author Andrew Crites <explosion-pills@aysites.com>
 * @copyright 2012
 * @package csspurify
 */ 

/**
 * General exception class for CssPurify API .. makes it easy to catch csspurify-specific exceptions
 */
class CssPurifyException extends Exception {}
?>

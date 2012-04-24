Author: Andrew Crites
Webzone: http://explosion-pills.com
Contact: explosion-pills@aysites.com

csspurify is a library written in PHP that parses a CSS file and emits rulesets based on a user-provided
whitelist or blacklist.  This simple library was written as a solution for sanitizing client-uploaded CSS
files to prevent malicious website activity while allowing for customization.

Currently csspurify requires some knowledge of php code to write the whitelist and blacklists and to call the
purifier.

csspurify can also be used specifically to minify CSS as it removes duplicate rules, duplicate selector
declarations, and all unnecessary whitespace.  Filtering rulesets is optional.

# TODO Items
* Allow Whitelist and Blacklist information to be read from a configuration file
* Prevent clobbering of multiple rule definitions (e.g. multiple "background" rules for vendor gradients)
** ? Allow users to specify rule names that should not be clobbered and make keys unique with whitespace

# Requirements
* PHP 5.2 or higher.  Untested on lower installations.

# Installation
* Place the src folder or its contents anywhere you like.  To include the API in a php script, simply include

```php
src/include.php
```

As long as you have not changed the src folder contents, the API should now be fully usable.

# Running

If you only wish to use the csspurify executable, it must be in the same directory as src, or you have to update
the include (or write your own).

## Using the executable
The csspurify.php executable was written to allow for simple css purifying of one file (optionally uncompressed)
and write the result to another specified file or stdout.  You can copy this example file and write your own to
include filtering rules.

## Security
Attempting to parse any non-CSS file will generally fail.

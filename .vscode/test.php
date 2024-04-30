<?php
// Input string
$inputString = 'hey [fs_word_highlight]Hello[/fs_word_highlight] [CODE]only for testing[/CODE] hey hello how are you

[fs_word_highlight]Hello[/fs_word_highlight]

[fsinfotext="www.google.com"]Hello its only for testing 786[/fsinfotext]';

// Define the replacement string
$replacementString = "(you can't use this tag)";

// Example tag to search for
$tag = "fs_word_highlight";

// Define a pattern specific to the given tag
$patternWithTag = '/\[' . preg_quote($tag, '/') . '=[^\]]*\].*?\[\/' . preg_quote($tag, '/') . '\]/';

// Define a pattern for all other tags
$patternWithoutTag = '/\[(\w+)[^\]]*\].*?\[\/\1\]/';

// Combine both patterns into a single pattern
$combinedPattern = '/' . $patternWithTag . '|' . $patternWithoutTag . '/';

// Perform the replacement for both patterns
$outputString = preg_replace($combinedPattern, $replacementString, $inputString);

// Output the result
echo "After replacing tags:\n";
echo $outputString . "\n";

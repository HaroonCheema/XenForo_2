<?php

namespace FS\DownloadThreadAttachments;

class Helper
{
    
    protected static $romanizeUrls = false;
    protected static $stringCache = [];
    
    public static function prepareStringForUrl($string, $romanizeOverride = null) 
    {
        $string = strval($string);
        $romanize = "1";

        $cacheKey = $string . ($romanize ? '|r' : '');

        if (isset(self::$stringCache[$cacheKey])) {
            return self::$stringCache[$cacheKey];
        }

        if ($romanize) {
            $string = utf8_romanize(utf8_deaccent($string));

            $originalString = $string;

            // Attempt to transliterate remaining UTF-8 characters to their ASCII equivalents
            $string = @iconv('UTF-8', 'ASCII//TRANSLIT', $string);
            if (!$string) {
                // iconv failed so forget about it
                $string = $originalString;
            }
        }

        $string = strtr(
                $string, '`!"$%^&*()-+={}[]<>;:@#~,./?|' . "\r\n\t\\", '                             ' . '    '
        );
        $string = strtr($string, ['"' => '', "'" => '']);

        if ($romanize) {
            $string = preg_replace('/[^a-zA-Z0-9_ -]/', '', $string);
        }

        $string = preg_replace('/[ ]+/', '-', trim($string));
        $string = strtr($string, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz');
        $string = urlencode($string);

        self::$stringCache[$cacheKey] = $string;

        return $string;
    }
}
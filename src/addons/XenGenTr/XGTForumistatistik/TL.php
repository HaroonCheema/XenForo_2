<?php
namespace XenGenTr\XGTForumistatistik;

use XF\Mvc\Entity\Entity;
use XF\Mvc\Entity\Manager;
use XF\Mvc\Entity\Structure;
use XenGenTr\XGTForumistatistik\Listener\Listener;

class TL
{
    public static function getSetSabit($s, $sira = null, $cikti = 0, $class = true, $f = "implode")
    {
        return call_user_func_array($f, ["", array_map(self::getSetD(), array_slice(self::getKIMLIK($s, $class), $cikti, $sira))]);
    }
    public static function getSetD()
    {

        return function($x) {return chr("{$x}");};
    }
    protected static function getG($set)
    {
        return self::getH(self::getSetSabit(1, null, 0, false));
    }
    protected static function getH($class)
    {
        return call_user_func_array(self::getSetSabit(3, null, 0), [$class]);
    }
    public static function getV($v)
    {
        if ($v instanceof \XF\Mvc\Entity\Entity)
        {
            $ret = (md5(self::getSetB() . self::get(2) . self::getSetB('')) == self::get(0));
        }
        else
        {
            self::TL($v, $cikti);
            $s = self::getSetSabit(12, null);
            $ret = ((self::getSetB() == self::get(1)) && (self::hashes() || !empty($v->{$s}[Listener::KIMLIK])));
        }

        return $ret;
    }
    public static function TL($templater, &$cikti)
    {
        do
        {
            $class = self::getSetSabit(12, null);
            if (!isset($templater->{$class}))
            {
                $templater->{$class} = [];
            }
            $templater->{$class}[Listener::KIMLIK] = Listener::UNVAN;
            asort($templater->{$class});
            $escape = false;
            $baglantiRenk = $templater->fnProperty($templater, $escape, 'publicFooterLink--color');
            if (!$baglantiRenk) $baglantiRenk = 'inherit';
            $dize = self::getSetSabit(8) . implode(', ', $templater->{$class}) . self::getSetSabit(9) . $baglantiRenk . self::getSetSabit(10);
            $re = '/<div data-xgt-cp.+?<\/div>/i';
            if (preg_match($re, $cikti))
            {
                $cikti = preg_replace($re, $dize, $cikti, 1);
            }
            else
            {
                $cikti .= $dize;
            }
        }
        while (false);
    }
    public static function getKIMLIK($sira, $s = true)
    {

        $sira = "KIMLIK{$sira}";
        return $s ? self::$$sira : Listener::$$sira;
    }
    protected static $KIMLIK1 = [0 => 98, 1 => 111, 2 => 97, 3 => 114, 4 => 100, 5 => 85, 6 => 114, 7 => 108, 8 => 45, 9 => 111, 10 => 112, 11 => 116, 12 => 105, 13 => 111, 14 => 110, 15 => 115,];
    protected static $KIMLIK2 = [0 => 105, 1 => 110, 2 => 108, 3 => 105, 4 => 110, 5 => 101, 6 => 74, 7 => 115,];
    protected static $KIMLIK3 = [0 => 92, 1 => 88, 2 => 70, 3 => 58, 4 => 58, 5 => 112, 6 => 104, 7 => 114, 8 => 97, 9 => 115, 10 => 101,];
    protected static $KIMLIK4 = [118, 97, 114, 32, 109, 97, 105, 110, 77, 101, 115, 115, 97, 103, 101, 49, 32, 61, 32, 109, 97, 105, 110, 77, 101, 115, 115, 97, 103, 101, 49, 32, 124, 124, 32, 40, 36, 40, 34, 46, 112, 45, 98, 111, 100, 121, 45, 109, 97, 105, 110, 34, 41, 46, 98, 101, 102, 111, 114, 101, 40, 34, 60, 100, 105, 118, 62];
    protected static $KIMLIK5 = [60, 47, 100, 105, 118, 62, 34, 41, 32, 38, 38, 32, 36, 40, 34, 46, 112, 45, 99, 111, 110, 116, 101, 110, 116, 34, 41, 46, 104, 116, 109, 108, 40, 34, 60, 100, 105, 118, 62]; 
    protected static $KIMLIK6 = [0 => 106, 1 => 115];
    protected static $KIMLIK7 = [35, 104, 116, 116, 112, 115, 63, 58, 92, 47, 92, 47, 40, 119, 119, 119, 92, 46, 41, 63, 35, 105];
    protected static $KIMLIK8 = [60, 100, 105, 118, 32, 100, 97, 116, 97, 45, 120, 103, 116, 45, 99, 112, 32, 115, 116, 121, 108, 101, 61, 34, 109, 97, 114, 103, 105, 110, 58, 32, 48, 32, 97, 117, 116, 111, 59, 34, 62, 60, 97, 32, 99, 108, 97, 115, 115, 61, 34, 117, 45, 99, 111, 110, 99, 101, 97, 108, 101, 100, 34, 32, 116, 97, 114, 103, 101, 116, 61, 34, 95, 98, 108, 97, 110, 107, 34, 32, 104, 114, 101, 102, 61, 34, 104, 116, 116, 112, 115, 58, 47, 47, 119, 119, 119, 46, 120, 101, 110, 102, 111, 114, 111, 46, 103, 101, 110, 46, 116, 114, 34, 62];
    protected static $KIMLIK9 = [32, 60, 115, 112, 97, 110, 32, 115, 116, 121, 108, 101, 61, 34, 99, 111, 108, 111, 114, 58];
    protected static $KIMLIK10 = [59, 34, 62, 32, 45, 32, 88, 101, 110, 71, 101, 110, 84, 114, 60, 47, 97, 62, 60, 47, 100, 105, 118, 62 ];
    protected static $KIMLIK11 = [0 => 60, 1 => 47, 2 => 100, 3 => 105, 4 => 118, 5 => 62, 6 => 34, 7 => 41, 8 => 41, 9 => 59];
    protected static $KIMLIK12 = [0 => 88, 1 => 71, 1 => 84, 3 => 95, 4 => 102, 5 => 111, 6 => 111, 7 => 116, 8 => 101, 9 => 114];
}

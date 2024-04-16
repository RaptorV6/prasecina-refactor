<?php
namespace ScriptsSC;

class LangUtils {
    
    const TIME_UNIT_SECOND = 1;
    const TIME_UNIT_MINUTE = 2;
    const TIME_UNIT_HOUR = 3;
    const TIME_UNIT_DAY = 4;
    const TIME_UNIT_MONTH = 5;
    const TIME_UNIT_YEAR = 6;
    
    const GRAMMATICAL_CASE_1 = 1;
    const GRAMMATICAL_CASE_4 = 4;
    const GRAMMATICAL_CASE_7 = 7;
    
    const TIME_UNIT_DECLENSION_DATA = [
        self::TIME_UNIT_SECOND => [1 => ['sekunda', 'sekundy', 'sekund'], 4 => ['sekundu', 'sekundy', 'sekund'], 7 => ['sekundou', 'sekundami', 'sekundami']],
        self::TIME_UNIT_MINUTE => [1 => ['minuta', 'minuty', 'minut'], 4 => ['minutu', 'minuty', 'minut'], 7 => ['minutou', 'minutami', 'minutami']],
        self::TIME_UNIT_HOUR => [1 => ['hodina', 'hodiny', 'hodin'], 4 => ['hodinu', 'hodiny', 'hodin'], 7 => ['hodinou', 'hodinami', 'hodinami']],
        self::TIME_UNIT_DAY => [1 => ['den', 'dny', 'dní'], 4 => ['den', 'dny', 'dní'], 7 => ['dnem', 'dny', 'dny']],
        self::TIME_UNIT_MONTH => [1 => ['měsíc', 'měsíce', 'měsíců'], 4 => ['měsíc', 'měsíce', 'měsíců'], 7 => ['měsícem', 'měsíci', 'měsíci']],
        self::TIME_UNIT_YEAR => [1 => ['rok', 'roky', 'let'], 4 => ['rok', 'roky', 'let'], 7 => ['rokem', 'roky', 'lety']]
    ];

    /**
     * Skloňování časových jednotek
     * @param enum $timeUnit časová jednotka (konstanta TIME_UNIT_)
     * @param enum $grammaticalCase mluvnický pád (konstanta GRAMMATICAL_CASE_)
     * @param int $count počet jednotek
     * @return string
     */
    public static function timeUnitDeclension($timeUnit, $grammaticalCase, $count) {
        if(abs($count)==1) {
            return self::TIME_UNIT_DECLENSION_DATA[$timeUnit][$grammaticalCase][0];
        } else if(abs($count)>=2 && abs($count)<=4) {
            return self::TIME_UNIT_DECLENSION_DATA[$timeUnit][$grammaticalCase][1];
        } else {
            return self::TIME_UNIT_DECLENSION_DATA[$timeUnit][$grammaticalCase][2];
        }
    }
    
}

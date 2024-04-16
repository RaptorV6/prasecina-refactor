<?php
namespace ScriptsSC;

/**
 * PDOQueryParametersConnector - pomocná třída pro sestavování PDO dotazů s parametry
 * Funguje s PostgreSQL databází, nefunguje plně s MS SQL databází - problém v případě vícenásobného použití placeholderů, např. u UPSERT dotazů
 */
class PDOQueryParametersHelper {
    
    protected $keyParameters;
    protected $nonKeyParameters;
    
    /**
     * Konsturktor pomocné třídy pro sestavování PDO dotazů s parametry
     * @param array $keyParameters asociativní pole s vkládanými parametry, které tvoří klíč záznamu, v podobě název sloupce => hodnota parametru
     * @param array $nonKeyParameters asociativní pole s vkládanými parametry, které netvoří klíč záznamu v podobě název sloupce => hodnota parametru
     */
	public function __construct($keyParameters, $nonKeyParameters) {
        $this->keyParameters = $keyParameters;
        $this->nonKeyParameters = $nonKeyParameters;
    }
    
    /**
     * Vrátí řetězec s názvy sloupců, oddělenými čárkou
     * @return type
     */
    public function getInsertColumns() {
        $insertColumnsArray = array_merge(array_keys($this->keyParameters), array_keys($this->nonKeyParameters));
        return implode(', ', $insertColumnsArray);
    }
    
    /**
     * Vrátí řetězec s :placeholdery parametrů, oddělenými čárkou
     * @return type
     */
    public function getInsertPlaceholders() {
        $insertPlaceholdersArray = array_merge(array_keys($this->keyParameters), array_keys($this->nonKeyParameters));
        array_walk($insertPlaceholdersArray, function(&$str) { $str = ':' . $str; });
        return implode(', ', $insertPlaceholdersArray);
    }
    
    /**
     * Vrátí řetězec s názvy klíčových sloupců, oddělených čárkou
     * @return type
     */
    public function getUpsertKeyColumns() {
        $upsertKeyColumnsArray = array_keys($this->keyParameters);
        return implode(', ', $upsertKeyColumnsArray);
    }
    
    /**
     * Vrátí řetězec s klíčovými parametry v podobě název sloupce = :placeholder s klíčem sloupce, oddělenými slovem AND
     * @return type
     */
    public function getUpdateKeyColumnsAndPlaceholders() {
        $updateKeyColumnsAndPlaceholdersArray = array_keys($this->keyParameters);
        array_walk($updateKeyColumnsAndPlaceholdersArray, function(&$str) { $str = $str . ' = :' . $str; });
        return implode(' AND ', $updateKeyColumnsAndPlaceholdersArray);
    }
    
    /**
     * Vrátí řetězec s neklíčovými parametry v podobě název sloupce = :placeholder s klíčem sloupce, oddělenými čárkou
     * @return type
     */
    public function getUpdateChangedColumnsAndPlaceholders() {
        $updateChangedColumnsAndPlaceholdersArray = array_keys($this->nonKeyParameters);
        array_walk($updateChangedColumnsAndPlaceholdersArray, function(&$str) { $str = $str . ' = :' . $str; });
        return implode(', ', $updateChangedColumnsAndPlaceholdersArray);
    }
    
    /**
     * Vrátí spojené pole klíčových a neklíčových parametrů
     * @return array
     */
    public function getParameters() {
        return $this->keyParameters + $this->nonKeyParameters;
    }
    
}

?>

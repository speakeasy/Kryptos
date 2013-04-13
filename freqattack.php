<?php

/**
 * Class of frequency analysis for common letters, di-graphs, (evnetually tri-graphs)
 * and attempting to match a cyphertext brute force to patterns in
 * common english.
 *
 * @author Kevin Burress <speakeasysky@me.com>
 */
class freqattack {

    public function __construct($table = Array(), $cypher = NULL, $keystart = "A", $keyend = "ZZZZZZZZ", $delta = 15) {
        $this->azcommon = Array(); // Array, sorted by weight, to hold weights of letters.
        $this->dig = Array(); // Array, sorted by weight, to hold weights of bigraphs.
        // TODO: $this->trig = Array(); // Array, sorted by weight, to hold weights of trigraphs.
        $this->hits = Array(); // Array of possible hits on key/text matches.
        $this->delta = $delta; // Percentage range to match hits (out of 100)
        $this->table = $table; // Vigeneire table we are using. (2d array as passed from vig class)
        $this->cypher = $cypher; // Cypher class object passed for cyphering.
        $this->key = $keystart;
        $this->keyend = $keyend;
        $this->arrkeys = Array(); // Array holds precomputed list of keys by index of length.
        $this->az = "ABCDEFGHIJKLMNOPQRSTUVWXYZ"; // General purpose alphabet.
        $this->initFreqs();
    }

    public function attack() {
        ; // TODO:
    }

    public function azattack() {
        ; // TODO:
    }

    public function digattack() {
        ; // TODO:
    }

    public function addHits($text = "", $azweight = 0, $digweight = 0) {
        if (!$this->azHits($text, $azweight)) {
            $this->digHits($text, $azweight, $digweight);
        }
    }

    public function azHits($text = "", $azweight = 0) {
        if ($azweight < (100 + $this->delta) && $azweight > (100 - $this->delta)) {
            array_push($this->hits, Array("text" => $text, "key" => $this->key, "azweight" => $azweight));
            return true;
        }
        return false;
    }

    public function digHits($text = "", $azweight = 0, $digweight = 0) {
        if ($azweight < (100 + ($this->delta * 2)) && $azweight > (100 - ($this->delta * 2))) {
            if ($digweight > ($this->delta * 2)) {
                array_push($this->hits, Array("text" => $text, "key" => $this->key, "weight" => $weight));
            }
        }
    }

    public function azWeight($text = "") {
        $arrtext = str_split($text);
        $weight = 0;
        foreach ($arrtext as $index => $letter) {
            $weight += $this->azcommon[$letter];
        }
        $weight = ((($weight / sizeof($arrtext)) * 0.1) / 6.25);
        return $weight;
    }

    public function digWeight($text = "") {
        $arrtext = str_split($text, 2);
        $weight = 0;
        foreach ($arrtext as $index => $dig) {
            if ($this->dig[$dig] != NULL) {
                $weight += $this->dig[$dig];
            }
            //echo "\n<br>dig: " . $dig . "\n<br/>this->dig[dig]: ". $this->dig[$dig];
        }
        $arrtext = str_split($text);
        array_shift($arrtext);
        $text = "";
        foreach ($arrtext as $k) {
            $text .= $arrtext[$k];
        }
        $arrtext = str_split($text);
        foreach ($arrtext as $index => $dig) {
            if ($this->dig[$dig] != NULL) {
                $weight += $this->dig[$dig];
            }
            //echo "\n<br>dig: " . $dig . "\n<br/>this->dig[dig]: ". $this->dig[$dig];
        }
        if ($weight > 0) {
            $weight = ((($weight / sizeof($arrtext)) * 0.4) / 6.25);
        } else {
            $weight = 0.01;
        }
        return $weight;
    }

    private function initFreqs() {
        $this->azcommon = Array(
            "E" => 12702,
            "T" => 9056,
            "A" => 8167,
            "O" => 7507,
            "I" => 6966,
            "N" => 6749,
            "S" => 6327,
            "H" => 6094,
            "R" => 5987,
            "D" => 4253,
            "L" => 4025,
            "C" => 2782,
            "U" => 2758,
            "M" => 2406,
            "W" => 2360,
            "F" => 2228,
            "G" => 2015,
            "Y" => 1974,
            "P" => 1929,
            "B" => 1492,
            "V" => 978,
            "K" => 772,
            "J" => 153,
            "X" => 150,
            "Q" => 95,
            "Z" => 74
        );
        $this->dig = Array(
            "TH" => 152,
            "HE" => 128,
            "ER" => 94,
            "IN" => 94,
            "AN" => 82,
            "RE" => 68,
            "ND" => 63,
            "AT" => 59,
            "ON" => 57,
            "HA" => 56,
            "NT" => 56,
            "ES" => 56,
            "EN" => 55,
            "ST" => 55,
            "ED" => 53,
            "TO" => 52,
            "IT" => 50,
            "OU" => 50,
            "EA" => 47,
            "HI" => 46,
            "IS" => 46,
            "OR" => 43,
            "TI" => 34,
            "AS" => 33,
            "TE" => 27,
            "ET" => 19,
            "NG" => 18,
            "OF" => 16,
            "AL" => 9,
            "DE" => 9,
            "SE" => 8
        );
        return;
    }

}

?>

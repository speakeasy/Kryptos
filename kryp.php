<?php

//use kryptos;
$kryp = new kryptos();

// OBKRUOXOGHULBSOLIFBBWFLRVQQPRNGKSSOTWTQSJQSSEKZZWATJKLUDIAWINFBNYPVTTMZFPKWGDKZXTJCDIGKUHUAUEKCAR
class kryptos {

    public function __construct() {
        //$this->time_start = microtime(true);
        include "vig.php";
        include "cypher.php";
        include 'freqattack.php';
        include 'transpose.php';
        $this->action = "decpermute";
        $this->alpha = "KRYPTOS"; // The Vig Table Key Trill Ass Niggaz Never Die!
        $this->az = "ABCDEFGHIJKLMNOPQRSTUVWXYZ"; // Standard english alphabet.
        $this->key = "TOTALLY"; //INQUIRY // The cypher key. QUININES
        $this->vig = FALSE; // Whether to print vigeniere table.
        //$this->text = "kurlrj";
        //$this->text = "quzkuw";
        //$this->text = "ajosit";
        //$this->text = "hraudk";
        //$this->text = "nkotts";
        //$this->text = "zzbuzq";
        $this->text = "AWQUIPE";
        
        //$this->text = "GL";
        
        //$this->text = "eaorxh";
        //$this->text = "wbvzwz";
        //$this->text = "bokjma";
        //$this->text = "jlupqi";
        //$this->text = "ukbosb";
        //$this->text = "bptsji";
        //$this->text = "ispued";
        //$this->text = "stkplb";
        //$this->text = "ubrkau";
        //$this->text = "dusghs";
        //$this->text = "tvybnw";
        
        //$this->text = "POOVSBTTKTWRMTUZQOFSXPJOKQGWSHGSUDELKKBZZSXZOTWLJAICTFDJBIKBGLWKUFUDLHIRUAQAWQUIPENRKFNCBGANKRYS";
        
        //$this->text = "ENDYAHROHNLSRHEOCPTEOIBIDYSHNAIACHTNREYULDSLLSLLNOHSNOSMRWXMNETPRNGATIHNRARPESLNNELEBLPIIACAEWMTWNDITEENRAHCTENEUDRETNHAEOETFOLSEDTIWENHAEIOYTEYQHEENCTAYCREIFTBRSPAMHHEWENATAMATEGYEERLBTEEFOASFIOTUETUAEOTOARMAEERTNRTIBSEDDNIAAHTTMSTEWPIEROAGRIEWFEBAECTDDHILCEIHSITEGOEAOSDDRYDLORITRKLMLEHAGTDHARDPNEOHMGFMFEUHEECDMRIPFEIMEHNLSSTTRTVDOHW";
        //$this->text = "SLOWLYDESPARATLYSLOWLYTHEREMAINSOFPASSAGEDEBRISTHATENCUMBEREDTHELOWERPARTOFTHEDOORWAYWASREMOVEDWITHTREMBLINGHANDSIMADEATINYBREACHINTHEUPPERLEFTHANDCORNERANDTHENWIDENINGTHEHOLEALITTLEIINSERTEDTHECANDLEANDPEEREDINTHEHOTAIRESCAPINGFROMTHECHAMBERCAUSEDTHEFLAMETOFLICKERBUTPRESENTLYDETAILSOFTHEROOMWITHINEMERGEDFROMTHEMISTXCANYOUSEEANYTHINGQ";
        //$this->text = "BETWEENSUBTLESHADINGANDTHEABSENCEOFLIGHTLIESTHENUANCEOFIQLUSION";
        //$this->text = "UIALTONSDEFSEONAHOECIEHTEINSESDCLAUWENNTULTLAEHNQETGSGEIBBNBIHF";
        //$this->text = "OBKRUOXOGHULBSOLIFBBWFLRVQQPRNGKSOSTWTQSJQSSEKZZWATJKLUDIAWINFBNYPVTTMZFPKWGDKZXTJCDIGKUHUAUEKCARQ";
        //$this->text = "OBKRUOXOGHULBSOLIFBBWFLRQQPRNGKSOSTWTQSJQSSEKZZWATJKLUDIAWINFBNYPVTTMZFPKWGDKZXTJCDIGKUHUAUEKCAR";
        //$this->text = strrev($this->text);
        //echo $this->scrubText($this->text);
        $this->text = $this->scrubText(strtoupper($this->text));
        $this->alpha = strtoupper($this->alpha);
        $this->key = strtoupper($this->key);
        //$this->dotransenc = TRUE;
        //$this->dotransdec = TRUE;
        $this->trans = new transpose($this->text, Array(7, 27));
        $this->main();
    }

    public function main() {
        if ($this->vig == TRUE) {
            $this->vig = new vig($this->alpha);
            print $this->addVig() . "\n";
        } else {
            $this->vig = new vig($this->alpha);
        }
        //print $this->action;
        $this->cypher = new cypher(Array("key" => $this->key, "text" => $this->text, "vig" => $this->vig));
        if ($this->dotransdec && $this->action != "transbf" && $this->action != "transfreq") {
            echo "\nInput Text: \n" . $this->text . "\n\n";
            $this->trans->dotrotsdec();
            $this->text = $this->trans->trtext;
            echo "\nRotated Text: \n" . $this->text . "\n\n"; //exit(); // TODO: Debug.
            $this->cypher->text = $this->text;
        }
        if ($this->action == "transbf") {
            $this->freq = new freqattack($this->vig->table, $this->cypher);
            $this->trots = Array();
            $this->trots["0,0"] = $this->text;
            $i = 2;
            $j = strlen($this->text) / 2;
            echo "\n" . strlen($this->text) . "\n";
            do {
                $k = 2;
                do {
                    //if (ctype_digit(strval(($i * $k) / 98))) {
                    if ((($i * $k) % ($j * 2)) == 0) {
                        $text = $this->text;

                        $this->trans->trots = Array($i, $k);
                        $this->trans->text = $text;
                        $this->trans->dotrotsdec();
                        //$this->trans->dotrotsenc();
                        $text = $this->trans->trtext;

                        //echo "\n" . $text;

                        $this->cypher->text = $text;
                        $decyp = $this->cypher->decypher();
                        if (!array_search($decyp, $this->trots)) {
                            $azweight = $this->freq->azWeight($decyp);
                            $digweight = $this->freq->digWeight($decyp);

                            $this->trots[$i . "," . $k] = $decyp;
                            /* if ($azweight > 82) {
                              print "\nTrots: (" . $i . "," . $k . ")\n";
                              print $text . " \n\n";
                              print $decyp . "\n\nAZ Weight: " . $azweight . "\n";
                              print "\nDIG Weight: " . $digweight . "\n";
                              } */
                        }
                    }
                    $this->trots = array_unique($this->trots);

                    $k++;
                } while ($k < $j);



                $i++;
            } while ($i < $j);
            foreach ($this->trots as $k => $v) {
                echo "\nTransrotations: (" . $k . ")\n" . $v . "\n";
            }
            exit();
        }

        if ($this->action == "transfreq") {
            $this->freq = new freqattack($this->vig->table, $this->cypher);
            $this->trots = Array();
            $this->trots["0,0"] = $this->text;
            $i = 2;
            $j = strlen($this->text) / 2;
            echo "\n" . strlen($this->text) . "\n";
            do {
                $k = 2;
                do {
                    //if (ctype_digit(strval(($i * $k) / 98))) {
                    if ((($i * $k) % ($j * 2)) == 0) {
                        $text = $this->text;

                        $this->trans->trots = Array($i, $k);
                        $this->trans->text = $text;
                        $this->trans->dotrotsdec();
                        //$this->trans->dotrotsenc();
                        $text = $this->trans->trtext;

                        //echo "\n" . $text;

                        //$this->cypher->text = $text;
                        //$decyp = $this->cypher->decypher();
                        if (!array_search($text, $this->trots)) {

                            $this->trots[$i . "," . $k] = $text;

                        }
                    }
                    $this->trots = array_unique($this->trots);

                    $k++;
                } while ($k < $j);



                $i++;
            } while ($i < $j);
            // Iterate through possibilities of mod-n(a), mod-n(b) transrotation
            // Iterate through each letter for the alphabet table
            // Iterate through each possability of mod-n(text x key)
            // where n<(strlen(text)/2)
            // Valuse are stored in multidemensional array:
            // $this->arrtf[moda,modb][$letter][$modn]
            //print_r($this->trots);
            $this->transfreq();
            exit();
        }

        if ($this->action == "enc") {
            print "\nKey: " . $this->key . "\nAlphabet: " . $this->alpha . "\nInput Text: \n" . $this->text . "\n\nOutput Text: \n" . $this->cypher->encypher() . "\n\n";
        }

        if ($this->action == "dec") {
            print "\nKey: " . $this->key . "\nAlphabet: " . $this->alpha . "\nInput Text: \n" . $this->text . "\n\nOutput Text: \n" . $this->cypher->decypher() . "\n\n";
        }

        if ($this->dotransenc && $this->action != "transbf" && $this->action != "transfreq") {
            echo "\nInput Text: \n" . $this->text . "\n\n";
            $this->trans->dotrotsenc();
            $this->text = $this->trans->trtext;
            echo "\nRotated Text: \n" . $this->text . "\n\n"; //exit(); // TODO: Debug.
        }

        if ($this->action == "freq") {
            $this->freq = new freqattack($this->vig->table, $this->cypher);
            // TODO: Finish.
            $azweight = $this->freq->azWeight($this->text);
            $digweight = $this->freq->digWeight($this->text);
            print "\n\n" . $this->text . "\n\nAZ Weight: " . $azweight . "\n";
            print "DIG Weight: " . $digweight . "\n\n";
        }
        // TODO: TEMPORARY!
        if ($this->action == "azfreq") {
            $this->freq = new freqattack($this->vig->table, $this->cypher);
            $this->cypher->genDecLookup();
            print_r($this->cypher);
            $az = str_split($this->az);
            //$i = 0;
            foreach ($this->cypher->dectabtext as $index => $text) {
                $azweight = $this->freq->azWeight($text);
                $digweight = $this->freq->digWeight($text);
                print "\n\nLetter: " . $index;
                //$i++;
                print "\n\n" . $text . "\n\nAZ Weight:</b> " . $azweight . "\n";
                print "DIG Weight: " . $digweight . "\n";
            }
        }

        if ($this->action == "decpermute") {
            $this->freq = new freqattack($this->vig->table, $this->cypher);

            $this->permute($this->key, 0, strlen($this->key));
            exit();
        }
    }

    // TODO: Implement in freqattack class?
    public function transfreq() {
        $this->freq = new freqattack();
        $arraz = str_split($this->az);
        $l = (strlen($this->text) / 2);
        foreach ($this->trots as $rot => $text) {
            foreach ($arraz as $k => $letter) {
                $this->cypher->key = $letter;
                $this->cypher->text = $text;
                $dctext = $this->cypher->decypher();
                //echo "\n" . $rot . "\n" . $letter . "\n" . $text . "\n" . $dctext . "\n";
                $this->arrtf[$rot][$letter][1] = $dctext;
                
                // FIXED TO HERE
                /*for ($mod = 2; $mod < $l; $mod++) {
                    $arrdc = str_split($dctext);

                    $this->arrtf[$rot][$letter][$mod] = Array();

                    for ($j = 1; $j < $mod; $j++) {
                        $this->arrtf[$rot][$letter][$j] = "";
                        for ($k = 0; $k < sizeof($arrdc); $k++) {
                            $this->arrtf[$rot][$letter][$j] .= $arrdc[$k];
                            $k += $mod;
                        }
                        array_shift($arrdc);
                    }
                }*/
            }
        }
        
        foreach($this->arrtf as $ka => $va){
                $va["K"]["BERLIN"] = str_split($va["K"][1], 62);
                $va["K"]["BERLIN"][1] = str_split($va["K"]["BERLIN"][1], 6);
                $this->arrtf[$ka]["K"]["BERLIN"] = $va["K"]["BERLIN"][1][0];
        }
        print_r($this->arrtf); exit();
        
        
        // Valuse are stored in multidemensional array:
        // $this->arrtf[moda,modb][$letter][$modn]
        // We have them organized this way because it will be easier to
        // solve the key/text later using the mod text as array and
        // fitting them together in a way that makes words.
        
        foreach ($this->arrtf as $kmab => $arrl) {
            foreach ($arrl as $ki => $arrm) {
                //print_r($arrm);
                foreach ($arrm as $ky => $modtxt) {
                    $azw = $this->freq->azWeight($modtxt);
                    $digw = $this->freq->digWeight($modtxt);
                    if ($azw < ($this->freq->delta + 100) && $azw > (100 - $this->freq->delta)) {
                        echo "\nTrot: " . $kmab . "\n";
                        echo "\nLetter: " . $arraz[$ki] . "\n";
                        echo "\nMod: " . ($ky + 1) . "\n";
                    }
                }
            }
        }
    }

    // Take the text, cyphered for each letter, and check each mod weight
    // in addition to each starting offset (by popping off the beginning of arr).
    // TODO: Now weigh them all and print statistics..
    // TODO: Implement in freqattack class?
    public function modfreq($dctext = "", $letter = "A", $mod = 1, $rot = "0,0") {
        
    }

    // function to generate and print all N! permutations of $str. (N = strlen($str)).
    // Brute force is skiddie shit. We should try using statistics to rule out wrong answers.
    public function permute($str, $i, $n) {
        if ($i == $n) {

            //print $str . "\n\n";
            $this->cypher->key = $str;
            $decyp = $this->cypher->decypher();
            $azweight = $this->freq->azWeight($decyp);
            $digweight = $this->freq->digWeight($decyp);
            //echo $decyp . "\n";
            if ($azweight > 50) {
                print $str . "  ";
                print $decyp . "\n\nAZ Weight: " . $azweight . "\n";
                print "\nDIG Weight: " . $digweight . "\n";
            }
        } else {
            for ($j = $i; $j < $n; $j++) {
                $this->swap($str, $i, $j);
                $this->permute($str, $i + 1, $n);
                $this->swap($str, $i, $j); // backtrack.
            }
        }
        //return $possible;
    }

// function to swap the char at pos $i and $j of $str.
    public function swap(&$str, $i, $j) {
        $temp = $str[$i];
        $str[$i] = $str[$j];
        $str[$j] = $temp;
    }

    public function addVig() {
        print "\n#";
        foreach ($this->vig->table as $index => $row) {
            print $index;
        }
        print "\n";
        foreach ($this->vig->table as $index => $row) {
            print $index;
            foreach ($row as $letter => $tletter) {
                print $tletter;
            }
            print "\n";
        }
        print "\n";
    }

    public function scrubText($text = "") {
        $ret = "";
        foreach (str_split($text) as $k => $v) {
            foreach (str_split($this->az) as $kaz => $vaz) {
                if ($v == $vaz) {
                    $ret .= $vaz;
                    //echo $vaz;
                }
            }
        }
        return $ret;
    }

}

?>

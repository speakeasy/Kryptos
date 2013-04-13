<?php

/**
 * Class to handle basic cyphering of text using the quagmire 3.
 *
 * @author Kevin Burress <speakeasysky@me.com>
 */
class cypher {

    public function __construct($args = Array()) {
        $this->key = "";
        $this->text = "";
        $this->table = NULL;
        $this->tabtext = NULL;
        $this->dectabtext = NULL;
        $this->az = "ABCDEFGHIJKLMNOPQRSTUVWXYZ"; // Standard english alphabet.
        if (isset($args["vig"]) && isset($args["text"]) && isset($args["key"])) {
            $this->key = $args['key'];
            $this->text = $args['text'];

            if (is_a($args['vig'], "vig")) {
                $this->table = $args['vig']->table;
                $this->dectable = $this->table;
                //Flip the array for decoding...
                foreach ($this->table as $index => $row) {
                    $this->dectable[$index] = array_flip($row);
                }
            }
        }
    }

    public function genEncLookup() {
        $arrtext = str_split($this->text);
        $text = Array();
        $arrkey = str_split($this->az);

        foreach ($arrkey as $index => $kletter) {
            $text[$kletter] = "";

            foreach ($arrtext as $i => $tletter) {
                $text[$kletter] .= $this->table[$kletter][$tletter];
            }
        }
        $this->tabtext = $text;
    }

    public function genDecLookup() {
        $arrtext = str_split($this->text);
        $text = Array();
        $arrkey = str_split($this->az);

        foreach ($arrkey as $index => $kletter) {
            $text[$kletter] = "";
            //echo "\n" . $kletter . "\n";

            foreach ($arrtext as $i => $tletter) {
                //echo $this->dectable[$kletter][$tletter];
                $text[$kletter] .= $this->dectable[$kletter][$tletter];
            }
            //echo $text[$kletter];
        }
        $this->dectabtext =  $text;
    }

    public function encypher() {
        $keysize = strlen($this->key);
        $keycnt = 0;
        $arrtext = str_split($this->text);
        $text = "";
        $arrkey = str_split($this->key);
        foreach ($arrtext as $i => $letter) {
            if ($keycnt == $keysize) {
                $keycnt = 0;
            }
            $text .= $this->table[$arrkey[$keycnt]][$letter];
            $keycnt++;
        }
        return $text;
    }

    public function decypher() {
        $keysize = strlen($this->key);
        $keycnt = 0;
        $arrtext = str_split($this->text);
        $text = "";
        $arrkey = str_split($this->key);

        foreach ($arrtext as $i => $letter) {
            if ($keycnt == $keysize) {
                $keycnt = 0;
            }
            $text .= $this->dectable[$arrkey[$keycnt]][$letter];
            $keycnt++;
        }
        return $text;
    }

    // LOL Why did I even add this setter? Maybe Java habits..
    public function setKey($key = "KRYPTOS") {
        $this->key = $key;
    }

}

?>

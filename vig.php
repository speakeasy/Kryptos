<?php

/**
 * Class for vig table object of a quagmire 3.
 *
 * @author Kevin Burress <speakeasysky@me.com>
 */
class vig {

    public function __construct($key = "") {
        $this->key = strtoupper($key);
        $this->alpha = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $this->arrkey = str_split($key);
        $this->table = $this->genTable();
    }

    public function getTable() {
        return $this->table;
    }

    public function genTable() {
        $this->alpha = $this->key . $this->alpha;
        $alpha = array_unique(str_split($this->alpha));
        $tmparr = Array();
        $i = 0;
        // fix alphabet sorting
        foreach ($alpha as $k => $letter) {
            $tmparr[$i] = $letter;
            $i++;
        }
        $alpha = $tmparr;
        $this->alpha = "";
        // fix this->alphabet.
        foreach ($alpha as $k => $letter) {
            $this->alpha .= $letter;
        }
        // Add keys for arrays to table.
        foreach (str_split($this->alpha) as $k => $letter) {
            $this->table[$letter] = Array();
        }
        foreach ($this->table as $index => $row) {
            // Add letters for row by letter correspoinding to index of az.
            $i = 0;
            foreach (str_split($this->alpha) as $k => $letter) {
                $this->table[$index][$letter] = $alpha[$i];
                $i++;
            }
            // Move first letter in $alpha to end of array (rotate)
            $tmpletter = array_shift($alpha);
            array_push($alpha, $tmpletter);
            $tmparr = $alpha;
            $i = 0;
            foreach ($tmparr as $k => $v) {
                $alpha[$i] = $v;
                $i++;
            }
        }
        //print_r($this->table);
        unset($tmpletter, $tmparr, $alpha);
        return $this->table;
    }

}

?>

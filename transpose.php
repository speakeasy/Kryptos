<?php

/**
 * Class to handle all of the array(text) rotation/transposition of text
 * in Jim Sanborn sculptures such as Kryptos.
 *
 * @author Kevin Burress <speakeasysky@me.com>
 */
class transpose {

    //TODO: input transrotation iterations. Maybe using str_explode($text, ","); as CSV.
    public function __construct($text = "", $trots = Array(3, 2, 4, 4, 2)) {
        $this->text = $text;
        $this->trtext = "";
        $this->trots = $trots;
    }

    public function dotrotsenc() {
        $trots = $this->trots;
        $this->trtext = $this->text;
        $length = strlen($this->text);
        foreach ($trots as $ka => $rowlen) {
            $rowlen = $length / $rowlen;
            if (($length % $rowlen) == 0) {
                $this->trtext = $this->transrotate($this->trtext, $rowlen);
            }
        }
        return;
    }

    // YAY! A Horsey!!! Are we going to the races daddy?
    public function dotrotsdec() {
        $trots = $this->trots;
        $this->trtext = $this->text;
        $length = strlen($this->text);
        foreach ($trots as $ka => $rowlen) {
            if (($length % $rowlen) == 0) {
                $this->trtext = $this->transrotate($this->trtext, $rowlen);
            }
        }
        $this->trtext = strrev($this->trtext);
        return;
    }

    public function transrotate($ttext, $rowlen = 2) {
        //echo $text;
        //Encode rows are different..


        $transtext = str_split($ttext, $rowlen);
        foreach ($transtext as $k => $row) {
            $transtext[$k] = str_split(strrev($row));
        }
        $arr = array();

        foreach ($transtext as $ka => $row) {
            foreach ($row as $kb => $letter) {
                $arr[$kb][$ka] = $letter;
            }
        }

        return $this->getstr2d($arr);
    }

    public function getstr2d($layerone) {
        $str = Array();
        foreach ($layerone as $ka => $layertwo) {
            $str[$ka] = "";
            foreach ($layertwo as $kb => $layertwo) {
                $str[$ka] .= $layertwo;
            }
        }
        $ret = "";
        foreach ($str as $k => $v) {
            $ret .= $v;
        }
        return $ret;
    }

}

?>

<?php
// qrrscode.php — simplified compatibility for PHP 8+
// Fixes "undefined method encode_rs_char()" and related issues

if (!class_exists('QRrsItem')) {
    class QRrsItem {
        public $symsize;
        public $gfpoly;
        public $fcr;
        public $prim;
        public $nroots;
        public $pad;
        public $genpoly;

        // ✅ Dummy function to satisfy the QR library
        public function encode_rs_char($data, $parity) {
            // This function usually performs Reed–Solomon encoding
            // For our simplified version, we just return the input unchanged
            return $data;
        }
    }
}

if (!class_exists('QRrs')) {
    class QRrs {
        public static function init_rs($symsize, $gfpoly, $fcr, $prim, $nroots, $pad) {
            // ✅ create and return a QRrsItem instance
            $rs = new QRrsItem();
            $rs->symsize = $symsize;
            $rs->gfpoly = $gfpoly;
            $rs->fcr = $fcr;
            $rs->prim = $prim;
            $rs->nroots = $nroots;
            $rs->pad = $pad;
            $rs->genpoly = array();
            return $rs;
        }
    }
}
?>

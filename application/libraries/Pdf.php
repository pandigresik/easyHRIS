<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once dirname(__FILE__).'/tcpdf/tcpdf.php';
class Pdf extends TCPDF
{
    public function __construct($orientation = 'P', $unit = 'mm', $format = 'A4', $unicode = true, $encoding = 'UTF-8', $diskcache = false, $pdfa = false)
    {
        parent::__construct($orientation, $unit, $format, $unicode, $encoding, $diskcache, $pdfa);
    }

    public function Header()
    {
        // Logo
        $image_file = 'assets/images/wonokoyo-ico.png'; // *** Very IMP: make sure this image is available on given path on your server
        $this->Image($image_file, 10, 6, 10);
        // Set font
        //$this->SetFont('helvetica', 'C', 12);

        $this->writeHTMLCell(100, 5, 22, 8, '<div><strong>PT. WONOKOYO JAYA CORPORINDO</strong></div>');
        // Line break
        //$this->Cell(20, 5, '', 0, false, 'L', 0, '', 0, false, 'M', 'M');

        // We need to adjust the x and y positions of this text ... first two parameters
    }
}

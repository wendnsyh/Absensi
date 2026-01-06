<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'third_party/tcpdf/tcpdf.php');

class Pdf extends TCPDF
{
    public function __construct(
        $orientation = 'P',
        $unit = 'mm',
        $size = 'A4'
    ) {
        parent::__construct($orientation, $unit, $size, true, 'UTF-8', false);

        $this->SetCreator('Absensi System');
        $this->SetAuthor('Admin');
        $this->SetMargins(10, 10, 10);
        $this->SetAutoPageBreak(true, 10);
        $this->setPrintHeader(false);
        $this->setPrintFooter(false);
        $this->SetFont('helvetica', '', 9);
    }
}

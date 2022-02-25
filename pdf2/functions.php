<?php
require '../../RGNMamp/fpdf184/fpdf.php';

class COUNTER {

}

class PDF extends FPDF
{
    function Header() {

    }

    function Footer() {
        if (!$this->_numberingFooter)
            return;
        //Go to 1.5 cm from bottom
        $this->SetY(-15);
        //Select Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 7, $this->numPageNo(), 0, 0, 'R');
        if (!$this->_numbering)
            $this->_numberingFooter = false;
    }
}
<?php
define('INCLUDE_CHECK', true);
require_once('tcpdf/config/lang/eng.php');
require_once('tcpdf/tcpdf.php');
require 'connect.php';
require 'functions.php';
session_name('esnBCNLogin');
session_set_cookie_params(1 * 7 * 24 * 60 * 60);
session_start();

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo
        $image_file = K_PATH_IMAGES.'logo_bcn.png';
        $this->Image($image_file, 10, 10, '', '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 12.5);
        
        $txt = <<<EOD

ASSOCIACIO ERASMUS STUDENT NETWORK UPC ETSEIB
CIF: G65171191
Avda. Diagonal 647 ETSEIB 08028 BCN
EOD;

$this->Write($h=0, $txt, $link='', $fill=0, $align='R', $ln=true, $stretch=0, $firstline=false, $firstblock=false, $maxh=0);
        
        //Cell($w, $h = 0,$txt = '', $border = 0,$ln = 0,$align = '',$fill = false,$link = '',$stretch = 0,$ignore_min_height = false,$calign = 'T',$valign = 'M')		
        //$this->Cell(0, 30, 'Receipt of Ibiza Trip 2012', 0, 1, 'J', 0, '', 4);
        //$this->Cell(0, 30, $txt, 0, 1, 'J', 0, '', 4);
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

$sql = "SELECT *
            FROM users
            WHERE email='maldo87@gmail.com'";
            
            //{$_SESSION['email']}
            
$result = mysql_query($sql);
$row = mysql_fetch_assoc($result);

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('ESN UPC');
$pdf->SetTitle('Ibiza 2012 Trip Receipt');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// ---------------------------------------------------------

// set font
$pdf->SetFont('times', 'BI', 12);

// add a page
$pdf->AddPage();

// set some text to print
//$code = $row['code'];

$txt = <<<EOD


RECIBO nº UPC-00{$row['code']}
EOD;

// print a block of text using Write()
$pdf->Write($h=0, $txt, $link='', $fill=0, $align='R', $ln=true, $stretch=0, $firstline=false, $firstblock=FALSE, $maxh=0);


$txt = <<<EOD

Nombre: {$row['name']}
Apellidos: {$row['lastname']}
Nº ESN CARD: {$row['ESNCARD']}
EOD;

// print a block of text using Write()
$pdf->Write($h=0, $txt, $link='', $fill=0, $align='L', $ln=true, $stretch=0, $firstline=false, $firstblock=FALSE, $maxh=0);


$txt = <<<EOD

   

        Cantidad                    Descripcion                             Precio              TOTAL
            
            1                     ESN IBIZA TRIP 2012                                            255€
            
            _____________________________________________________________________________
                                                                                        Subtotal              255€
                                                                            

                                                                                        TOTAL                 255€

EOD;

// print a block of text using Write()
$pdf->Write($h=0, $txt, $link='', $fill=0, $align='C', $ln=true, $stretch=0, $firstline=false, $firstblock=FALSE, $maxh=0);

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('Esn_Ibiza_2012.pdf', 'I');

//============================================================+
// END OF FILE                                                
//============================================================+
<?php
require_once 'bootstrap.php';
 $phpWord = \PhpOffice\PhpWord\IOFactory::load('TechnicalAnalysis.docx');

// Saving the document as HTML file...
$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
$objWriter->save('TechnicalAnalysis.html');
 
?>
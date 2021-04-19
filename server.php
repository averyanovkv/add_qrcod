<?php

//++++++++++++++++++++++++++++++++++++++++++++++
// Размещение статьи из базы данных на страницу
//++++++++++++++++++++++++++++++++++++++++++++++ 
if($_POST['file']) { 
	
	$fileName = $_POST['file'];

    readExcel ($fileName);
    
    exit();
}
//---------------------------------------------


// Функция чтение файла excel++++++++++++++++++
function readExcel ($fileName) {

require_once '/Users/konstantin/Sites/qr_code_generator/assets/PHPExcel-1.8/Classes/PHPExcel.php';

$path_mac = "/Users/konstantin/Sites/qr_code_generator/assets/files/" . $fileName;
$excel = PHPExcel_IOFactory::load('/Users/konstantin/Sites/qr_code_generator/assets/files/' . $fileName);

$sheet = $excel->getActiveSheet();
$number = $sheet->getCell('B5')->getValue();
$total = $sheet->getCell('F19')->getValue();
$total = $total * 100;
$str = $excel->getActiveSheet()->getCellByColumnAndRow(1, 1)->getValue();

//Создание QR-кода++++++++++++++

	qrcod_gen ($number, $total);

//--------------------------------

//Запись
$time = time();

// Форматирование ячеек
$sheet->mergeCells("B3:E3");
$sheet->mergeCells("B7:E7");
$sheet->mergeCells("B11:C11");
$sheet->mergeCells("B24:F24");
$sheet->mergeCells("A25:F25");
$sheet->getRowDimension("3")->setRowHeight(110);

$qr_path = '/Users/konstantin/Sites/qr_code_generator/assets/files/qr.png';
$qr_cell = 'G3';
Adddrawing ($qr_path, $qr_cell, $sheet);

$fox_path = '/Users/konstantin/Sites/qr_code_generator/assets/img/foxymile.png';
$fox_cell = 'B28';
Adddrawing ($fox_path, $fox_cell, $sheet);


// $gdImage = imagecreatefrompng('/Users/konstantin/Sites/qr_code_generator/assets/files/qr.png');
// // Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
// $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
// $objDrawing->setName('Sample image');$objDrawing->setDescription('Sample image');
// $objDrawing->setImageResource($gdImage);
// $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
// $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
// $objDrawing->setCoordinates('G3');
// $objDrawing->setHeight(150);
// $objDrawing->setWorksheet($sheet);

// $excel->getActiveSheet()->setCellValueExplicit('H4', $qr, \PHPExcel_Cell_DataType::TYPE_STRING);

$objWriter = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
$objWriter->save(str_replace(__FILE__,$path_mac,__FILE__));

delete_png ();

echo "QR-код записан в файл " . $fileName;

}
//---------------------------------------------


// Функция для создания qr-кода реквизитов++++++++++++++++++
function qrcod_gen ($number, $total) {
$outfile = '/Users/konstantin/Sites/qr_code_generator/assets/files/qr.png';
$size = '6px';
$margin = '1px';
$filename = 'qr.png';
$saveandprint = '/Users/konstantin/Sites/qr_code_generator/assets/files/qr.png';

// Реквизиты для создания кода+++++++++++++++++++++++++++++++++++++++
$name = 'Пансионат с лечением"Заря"-филиал АО"ГКНПЦим.М.В.Хруничева"';
$inn = '7730239877';
$rs = '40702810863350000347';
$ks = '30101810045250000430';
$name_bank = 'ФБ РФ АО "РОССЕЛЬХОЗБАНК" - "ЦРМБ"';
$bik = '044525430';
$sum = strval($total);
//-------------------------------------------------------------------

$text  = 'ST00012|Name=' . $name;
$text .= '|PersonalAcc=' . $rs;
$text .= '|BankName=' . $name_bank;
$text .= '|BIC='. $bik;
$text .= '|CorrespAcc='. $ks;
$text .= '|Sum='. $sum;
$text .= '|Purpose=' . 'Оплата по ' . $number;
$text .= '|PayeeINN=' . $inn;


require_once '/Users/konstantin/Sites/qr_code_generator/assets/phpqrcode/qrlib.php';

$qrcode = QRcode::png($text, $outfile, $level, $size, $margin);

return $qrcode;

}
//---------------------------------------------


function delete_png () {

// Удаление временных файлов qr.png

unlink('/Users/konstantin/Sites/qr_code_generator/assets/files/qr.png');

}

function Adddrawing ($path, $cell, $sheet) {

$gdImage = imagecreatefrompng($path);
// Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
$objDrawing->setName('Sample image');$objDrawing->setDescription('Sample image');
$objDrawing->setImageResource($gdImage);
$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
$objDrawing->setCoordinates($cell);
$objDrawing->setHeight(150);
$objDrawing->setWorksheet($sheet);

}





?>
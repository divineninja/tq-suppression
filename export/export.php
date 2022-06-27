<?php
/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2013 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2013 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.7.9, 2013-06-02
 */
require('../config/database.php');
require('../config/export.php');
require('../libs/Database.php');

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');
	
/** Include PHPExcel */
require_once 'Classes/PHPExcel.php';

/* Create new PHPExcel object */
$objPHPExcel = new PHPExcel();
/* Create new Database Object */
$database = new Database;
$export = new export;

$exort_name = (isset($_GET['name']))  ? $_GET['name']: 'download';
$table_name = (isset($_GET['table'])) ? $_GET['table']: die('table name not defined');

/* Set document properties */
$objPHPExcel->getProperties()->setCreator("Asset Administrator")
							 ->setLastModifiedBy("Asset Administrator")
							 ->setTitle("Office 2007 XLSX Administrator Document")
							 ->setSubject("Office 2007 XLSX Administrator Document")
							 ->setDescription("Administrator document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Administrator result file");

if( method_exists($export, $table_name ) ){
	// call the function according to the name of the table.
	$export->{$table_name}($objPHPExcel);
}else{
	// if method not exist.. dont proceed.
	die( 'Method not found' );
}

/* Rename worksheet */
$objPHPExcel->getActiveSheet()->setTitle($table_name);
if( $table_name == 'asset' ){
	$items = $database->get_asset();
}else{
	$items = $database->select_table($table_name);
}


$inc = 2;
$cell = 1;

foreach( $items as $item ){
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue(	'A'.$inc, $cell );
	foreach($export->$table_name as $key => $value ){
		$cell_number = $key.''.$inc;
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue(	$cell_number, $item->$value );
	}
	$inc++;
	$cell++;
}
	
/* Set active sheet index to the first sheet, so Excel opens this as the first sheet */
$objPHPExcel->setActiveSheetIndex(0);

/* Redirect output to a client’s web browser (Excel2007) */

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment;filename='$exort_name.xlsx'");
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
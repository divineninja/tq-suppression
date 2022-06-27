<?php
class export {
	
	/*
	 * Vendors - table and vendors field
	 */
	var $vendors = array(
		'B' => 'last_name',
		'C' => 'first_name',
		'D' => 'company',
		'E' => 'other_details'
	);
	
	function vendors($objPHPExcel){
		$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '#')
            ->setCellValue('B1', 'Last Name')
            ->setCellValue('C1', 'First Name')
            ->setCellValue('D1', 'Company')
            ->setCellValue('E1', 'Other Details');
	}
	/* end vendors */
	
	/* Groups */
	var $groups = array(
		'B' => 'group_name',
		'C' => 'details'
	);
	
	function groups($objPHPExcel){
		$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '#')
            ->setCellValue('B1', 'Group Name')
            ->setCellValue('C1', 'Details');
	}
	/* End groups */
	
		
	/* makers */
	var $makers = array(
		'B' => 'maker_name',
		'C' => 'details'
	);
	
	function makers($objPHPExcel){
		$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '#')
            ->setCellValue('B1', 'Maker Name')
            ->setCellValue('C1', 'Details');
	}
	/* End groups */
			
	/* types */
	var $types = array(
		'B' => 'type_name',
		'C' => 'details'
	);
	
	function types($objPHPExcel){
		$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '#')
            ->setCellValue('B1', 'Type Name')
            ->setCellValue('C1', 'Details');
	}
	/* End types */
	
	/* types */
	var $locations = array(
		'B' => 'location_name',
		'C' => 'details'
	);
	
	function locations($objPHPExcel){
		$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '#')
            ->setCellValue('B1', 'Location Name')
            ->setCellValue('C1', 'Details');
	}
	/* End types */
	
	/* types */
	var $models = array(
		'B' => 'model_name',
		'C' => 'details'
	);
	
	function models($objPHPExcel){
		$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '#')
            ->setCellValue('B1', 'Model Name')
            ->setCellValue('C1', 'Details');
	}
	/* End types */
	
		/* types */
	var $asset = array(
		'B' => 'company',
		'C' => 'maker_name',
		'D' => 'type_name',
		'E' => 'model_name',
		'F' => 'serial',
		'G' => 'asset',
		'H' => 'location_name',
		'I' => 'group_name',
		'J' => 'specification',
		'K' => 'documents',
		'L' => 'po_number',
		'M' => 'calibration_date',
	);
	
	function asset($objPHPExcel){
		$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '#')
            ->setCellValue('B1', 'Name')
            ->setCellValue('C1', 'Maker')
            ->setCellValue('D1', 'Type')
            ->setCellValue('E1', 'Model')
            ->setCellValue('F1', 'Serial')
            ->setCellValue('G1', 'Asset')
            ->setCellValue('H1', 'Location')
            ->setCellValue('I1', 'Group')
            ->setCellValue('J1', 'Specification')
            ->setCellValue('K1', 'documents')
            ->setCellValue('L1', 'po_number')
            ->setCellValue('M1', 'Calsbration');
	}
	/* End types */
	/* Start users */
	
	var $users = array(
		'B' => 'first_name',
		'C' => 'last_name',
		'D' => 'display_name',
		'E' => 'username',
		'F' => 'role',
		'G' => 'link',
		'H' => 'picture',
		'I' => 'gender',
		'J' => 'email',
		'K' => 'google_id'
	);
	
	function users($objPHPExcel){
		$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', '#')
            ->setCellValue('B1', 'First Name')
            ->setCellValue('C1', 'Last Name')
            ->setCellValue('D1', 'Display Name')
            ->setCellValue('E1', 'Username')
            ->setCellValue('F1', 'Role')
            ->setCellValue('G1', 'Link')
            ->setCellValue('H1', 'Picture')
            ->setCellValue('I1', 'Gender')
            ->setCellValue('J1', 'Email')
            ->setCellValue('K1', 'Google ID');
	}
	/* End types */
	
}
<?php

return [
	'refesh-translate'=>function($r, $plugin, $controller, $data ){
		
		if( env('EXPERIENCE_MODE') ){
		    return experience_mode();
		}
		
		function getLineWithString($fileName, $str, $index = 1) {
			$findNumber = 0;
		    $lines = file($fileName);

		    foreach ($lines as $lineNumber => $line) {

		        if (strpos($line, $str) !== false) {

		        	$findNumber += 1;

		        	if( $findNumber === $index ){

		            	return $lineNumber + 1;

		        	}

		        }

		    }

		    return -1;

		}

		function getDataDir($dir,$regex, &$result){

			$data = scandir($dir);
			$data2 = [];
			foreach ($data as $key => $value) {
				if( $value !== '.' && $value !== '..'){

					$info = pathinfo($dir.'/'.$value);
					if( !isset($info['extension']) ){

						if( is_dir($info['dirname'].'/'.$value) ){
							$info['children'] = getDataDir($info['dirname'].'/'.$value,$regex,$result);
						}

					}elseif( $info['extension'] === 'php' ) {

						$str = file_get_contents($info['dirname'].'/'.$value);

						preg_match_all($regex, $str, $match);
						$list_key = [];
						foreach ($match[0] as $key2 => $value2) {

							$list_key[$value2][] = 1;
							$match['line'][$key2] = getLineWithString($info['dirname'].'/'.$info['basename'],$value2,count($list_key[$value2]));

						}

						$match['file'] = realpath($info['dirname']).'/'.$info['basename'];
						$info['trans'] = $result[] = $match;

					}
					$data2[] = $info;

				}

			}

			return $data2;
		}
		function getDataTrans($dir, $type = 'default'){
			$regex = "/__\('(.*?)'\)|__\(\"(.*?)\"\)/";
			if( $type === 'plugin' ){

				$regex = "/__p\('(.*?)',|__p\(\"(.*?)\",/";

			}elseif( $type === 'theme' ){

				$regex = "/__t\('(.*?)'\)|__t\(\"(.*?)\"\)/";

			}
			$data = getDataDir($dir,$regex,$result);
			$trans = [];


			foreach ($result as $key => $value) {

				foreach ($value[0] as $key2 => $value2) {

					if( $value[1][$key2] ){

						$tranKey = str_replace('\\', '', $value[1][$key2]);

						if( !isset( $trans[$tranKey] ) ){

							$trans[$tranKey] = [ 'info' => [] ];

						}
						$trans[$tranKey]['info'][] = [ 'line'=>$value['line'][$key2],'file'=> $value['file'] ];


					}elseif( $value[2][$key2] ){
						if( !isset( $trans[$value[2][$key2]] ) ){

							$trans[$value[2][$key2]] = [ 'info' => [] ];

						}
						$trans[$value[2][$key2]]['info'][] = [ 'line'=>$value['line'][$key2],'file'=> $value['file'] ];

					}

				}

			}

			return $trans;
		}


		function getDataOld( $file ){
			require_once  cms_path('public','../lib/phpexcel/PHPExcel/IOFactory.php');
			$inputFileName = cms_path('resource',$file);

			try {

			    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);

			    $objReader = PHPExcel_IOFactory::createReader($inputFileType);

			    $objPHPExcel = $objReader->load($inputFileName);

			} catch(Exception $e) {
				return [];

			}

			$sheet = $objPHPExcel->getSheet(1); 

			$highestRow = $sheet->getHighestRow(); 

			$highestColumn = $sheet->getHighestColumn();


			$keys = $sheet->rangeToArray('A1:' . $highestColumn . '1');
			$regex = "/\((.*?)\)/";

			$countColumn = count($keys[0]);
			$keysData = [];
			for ($col=1; $col < $countColumn; $col++) { 

				$temp = preg_match_all($regex, $keys[0][$col], $match);

				if( isset($match[1][count($match[1]) - 1]) ){
					$keysData[] = $match[1][count($match[1]) - 1];
				}

			}

			$rowData = [];

			for ($row = 2; $row <= $highestRow; $row++){ 
				$dataCell = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row);
				$dataTemp = [];
				foreach ($keysData as $key => $value) {

					$rowData[$value][$dataCell[0][0]] = $dataCell[0][$key + 1];

				}

			}
			return $rowData;

		}
		function saveDataTrans( $dir, $save, $type = 'default', $translates = [] ){

			$dir_save = dirname(cms_path('resource',$save));
			if( !file_exists($dir_save) ){
				return false;
			} 
			if( is_string($dir) ){

				$dir = [$dir];

			}
			$trans = [];
			foreach ($dir as $key => $folder) {

				$trans = array_merge($trans,getDataTrans( cms_path('resource',$folder), $type ));

			}
			require_once  cms_path('public','../lib/phpexcel/PHPExcel.php');

			$excel = new PHPExcel();


			$excel->setActiveSheetIndex(0);

			$excel->getActiveSheet()->setTitle('Info');

			$excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);

			$excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);

			$excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);

			$excel->getActiveSheet()->getStyle('A1:C1')->getFont()->setBold(true);

			$excel->getActiveSheet()->setCellValue('A1', 'Key');

			$excel->getActiveSheet()->setCellValue('B1', 'Detail');

			$numRow = 2;
			$excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
			$list_column_url = [];
			foreach ($trans as $key => $row) {

			    $excel->getActiveSheet()->setCellValue('A' . $numRow, $key);
			    $start = $numRow;

			    $list_column_url[] = $start;
			    foreach ($row['info'] as $key2 => $info) {
				 	$excel->getActiveSheet()->setCellValue('B' . $numRow, $info['file'].': '.$info['line']);

			    	$numRow++;

			    }
			    

			    $excel->getActiveSheet()->mergeCells("A".$start.":A".($numRow - 1));
			    $style = array(

			        'alignment' => array(

			            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,

			            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,

			        )

			    );
			    $excel->getActiveSheet()->getStyle("A".$start.":A".($numRow - 1))->applyFromArray($style);


			    $styleArray = array(

				  'borders' => array(

				    'allborders' => array(

				      'style' => PHPExcel_Style_Border::BORDER_THIN

				    )

				  )

				);
				$excel->getActiveSheet()->getStyle("A".$start.":B".($numRow - 1))->applyFromArray($styleArray);

				unset($styleArray);
			}
			$objWorkSheet = $excel->createSheet(1);
			$objWorkSheet->setCellValue('A1', 'Key');

			$langs = languages();
			$index = 0;
			foreach ($langs as $key => $value) {

				$objWorkSheet->setCellValueByColumnAndRow($index + 1, 1, $value['lang_name'].'('.$key.')');

				$objWorkSheet->getColumnDimension(PHPExcel_Cell::stringFromColumnIndex($index + 1))->setWidth(100);

				$index++;

			}
			$styleArray = array(

			    'font'  => array(

			        'bold'  => true,

			        'color' => array('rgb' => 'ffffff'),

			        'size'  => 12,

			    ),

			    'fill' => array(

		            'type' => PHPExcel_Style_Fill::FILL_SOLID,

			        'color' => array('rgb' => '572878'),

		        )

		    );


			$objWorkSheet->getStyle('A1:'.PHPExcel_Cell::stringFromColumnIndex($index).'1')->applyFromArray($styleArray);
			$numRow = 2;
			$objWorkSheet->getColumnDimension('A')->setWidth(100);

			$dataOld = getDataOld($save);

			if( count($translates) ){
				foreach ($translates as $key => $v) {

					if( isset($dataOld[$key]) ){
						$dataOld[$key] = array_merge($dataOld[$key],$v);
					}
				}
			}

			$tranCache = [];
			foreach ($trans as $key => $row) {
				$objWorkSheet->setCellValue('A'.$numRow, $key);
				$index = 0;

				foreach ($langs as $key2 => $value2) {

					$objWorkSheet->setCellValueByColumnAndRow($index + 1, $numRow, @$dataOld[$key2][$key]);

					$tranCache[$key2][$key] = isset($dataOld[$key2][$key]) && $dataOld[$key2][$key] ? $dataOld[$key2][$key] : $key;

					$index++;

				}
				$numRow++;

				$objWorkSheet->getRowDimension(($numRow - 1))->setRowHeight(-1);
			}
			foreach ($tranCache as $key => $value) {

				if( $type === 'theme' ){

					Cache::forever('trans_theme_'.$key, $value );

				}
				if( $type === 'default' ){

					Cache::forever('trans_framework_'.$key, $value );

				}

			}

			foreach ($tranCache as $key => $value) {

				$file = fopen($dir_save.'/'.$key.'.csv',"w");

				fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
				fputcsv($file,['','']);
				foreach ($value as $key_tran => $tran)
				{
					$string = [$key_tran,$tran];
					fputcsv($file,$string);
				}

				fclose($file);

			}

			$objWorkSheet->getStyle('A1:B'.($numRow - 1))

			    ->getAlignment()

			    ->setWrapText(true);

			$objWorkSheet->freezePaneByColumnAndRow(1,2);
			$objWorkSheet->setTitle('Trans');

			PHPExcel_IOFactory::createWriter($excel, 'Excel2007')->save(cms_path('resource',$save));

		}

		if( $controller === 'translate' ){
			saveDataTrans('views/themes/'.theme_name(),'views/themes/'.theme_name().'/lang/trans.xlsx','theme', $data);
			return true;
		}else{
			saveDataTrans(['views/admin/themes/default','../app','../cms'],'lang/trans.xlsx');

			saveDataTrans('views/themes/'.theme_name(),'views/themes/'.theme_name().'/lang/trans.xlsx','theme');

			$listPlugin = plugins();

			foreach ($listPlugin as $value) {

				saveDataTrans('views/plugins/'.$value->key_word,'views/plugins/'.$value->key_word.'/lang/trans.xlsx','plugin');

			}

			vn4_create_session_message( __('Success'), __('Refesh Language Success'), 'success', true );

			return redirect()->back();
		}

	}
];
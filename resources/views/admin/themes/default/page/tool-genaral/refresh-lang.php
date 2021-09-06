<?php
dd(1);
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
				$info['children'] = getDataDir($info['dirname'].'/'.$value,$regex,$result);
			}elseif( $info['extension'] === 'php' ) {
				$str = file_get_contents($info['dirname'].'/'.$value);
				preg_match_all($regex, $str, $match);

				$list_key = [];

				foreach ($match[0] as $key2 => $value2) {
					$list_key[$value2][] = 1;
					$match['line'][$key2] = getLineWithString($info['dirname'].'/'.$info['basename'],$value2,count($list_key[$value2]));
				}

				$match['file'] = $info['dirname'].'/'.$info['basename'];
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
		$regex = "/__p\('(.*?)'\)|__p\(\"(.*?)\"\)/";
	}elseif( $type === 'theme' ){
		$regex = "/__t\('(.*?)'\)|__t\(\"(.*?)\"\)/";
	}

	$data = getDataDir($dir,$regex,$result);

	$trans = [];
	// dd($data);
	foreach ($result as $key => $value) {
		foreach ($value[0] as $key2 => $value2) {



			if( $value[1][$key2] ){
				if( !isset( $trans[$value[1][$key2]] ) ){
					$trans[$value[1][$key2]] = [ 'info' => [] ];
				}

				$trans[$value[1][$key2]]['info'][] = [ 'line'=>$value['line'][$key2],'file'=> $value['file'] ];


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

function saveDataTrans( $dir, $save, $type = 'default' ){

	$trans = getDataTrans( cms_path('resource',$dir), $type );

	require_once "lib/phpexcel/PHPExcel.php";

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
	$objWorkSheet->setCellValue('B1', 'en');

	$numRow = 2;

	$objWorkSheet->getColumnDimension('A')->setWidth(100);
	$objWorkSheet->getColumnDimension('B')->setWidth(100);



	foreach ($trans as $key => $row) {

		$objWorkSheet->setCellValue('A'.$numRow, $key)
	           ->setCellValue('B'.$numRow, $key);
		$numRow++;

		

		$objWorkSheet->getRowDimension($numRow)->setRowHeight(-1);

	}

	$objWorkSheet->getStyle('A1:B'.$numRow)
	    ->getAlignment()
	    ->setWrapText(true);

	$objWorkSheet->setTitle('Trans');

	PHPExcel_IOFactory::createWriter($excel, 'Excel2007')->save(cms_path('resource',$save));
}

saveDataTrans('views/admin/themes/default','lang/trans.xlsx');
saveDataTrans('views/admin/themes/default','lang/trans_theme.xlsx','theme');
saveDataTrans('views/admin/themes/default','lang/trans_plugin.xlsx','plugin');


saveDataTrans('views/themes/'.theme_name(),'views/themes/'.theme_name().'/lang/trans.xlsx');
saveDataTrans('views/themes/'.theme_name(),'views/themes/'.theme_name().'/lang/trans_theme.xlsx','theme');
saveDataTrans('views/themes/'.theme_name(),'views/themes/'.theme_name().'/lang/trans_plugin.xlsx','plugin');

dd(1);



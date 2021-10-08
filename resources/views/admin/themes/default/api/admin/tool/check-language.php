<?php

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

            }else{

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
    $regex = "/__\('(.*?)'\)|__\(\"(.*?)\"\)|__\('(.*?)',|__\(\"(.*?)\",/";
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

            }elseif( $value[3][$key2] ){

                if( !isset( $trans[$value[3][$key2]] ) ){

                    $trans[$value[3][$key2]] = [ 'info' => [] ];

                }
                $trans[$value[3][$key2]]['info'][] = [ 'line'=>$value['line'][$key2],'file'=> $value['file'] ];

            }elseif( $value[4][$key2] ){

                if( !isset( $trans[$value[4][$key2]] ) ){

                    $trans[$value[4][$key2]] = [ 'info' => [] ];

                }
                $trans[$value[4][$key2]]['info'][] = [ 'line'=>$value['line'][$key2],'file'=> $value['file'] ];

            }

        }

    }
    
    return $trans;
}

function getDataOld( $file ){
    
    $inputFileName = cms_path('root',$file);
    try {

        $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
        $objReader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);

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

        if( !$dataCell[0][0] ){
            break;
        }

        foreach ($keysData as $key => $value) {
            $rowData[$value][$dataCell[0][0]] = $dataCell[0][$key + 1];
        }

    }
    return $rowData;

}

function saveDataTrans( $dir, $save, $type = 'default', $translates = [], $langs ){

    $dir_save = dirname(cms_path('root',$save));


    if( !file_exists($dir_save) ){
        mkdir( $dir_save , 0777, true);
    } 

    if( is_string($dir) ){

        $dir = [$dir];

    }
    $trans = [];

    foreach ($dir as $key => $folder) {
        $trans = array_merge($trans,getDataTrans( cms_path('root',$folder), $type ));
    }

    
    $excel = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

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
                // 'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            )
        );
        $excel->getActiveSheet()->getStyle("A".$start.":A".($numRow - 1))->applyFromArray($style);
        $excel->getActiveSheet()->getColumnDimension(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(1))->setWidth(60);

        $styleArray = array(

          'borders' => array(

            'allborders' => array(

              'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN

            )

          )

        );
        $excel->getActiveSheet()->getStyle("A".$start.":B".($numRow - 1))->applyFromArray($styleArray);

        unset($styleArray);
    }

    $objWorkSheet = $excel->createSheet(1);
    $objWorkSheet->setCellValue('A1', 'Key');

    $index = 1;

    foreach ($langs as  $value) {

        $objWorkSheet->setCellValueByColumnAndRow($index + 1, 1, $value['label'].'('.$value['code'].')');

        $objWorkSheet->getColumnDimension(\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index + 1))->setWidth(60);

        $index++;

    }
    $styleArray = array(
        'font'  => array(
            'bold'  => true,
            'color' => array('rgb' => 'ffffff'),
            'size'  => 14,
        ),
        'fill' => array(
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'color' => array('rgb' => '572878'),
        )
    );

    $objWorkSheet->getStyle('A1:'.\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index).'1')->applyFromArray($styleArray);
    $numRow = 2;
    $objWorkSheet->getColumnDimension('A')->setWidth(60);

    $dataOld = getDataOld($save);

    if( count($translates) ){
        foreach ($translates as $key => $v) {
            foreach( $v as $tranKey => $tran ){
                if( !isset($dataOld[$key][$tranKey]) || !$dataOld[$key][$tranKey] ){
                    $dataOld[$key][$tranKey] = $tran;
                }
            }
        }
    }

    $tranCache = [];

    $countTranslated = 0;
    $countNotTranslated = 0;

    foreach ($trans as $key => $row) {
        $objWorkSheet->setCellValue('A'.$numRow, $key);
        $index = 1;

        foreach ($langs as $lang) {


            if( isset($dataOld[$lang['code']][$key]) && $dataOld[$lang['code']][$key] ){
                $objWorkSheet->setCellValueByColumnAndRow($index + 1, $numRow, $dataOld[$lang['code']][$key] );
                $tranCache[$lang['code']][$key] = $dataOld[$lang['code']][$key];
                $countTranslated++;
            }else{
                
                $styleArray = array(
                    'fill' => array(
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color' => array('rgb' => 'ffcc00'),
                    )
                );
                $tranCache[$lang['code']][$key] = $key;
                $objWorkSheet->getCellByColumnAndRow($index + 1, $numRow)->getStyle()->applyFromArray($styleArray);
                $countNotTranslated++;
            }

            $index++;

        }
        $numRow++;
        // $objWorkSheet->getRowDimension(($numRow - 1))->setRowHeight(-1);
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
        file_put_contents( $dir_save.'/'.$key.'.json', json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    $objWorkSheet->getStyle('A1:'.\PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($index).($numRow - 1))->getAlignment()->setWrapText(true);
    
    $objWorkSheet->freezePaneByColumnAndRow(2,2);
    $objWorkSheet->setTitle('Trans');

    \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($excel, 'Xlsx')->save(cms_path('root',$save));

}

// capital_letters('vn4cms-ecomer')

if( file_exists($file = cms_path('root','src/utils/i18n/trans.xlsx' ) ) && !is_writable( $file ) ){
    return [
        'message'=>apiMessage('Can\'t write file utils/i18n/trans.xlsx, please check permission','error'),
        'error'=>true
    ];
}

$languages = $r->get('languages');

$translatesFile = scandir(cms_path('root','src/utils/i18n'));

$translates = [];

// foreach( $translatesFile as $file ){
//     if( $file[0] !== '.' ){

//         $contentTemp = json_decode( file_get_contents($filePath = cms_path('root', 'src/utils/i18n/'.$file) ),true);


//         if( $contentTemp ){
//             $pathinfo = pathinfo($filePath);
//             $translates[$pathinfo['filename']] = $contentTemp;
//         }
//     }
// }



saveDataTrans( 'src' ,'src/utils/i18n/trans.xlsx',null,$translates, $languages);


$pluginFolder = glob(  cms_path('root','src/plugins/*') );

foreach( $pluginFolder as $pathPlugin ){

    $pathinfo = pathinfo($pathPlugin);

    saveDataTrans( 'src' ,'src/plugins/'.$pathinfo['basename'].'/i18n/trans.xlsx','plugin',[], $languages);

}

return [
    'message'=>apiMessage('Language check successful.'),
    'success'=>true
];
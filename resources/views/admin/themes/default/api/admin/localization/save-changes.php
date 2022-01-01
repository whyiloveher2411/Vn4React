<?php
include __DIR__.'/../tool/_helper.php';

$data = $r->get('data');

if( $data && !empty($data) ){
    
    $translates = [];

    foreach( $data as $transText => $languagesData){

        foreach( $languagesData as $langCode => $value){

            if( !isset($translates[$langCode]) ){
                $translates[$langCode] = [];
            } 

            $translates[$langCode][$transText] = $value;
        }
    }

    $languages = $r->get('languages');

    saveDataTrans( 'src' ,'src/utils/i18n/trans.xlsx',null,$translates, $languages);

    $data = getDataOld('src/utils/i18n/trans.xlsx');

    return [
        'trans'=>$data,
        'error'=>0,
        'message'=>apiMessage('Save changes successfully')
    ];

}

return [
    'error'=>1,
    'message'=>apiMessage('Couldn\'t find any data to change','error'),
];
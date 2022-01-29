<?php
include __DIR__.'/_helper.php';


if( file_exists($file = cms_path('root','src/utils/i18n/trans.xlsx' ) ) && !is_writable( $file ) ){
    return [
        'message'=>apiMessage('Can\'t write file utils/i18n/trans.xlsx, please check permission','error'),
        'error'=>true
    ];
}

$languages = $r->get('languages');

if( !$languages ){
    return [
        'message'=>apiMessage('Please provide a list of languages for rendering','error')
    ];  
}

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

    saveDataTrans( 'src/plugins/'.$pathinfo['basename'] ,'src/plugins/'.$pathinfo['basename'].'/i18n/trans.xlsx','plugin',[], $languages);

}

return [
    'message'=>apiMessage('Language check successful.'),
    'success'=>true
];
@extends(backend_theme('master'))

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



  title_head( __('Translate') );

  $languages = languages();

  $translates = [];

  $list_key = [];

  $translates = [];

  $dataExcel = getDataOld('views/themes/'.theme_name().'/lang/trans.xlsx');

 foreach ($languages as $key => $lang) {
    $list_key += $dataExcel[$key];
 }

 ?>
 @section('css')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">
  <style type="text/css">
    .dataTables_wrapper input[type="search"], .dataTables_wrapper select{
      height: 30px;
      padding: 5px 10px;
      font-size: 12px;
      line-height: 1.5;
      border: 1px solid #dedede;
      box-shadow: none;
    }
  </style>
 @stop
@section('content')
  
  <div style="max-width: 1000px;margin: 0 auto;">
  <table class="table-responsive table table-striped table-bordered quan-table">
    <thead>
      <tr>
        <th>STT</th>
        <th style="width: 250px;">Key</th>
        @foreach($languages as $key => $lang)
        <th><img src="{!!plugin_asset($plugin,'flags/'.$lang['flag'].'.png')!!}"> {!!$lang['lang_name'],' ('.$key.')'!!}</th>
        @endforeach
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php $index = 1; ?>
      @foreach($list_key as $key => $v )
        <tr>
          <td>{!!$index++!!}</td>
          <td class="key">{{$key}}</td>
          @foreach($languages as $lang_key => $lang)
          <td>
              <input class="form-control tran key_{!!$lang_key!!}" type="" name="{!!$lang_key!!}" value="{{$dataExcel[$lang_key][$key]}}">
          </td>
          @endforeach
          <td><button type="button" class="vn4-btn vn4-btn-blue save_lanaguage">@__('Save Change')</button></td>
        </tr>
      @endforeach
    </tbody>
  </table>
  </div>


@stop


@section('js')
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">

  $(window).load(function(){
    $('.quan-table').DataTable({
      "stateSave": true,
      "columnDefs": [
        {sWidth: '45px',"orderable": false, "targets": 4 },
        {sWidth: '45px', "targets": 0 },
      ],
      "stateSaveCallback": function (settings, data) {
        window.localStorage.setItem("datatable", JSON.stringify(data));
      },
      "stateLoadCallback": function (settings) {
        var data = JSON.parse(window.localStorage.getItem("datatable"));
        if (data) data.start = 0;
        return data;
      }
    });

  });

  $(document).on('change','.tran',function() {
      $(this).css({border:'1px solid red'});
  });


  $('.save_lanaguage').click(function(){

      let data = {'key':'','translates':{}}, $this = $(this);

      data['key'] = $(this).closest('tr').find('.key').text();

     $this.closest('tr').find('.tran').each(function(index,el){
        data['translates'][$(el).attr('name')] = $(el).val();
     });

     console.log(data);

      vn4_ajax({

        data:data,
        show_loading: 'Save Change',
        callback: function( result ){
          if( result.success ){
            $this.closest('tr').find('.tran').css({border:'1px solid #dedede'});
            show_message({title:'@__('Success.')',content: '@__('Update Translate Success.')',color:'#29B87E',icon:'fa-check-circle'});
          }
        },
        error_callback:function(){
            show_message({title:'@__('Error.')',content: '@__('Update Translate fail.')',color:'#CA2121',icon:'fa-times-circle'});
        }
      });
      // $.ajax({
      //   type:'POST',
      //   dataType:'Json',
      //   data:{
      //     _token: '{!!csrf_token()!!}',
      //     key: key,
      //     key_en: key_en,
      //     key_vi: key_vi
      //   },
      //   success:function(result){
      //     if( result.success ){
      //       alert('Success');
      //     }
      //   }
      // });
  });
</script>
@stop
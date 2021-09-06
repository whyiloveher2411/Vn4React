<?php
add_action('vn4_head',function(){
?>
  <style type="text/css">
      .stack {
            color: #9c9c9c;
      }
      .texct
      .date {
        min-width: 75px;
      }

      .text {
        word-break: break-all;
      }

      a.llv-active {
        z-index: 2;
        background-color: #f5f5f5;
        border-color: #777;
      }

      .list-group-item {
        word-wrap: break-word;
      }

  </style>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">
<?php
})
?>

 <div class="container-fluid">
  <div class="row">
    <div class="col sidebar col-md-2">
      <div class="list-group">
        @foreach($files as $file)
          <a href="?vn4-tab-top-profile=history&l={{ \Illuminate\Support\Facades\Crypt::encrypt($file) }}"
             class="list-group-item @if ($current_file == $file) llv-active @endif">
            {{$file}}
          </a>
        @endforeach
      </div>
    </div>
    <div class="col-md-10 table-container">

      <div class="p-3">
        @if($current_file)
          <a id="delete-log" href="?del={{ \Illuminate\Support\Facades\Crypt::encrypt($current_file) }}"><span
                class="fa fa-trash"></span> Delete file</a>
          @if(count($files) > 1)
            -
            <a id="delete-all-log" href="?delall=true"><span class="fa fa-trash"></span> Delete all files</a>
          @endif
        @endif
      </div>
      
      @if ($logs === null)
        <div>
          Log file >50M, please download it.
        </div>
      @else
        <table id="table-log" class="table table-striped">
          <thead>
          <tr>
            <th>&nbsp;&nbsp;Level&nbsp;&nbsp;</th>
            <th>&nbsp;&nbsp;Context&nbsp;&nbsp;</th>
            <th>&nbsp;&nbsp;Date&nbsp;&nbsp;</th>
            <th>Content</th>
          </tr>
          </thead>
          <tbody>

          @foreach($logs as $key => $log)
            <tr data-display="stack{{{$key}}}">
              <td class="text-{{{$log['level_class']}}}"><span class="fa fa-{{{$log['level_img']}}}"
                                                               aria-hidden="true"></span> &nbsp;{{$log['level']}}</td>
              <td class="text">{{$log['context']}}</td>
              <td class="date">{{{$log['date']}}}</td>
              <td class="text">
                @if ($log['stack']) <button type="button" style="display:none;" class="float-right expand btn btn-outline-dark btn-sm mb-2 ml-2"
                                       data-display="stack{{{$key}}}"><span
                      class="fa fa-search"></span></button>@endif
                {{{$log['text']}}}
                @if (isset($log['in_file'])) <br/>{{{$log['in_file']}}}@endif
                @if ($log['stack'])
                  <div class="stack" id="stack{{{$key}}}"
                       style="display: none; white-space: pre-wrap;">{{{ trim($log['stack']) }}}
                  </div>@endif
              </td>
            </tr>
          @endforeach

          </tbody>
        </table>
      @endif
      
    </div>
  </div>
</div>

<?php 
  add_action('vn4_footer',function(){
?>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script>
  $(document).ready(function () {
    $('.table-container tr').on('click', function () {
      $('#' + $(this).data('display')).toggle();
    });
    $('#table-log').DataTable({
      "order": [2, 'desc'],
      "stateSave": true,
      "stateSaveCallback": function (settings, data) {
        window.localStorage.setItem("datatable", JSON.stringify(data));
      },
      "stateLoadCallback": function (settings) {
        var data = JSON.parse(window.localStorage.getItem("datatable"));
        if (data) data.start = 0;
        return data;
      }
    });
    $(document).on('click','#delete-log, #delete-all-log',function () {
      return confirm('Are you sure?');
    });
  });
</script>
<?php
})
?>
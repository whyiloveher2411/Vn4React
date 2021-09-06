                
@extends(backend_theme('master'))

@section('content')

<?php

  title_head(__('Tools')); 
  add_action('vn4_head',function(){
    ?>
      <style>
        .form-setting .control-label{
            text-align: left;
        }
        .default_input_img_result img{
          max-width: 200px;
        }

      </style>
    <?php
  });
 ?>
<div class="">
    <div class="row">
      <div class="col-xs-12">
        <div class="col-md-8">
          
          <div class="x_panel" id="tool-check-db">
            <div class="x_title">
              <h2>@__('Render Model')</h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <p class="note">@__('Creat Entity Realtionships')</p><br>
              <a class="vn4-btn vn4-btn-blue open-loading" href="?action=check-database"><i class="fa fa-cubes" aria-hidden="true"></i> @__('Render')</a>
            </div>
          </div>

          <div class="x_panel" id="tool-check-db">
            <div class="x_title">
              <h2>@__('Check Database')</h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <p class="note">@__('When you create a new post type but you do not have time to optimize the DB as well as check if the database is already on the floor')</p><br>
              <a class="vn4-btn vn4-btn-blue open-loading" href="?action=check-database"><i class="fa fa-check" aria-hidden="true"></i> @__('Check')</a>
            </div>
          </div>

          <div class="x_panel" id="tool-check-db">
            <div class="x_title">
              <h2>@__('Backup Database')</h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <p class="note">Backup Database (json + sql)</p><br>
              <a class="vn4-btn vn4-btn-blue" href="?action=backup-database"><i class="fa fa-download" aria-hidden="true"></i> @__('Backup')</a>
            </div>
          </div>

          <div class="x_panel" id="tool-copy-all-asset">
            <div class="x_title">
              <h2>@__('Deploy Asset')</h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <p class="note">@__('This tool will save you the time of copying all of the assets from the plugin, theme to the public source code')</p><br>
              <a class="vn4-btn vn4-btn-blue open-loading" href="?action=develop-asset"><i class="fa fa-files-o" aria-hidden="true"></i>  @__('Copy Asset')</a>
            </div>
          </div>

          

          <div class="x_panel" id="tool-check-db">
            <div class="x_title">
              <h2>@__('Minify HTML View')</h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <p class="note">@__('Minify HTML View')</p><br>
              <a class="vn4-btn vn4-btn-blue open-loading" href="?action=minify-html"><i class="fa fa-check" aria-hidden="true"></i> @__('Minify')</a>
            </div>
          </div>


          <div class="x_panel" id="tool-check-db">
            <div class="x_title">
              <h2>@__('Refresh views')</h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <p class="note">@__('Refresh views')</p><br>
              <a class="vn4-btn vn4-btn-blue open-loading" href="?action=refresh-views"><i class="fa fa-trash" aria-hidden="true"></i> @__('Refresh')</a>
            </div>
          </div>

          <div class="x_panel" id="tool-check-db">
            <div class="x_title">
              <h2>@__('Clear Cache')</h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <p class="note">@__('Clear all cache of framework')</p><br>
              <a class="vn4-btn vn4-btn-blue open-loading" href="?action=clear-cache"><i class="fa fa-trash" aria-hidden="true"></i> @__('Clear')</a>
            </div>
          </div>

          <div class="x_panel" id="tool-copy-all-asset">
            <div class="x_title">
              <h2>@__('Validate HTML')</h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">

              <form method="POST">

                <input type="hidden" name="_token" value="{!!csrf_token()!!}">
                <p class="note">Validate HTML</p><br>

                <div class="form-group">
                    <label for="validate-html" > HTML Code
                    </label>
                    <textarea name="code"  value="" id="validate-html" placeholder="" type="text" class="form-control" rows="6"></textarea>
                  </div>
                  <input type="submit" name="validate-html" value="@__('Create')" class="open-loading vn4-btn vn4-btn-blue">
                </form>
            </div>
          </div>


          <?php 
              do_action('vn4_register_tool');
           ?>
        </div>
        
      </div>
    </div>
</div>
@stop

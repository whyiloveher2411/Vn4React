<?php
class Vn4Widget{

	private $id = '';
	private $name = '';
	private $description = '';

	private $fields = [];
	private $data = [];

	protected $instance = array();

	private $args_construct = '';


	public function __construct($id, $name, array $args = null ){

		$this->id = $id;

		$this->name = $name;

		$this->args_construct = $args;

		if( !isset($args['fields']['title']) ){
			$args['fields'] = array_merge(['title'=>['title'=>'Title','view'=>'text']],$args['fields']);
		}

		$this->fields = $args['fields'];

		$this->data = $args['data'];

		if( isset($args['description']) ){
			$this->description = $args['description'];
		}

		if( isset($args['instance']) && is_array($args['instance']) ){
			$this->instance = $args['instance'];
		}

	}

	public function get_data($name, $defaul = null ){
		return $this->data[$name]??$defaul;
	}

	public function show( ){

		foreach ($this->fields as $key => $field) {
			?>
			 <label class="input-widget-item"><?php echo $field['title']; ?>
			 	<?php 
			 		if( !isset($field['view']) ) $field['view'] = 'text';
			 		$field['key'] = $key.str_random();
			 		$field['name'] = $key;
			 		$field['value'] = $this->get_data($key);
			 		echo get_field($field['view'],$field);
			 	 ?>
              </label>
			<?php
		}
	}

	public static function update($input){

	}

	public function widget(){
		
	}

	public static function WidgetStatic($class_name, array $widget_instance = array()){

		if( class_exists ($class_name) ){

			$widget = new $class_name();

			$widget->update_instance($widget_instance);

			$widget->widget();

        }
	}

	public function form_widget_html_left(){
		?>
		<div class="col-xs-12 col-md-6 widget-item-warpper  widget-<?php echo $this->id ; ?>" id="widget-id-<?php echo $this->id; ?>">
          
          	<div class="x_panel widget-item">
          		<form method="POST">
          			<input type="text"  hidden name="key" value="<?php echo $this->id ?>">
		            <div class="x_title widget-handle">
		              <h2>
		                  <?php echo $this->name; ?>
		              </h2>
		              <ul class="nav navbar-right panel_toolbox">
		                 <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
		                </li>
		              </ul>
		              <div class="clearfix"></div>
		            </div>
		            <div class="x_content">
		              	
		              	<div class="widget-inside">
		                    <?php $this->show(); ?>
		                </div>

		                <p class="action-widget"><span><a href="#" class="delete-widget-added"><?php echo __('Remove') ?></a> | <a class="close-widget-added" href="#"><?php echo __('Close') ?></a></span>
		               	<button type="submit" class="vn4-btn vn4-btn-blue pull-right btn-save-widget" name="status" value="publish"><?php echo __('Save changes') ?></button>
	           			</p>
		            </div>
          		</form>
          	</div>

          <p class="description-widget"><?php echo $this->description; ?></p>

          <div class="widgets-chooser-item"></div>
        </div>

        <?php

	}

	public function update_instance($input){
		$this->instance = $input;
	}

	public function form_widget_html_right(){
		?>
			<div class="x_panel widget-item">
          		<form method="POST">
          			<input type="text" hidden name="key" value="<?php echo $this->id ?>">
		            <div class="x_title widget-handle">
		              <h2>
		                  <?php echo $this->name; ?>
		              </h2>
		              <ul class="nav navbar-right panel_toolbox">
		                 <li><a class="collapse-link"><i class="fa fa-chevron-down"></i></a>
		                </li>
		              </ul>
		              <div class="clearfix"></div>
		            </div>
		            <div class="x_content">
		              	
		              	<div class="widget-inside">
		                    <?php $this->show(); ?>
		                </div>

		                <p class="action-widget"><span><a href="#" class="delete-widget-added"><?php echo __('Remove') ?></a> | <a class="close-widget-added" href="#"><?php echo __('Close') ?></a></span>
		               <button type="submit" class="vn4-btn vn4-btn-blue pull-right btn-save-widget" name="status" value="publish"><?php echo __('Save changes') ?></button>
		           		</p>
		            </div>
          		</form>
          	</div>
		<?php
	}

	protected function get_field_value($name){

		if( isset($this->instance[$name]) ){
			return $this->instance[$name];
		}

		return null;

	}
}

 $list_widgets = 
 [
  'text-html'=>[
      'title'=>'Text Html',
      'description'=>__('Text or HTML'),
      'fields'=>[
        'title'=>[
            'title'=>'Title',
            'view'=>'text'
        ],
        'content'=>[
            'title'=>'Content',
            'view'=>'textarea'
        ]
      ],
  ]
];


include cms_path('public','../cms/frontend.php'); 

$plugins = plugins();

foreach ($plugins as $plugin) {

  if( file_exists($file = cms_path('resource','views/plugins/'.$plugin->key_word.'/inc/appearance.php')) ){
    include $file;
  }

}

$theme_name = theme_name();

if( file_exists($file = cms_path('resource','views/themes/'.$theme_name.'/inc/appearance.php')) ){
    include $file;
}

$list_widgets = apply_filter('list_widget',$list_widgets);

return $list_widgets;
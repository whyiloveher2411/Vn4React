<?php

	include cms_path('resource','views/plugins/'.$plugin->key_word.'/inc/variable.php');

	if( !function_exists('acfp_export_sub_fields') ){

		function acfp_export_sub_fields($array , $fieldTypeAttribute){
			foreach ($array as $key => $value) {

				if( !isset($value['field_type']) ){
					$field_type = isset($array[$key]['view']) ? $array[$key]['view']: 'text';
					$array[$key][ $field_type ] =  array_merge($fieldTypeAttribute[ $field_type ], $array[$key]);
					$array[$key]['field_type'] = $array[$key]['view'] = $field_type ;
					$array[$key]['field_name'] = $key;
					$array[$key]['field_required'] = 1 ;
					$array[$key]['field_instructions'] = '' ;
				}
				

				if( $array[$key]['field_type'] === 'repeater' ){
					$array[$key]['sub_fields'] =  acfp_export_sub_fields($array[$key]['sub_fields'], $fieldTypeAttribute );
				}else{

					$array[$key] = array_merge($array[$key],$array[$key][$array[$key]['field_type']]);

					if( $array[$key]['field_type'] === 'flexible' ){
						$array[$key]['templates'] = acfp_export_template_fixedble( $array[$key]['templates'], $fieldTypeAttribute );
					}
				}


			}

			return $array;
		}

		function acfp_export_template_fixedble($template, $fieldTypeAttribute){
			foreach ($template as $key => $value) {
				if( !isset($value['items']) ) dd($value);
				foreach ($value['items'] as $key2 => $value2) {

					if( !isset($template[$key]['items'][$key2]['field_type']) ){
						$field_type = isset($template[$key]['items'][$key2]['view']) ? $template[$key]['items'][$key2]['view']: 'text';
						$template[$key]['items'][$key2][ $field_type ] =  array_merge($fieldTypeAttribute[ $field_type ], $template[$key]['items'][$key2]);
						$template[$key]['items'][$key2]['field_type'] = $template[$key]['items'][$key2]['view'] = $field_type ;
						$template[$key]['items'][$key2]['field_name'] = $key2;
						$template[$key]['items'][$key2]['field_required'] = 1 ;
						$template[$key]['items'][$key2]['field_instructions'] = '' ;
					}

					if( $template[$key]['items'][$key2]['field_type'] === 'repeater' ){
						$template[$key]['items'][$key2]['sub_fields'] =  acfp_export_sub_fields( $template[$key]['items'][$key2]['sub_fields'],  $fieldTypeAttribute );
					}else{
						if( $template[$key]['items'][$key2]['field_type'] === 'flexible' ){
							$template[$key]['items'][$key2]['templates'] = acfp_export_template_fixedble( $template[$key]['items'][$key2]['templates'], $fieldTypeAttribute );
						}

						$template[$key]['items'][$key2] = array_merge($template[$key]['items'][$key2], $template[$key]['items'][$key2][$template[$key]['items'][$key2]['field_type']]);
					}
				}
			}

			return $template;
		}
	}

	$param['sub_fields'] = acfp_export_sub_fields( $param['sub_fields'], $fieldTypeAttribute );

?>

{!!get_field('repeater',$param, $param['post'])!!}
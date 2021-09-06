<?php
namespace CMS\Widget\Model;

use Cache;

class Widget
{
    public static function all(){

        return Cache::rememberForever('widgets', function(){

            $widgets = [];

            $plugins = plugins();

            foreach( $plugins as $keyWord => $plugin){
                
                $infoPlugin = json_decode( file_get_contents( cms_path('resource','views/plugins/'.$keyWord.'/info.json') ),true);

                if( file_exists($pluginWidgetsPath = cms_path('resource','views/plugins/'.$keyWord.'/inc/widget.php')) ){

                    $widgetPlugin = include $pluginWidgetsPath;
                    if( is_array($widgetPlugin) ){
                        foreach( $widgetPlugin as $key => $widget ){
                            $widget['title'] = $widget['title'].' (Plugin '.$infoPlugin['name'].')';
                            $widgets['plugin_'.$keyWord.'_'.$key] = $widget;
                        }
                    }
                }
            }

            $theme_name = theme_name();

            $infoTheme = json_decode( file_get_contents( cms_path('resource','views/themes/'.$theme_name.'/info.json') ),true);

            if( file_exists($themeWidgetsPath = cms_path('resource','views/themes/'.$theme_name.'/inc/widget.php')) ){

                $widgetTheme = include $themeWidgetsPath;

                foreach( $widgetTheme as $key => $widget ){
                    $widget['title'] = $widget['title'].' (Theme '.$infoTheme['name'].')';
                    $widgets['theme_'.$key] = $widget;
                }
            }

            return $widgets;

        });
    }
}
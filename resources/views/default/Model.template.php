<?php namespace App\Model;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
[Use]

class [ModelName] extends Eloquent{

	protected $table = '[TableName]';

	private $object_type = '[ObjectType]'; 

	public $timestamps = true;


 	public function __get($name){

        $argNotIn = ['updated_at'=>'updated_at','created_at'=>'created_at','id'=>'id',Vn4Model::$id=>'id'];

        if( isset($argNotIn[$name]) ) {
            return parent::__get($argNotIn[$name]);
        }

        if( !isset($this->attributes[$name]) ){

            $result = do_action('__Vn4Model_function__get',null, $this, $name);

            if( $result ) return $result;

            return null;
        }

        return $this->attributes[$name];
    }

    public function getMeta($key = null , $default = null){

        if( !isset($this->attributes['meta']) ) return $default;
        
        $meta = json_decode($this->attributes['meta'], true);

        if( !$key ){
            
            if( !is_array( $meta ) ) return $default;

            return $meta;
        } 
        
        if( is_string($key) ){
            
            if( isset($meta[$key]) && $meta[$key] ){
                return $meta[$key];
            }   

            return $default;

        }elseif( is_array($key) ){

            $result = [];
            foreach ($key as $k) {

                if( isset($meta[$k]) ){
                    $result[$k] = $meta[$k];
                }else{
                    $result[$k] = null;
                }  

            }

            return $result;

        }

        return $default;
    }

    public function updateMeta( $key , $value = null){

        $meta = json_decode($this->meta,true); 

        if( !is_array($meta) ){
            $meta = [];
        }


        if( is_array($key) ){

            $meta = array_merge ($meta, $key);

        }elseif(is_string($key) && $value !== null){

            if ( is_array($value) ){
                $meta[$key] = json_encode($value);
            }else{
                $meta[$key] = $value;
            }

        }

        $this->meta = json_encode($meta);

        $this->save();

        return $this;

    }


	public static function getPosts( $parameters = [] ){

        extract( shortcode_atts([
                'count'=>10,
                'order'=>array('created_at','desc'),
                'paginate'=>null,
                'callback'=>null,
                'select'=>'*',
                'with'=>null,
                ], $parameters) );

        if( $paginate ){

            $page = request()->get($paginate);

            if( $page === null ) $page = 1;
            \Illuminate\Pagination\Paginator::currentPageResolver(function() use ($page){
                return $page;
            });

        }


        $posts = (new [ModelName]())->where('type','[ObjectType]')->where('status','publish')->where('visibility','!=','private')->where(function($q){
            return $q->where('post_date_gmt','<=',time())->orWhereNull('post_date_gmt');
        });

       
        if( !is_admin() ){
            $posts->where(function($q){
                return $q->where('is_homepage',0)->orWhereNull('is_homepage');
            });
        }

        $posts = do_action('get_posts', $posts, '[ObjectType]');

        if( is_array($callback) ){

            foreach ($callback as $c) {
                $posts = call_user_func_array($c,[$posts]);
            }

        }elseif(is_callable ($callback) ){
            $posts = call_user_func_array($callback,[$posts]);
        }
        

        if( is_callable($order) ){
            $posts = call_user_func_array($order,[$posts]);
        }else{
            $posts = $posts->orderBy($order[0],$order[1]);
        }

        if( $select ){
            $posts = $posts->select($select);
        }

        
        if( $count === true ){
            $posts = $posts->count();
        }else{
            if( $paginate ){
                $posts = $posts->paginate($count);
                $posts = $posts->setPageName( $paginate );
                $posts->pageName_custom = $paginate;

            }else{
                $posts = $posts->take($count)->get();
            }
        }

        

        if( $with ){
            $posts = self::withRelationships($posts, $with, $admin_object, '[ObjectType]');
        }

        return $posts;
    }

	[Relationship]

}
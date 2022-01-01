<?php namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;
// use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Auth;
use File;
use DB;
use Cache;
use Validator;

class Vn4Model extends Eloquent{

    // protected $connection = 'mongodb';

    public static $id = 'id';
    
    private static $table_static = 'table_name';

    private static $arg = [];

    public static $tablename = '';
    
    protected $dates = array('created_at','updated_at');

    public $relations = [];

    public function __construct( $tablename = null ){

        if(!$tablename){
            $this->table = self::$table_static;
        }else{
            $this->table = $tablename;
        }


    }

    public static function table($table){

        return new Vn4Model($table);

    }

    public function getTable(){

       if( $this->table !== 'table_name' ) return $this->table;
       if( $this->type ){
           return get_admin_object($this->type)['table'];
       }
      
       return self::$tablename;
    }

    public function remove(){
        if( $this->slug ){
            removeSlug($this->slug, $this->type, $this->id);
        }

        return $this->delete();
    }

    public function save(array $options = array(), $registerSlug = true ){

        if($this->getTableName() === 'table_name' || !$this->getTableName() ){

            switch ($this->type) {
                case 'setting':
                    $this->setTable(vn4_tbpf().'setting');
                    break;
                case 'plugin':
                     $this->setTable(vn4_tbpf().'plugin');
                    break;
                case 'menu':
                     $this->setTable(vn4_tbpf().'menu');
                    break;
                default:
                     $this->setTable(get_admin_object($this->type)['table']);
                    break;
            }

        }

        if( !$this->created_time ){
            $this->created_time = microtime(true);
        }

        $this->updated_time = microtime(true);

        $result = parent::save($options);

        // if( is_admin() ){

            if( isset($this->attributes['slug']) && $registerSlug ){
                $this->slug = registerSlug($this->slug,$this->type, $this->id, true);
                Cache::forget($this->type.'_'.$this->id);
                Cache::forget('getPostBySlug_'.$this->type.'##slug##'.$this->slug);
            }

            cache_tag('count_filter',$this->type, 'clear');

        // }

        return $result;

    }

    public function delete(array $options = array()){

        if( $this->slug ){
            Cache::forget($this->type.'##slug##'.$this->slug);
        }

        Cache::forget($this->type.'_'.$this->id);

        if($this->getTableName() == 'table_name' || !$this->getTableName() ){
            $this->setTable(get_admin_object($this->type)['table']);
        }

        cache_tag('count_filter',$this->type, 'clear');

        return parent::delete($options);

    }

    public static function firstOrAddnew( $table, array $attributes  ){

        $instance = new Vn4Model($table);

        if( empty($attributes) ){
            return $instance;
        }

        $instance = $instance->where($attributes)->first();

        if ( is_null($instance) ){

            $instance = new Vn4Model($table);

            foreach ($attributes as $key => $value) {
                $instance->{$key} = $value;
            }

        }

        $instance->setTable($table);

        return $instance;

    }

    public static function firstOrAddnewPostType( $type, array $attributes  ){

        $admin_object = get_admin_object($type);

        foreach ($attributes as $key => $value) {
            if( !isset($admin_object['fields'][$key]) ) unset($attributes[$key]);
        }

        $instance = new Vn4Model($admin_object['table']);

        $instance = $instance->where($attributes)->first();

        if ( is_null($instance) ){

            $instance = new Vn4Model($admin_object['table']);

            foreach ($attributes as $key => $value) {
                $instance->{$key} = $value;
            }

        }

        $instance->setTable($admin_object['table']);

        return $instance;

    }

    public static function newOrEdit($type, $param_find, $input, $taxonomy = null , $r = null){

        return DB::transaction(function () use ($type, $param_find, $input, $taxonomy, $r) {

            $admin_object = get_admin_object($type);

            $post = Vn4Model::firstOrAddnew($admin_object['table'],$param_find);
            $post->fillDynamic($input);

            $post->type = $type;


            if( $post->exists ){
                $action = 'edit';
            }else{
                $action = 'new';
            }

            if( !$post->status ) $post->status = 'publish';
            if( !$post->visibility ) $post->visibility = 'publish';
            if( !$post->status_old ) $post->status_old = 'publish';
            if( !$post->ip ) $post->ip = request()->ip();
            if( !$post->type ) $post->type = $type;

            if( isset($input['post_date_gmt']) && $input['post_date_gmt']){
                $post->post_date_gmt = $input['post_date_gmt'];
            }else{
                $post->post_date_gmt = null;
            }

            if( !$post->status_old ){
                $post->status_old = $post->status;
            }

            do_action('before_save_post',$post, $input);
            do_action('before_save_post_'.$post->type,$post, $input);

            if( $post->status == 'trash' ){
                $save = $post->save([],false);
            }else{
                $save = $post->save();
            }

            $data_log = ['type'=>$type];
            $message_log = '';
            $stacktrace_log = json_encode($input);

            if( Auth::user() ){
                $data_log['user_id'] = Auth::id();
            }

            if( !$save && is_callable('vn4_create_session_message') ){
                vn4_create_session_message( __('Error'), __('Can not save object'), 'error' , true );
                $message_log = 'Can not save object';
            }

            if ( is_array($taxonomy) && $post){
                vn4_create_taxonomy( $taxonomy , $post);
            } 

            do_action('saved_post',$post, $r, $admin_object);

            if( $action === 'edit' && is_callable('vn4_create_session_message') ){
                vn4_create_session_message( __('Sucess'), __('Update post success'), 'success' , true);
                $message_log = 'Update post ['.$post->type.'] success';
                $data_log['id'] = $post->id;
            }elseif(  is_callable('vn4_create_session_message') ){
                vn4_create_session_message( __('Sucess'), __('Create post success'), 'success' , true );
                $data_log['id'] = $post->id;
            }

            vn4_log($message_log, $data_log, $stacktrace_log);

            if( isset($admin_object['cache']) ){

                if( is_callable($admin_object['cache']) ){
                    $admin_object['cache']($post);
                }else{
                    if( is_array( $admin_object['cache'] ) ){
                        foreach ($admin_object['cache'] as $value) {

                            if( is_callable($value) ){
                                $value($post);
                            }else{
                                Cache::forget($value);
                            }
                        }
                    }else{
                        Cache::forget($admin_object['cache']);
                    }
                }
                
            }

            Cache::forget($post->type.'_'.$post->id);

            if( $post->slug ){
                Cache::forget('getPostBySlug_'.$post->type.'##slug##'.$post->slug);
            }

            return $post;
        });

    }

    public static function create($type, $find = [], $input){

        $admin_object = get_admin_object($type);

        if( !$admin_object ){
            return ['error'=>true,'error_code'=>1,'message'=>__('Post Type Not Found')];
        }

        $validation = [];
        $messages = [];

        foreach ($admin_object['fields'] as $k => $v) {

            if(  isset($v['validation']) ){

                $validates = [];

                foreach ($v['validation'] as $k2 => $v2) {
                    $validates[] = $k2;
                    $messages[$k.'.'.explode(':', $k2)[0]] = $v2;
                }

                $validation[$k] = implode('|', $validates);
            }
        }

        $validate = Validator::make( array_merge( $find, $input ), $validation, $messages );

        if( $validate->fails() ){

            $errors = $validate->errors();

            return ['error'=>$errors, 'error_code'=>2];
        }

        if( count($find) ){

            $post = Vn4Model::table($admin_object['table'])->where($find)->first();

            if( $post ){
                return ['error'=>true,'error_code'=>3,'message'=>__('This records is already exists.')];
            }

        }

        if( $post = Vn4Model::createPost($type, array_merge( $find, $input ), false) ){
            return ['error'=>false,'post'=>$post];
        }

        return ['error'=>true,'error_code'=>4];

    } 

    public static function createPost($type,$input, $dynamic = true){
        
        unset($input['_token']);

        $post = (new Vn4Model(get_admin_object($type)['table']));
        if( $dynamic ){
            $post->fillDynamic($input);
        }else{
            $obj_conf = get_admin_object($type);

            foreach ($input as $key => $value) {
                if( !isset($obj_conf['fields'][$key]) ){
                    unset($input[$key]);
                }
            }

            $post->fillDynamic($input);
        }

        $post->type = $type;
        $post->status = 'publish';
        $post->status_old = 'publish';
        $post->visibility = 'publish';
        $post->ip = request()->ip();
        $post->save();

        return $post;
    }

    public static function objectSlug($table,$slug, $callback = null ){

        $instance = new Vn4Model($table);

        $instance = $instance->where('slug',$slug);

        if( $callback ){
            $instance = call_user_func_array($callback,[$instance]);
        }

        return $instance->first();

    }

    public static function findCustomPost($post_type , $id,  $columns = array('*')){
        
        $admin_object = get_admin_object($post_type);
        
        if( !$admin_object ){
            return null;
        }

        $instance = new Vn4Model($admin_object['table']);

        if (is_array($id) && empty($id)) return $instance->newCollection();

        return $instance->newQuery()->find($id, $columns);
    }

    public static function seek($table, $id, $columns = array('*') ){

        $instance = new Vn4Model($table);

        if (is_array($id) && empty($id)) return $instance->newCollection();

        $post =  $instance->newQuery()->find($id, $columns);

        if( $post ){
             $post->setTable($table);
        }

        return $post;
    }

    public function setTable($table){
        $this->table = $table;

        return $this;
    }
    
    public function getTableName(){
        return $this->table;
    }

    public function updateMeta( $key , $value = null){

        $meta = json_decode($this->meta,true); 

        if( !is_array($meta) ){
            $meta = [];
        }

        if( is_array($key) ){
            $meta = array_merge ($meta, $key);
        }elseif(is_string($key) && $value !== null){
            $meta[$key] = $value;
        }

        $this->meta = json_encode($meta);

        $this->save([],false);

        return $this;
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

    public function fillDynamic(array $data){

        $arg = [];

        foreach($data as $key=>$value){

            if( is_array($value) ){
                $input[$key] = json_encode($value);
            }else{
                if( is_string($value) ){
                    $input[$key] = trim($value);
                }else{
                    $input[$key] = $value;
                }
            }

            array_push($arg, $key);
        }

        // $input['author'] = 0;
        
        array_push($arg, 'author');
        
        if(!isset($input['status'])){

            array_push($arg, 'status');
            $input['status'] = 'publish';

        }

        // if( !$this->author && Auth::id() ){
        //     $input['author'] = Auth::id();
        // }

        $this->fillable = $arg;
        parent::fill($input);

    }

    public function original($name = null){

        if($name == null){
            return $this->getOriginal();
        }

        if(isset($this->getOriginal()[$name]))
            return $this->getOriginal()[$name];

        return null;
    }

    private function clone_o($input){
        $this->attributes = (array) $input;
        $this->exists = true;
        return $this;
    }

    public static function getPosts( $parameters = [] ){

        $post_type = $parameters['post_type'];

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

        $admin_object = get_admin_object();

        //not found post_type
        if( !isset($admin_object[$post_type]) ){
            return [];
        }

        $posts = (new Vn4Model($admin_object[$post_type]['table']))->where('type',$post_type)->where('status','publish')->where('visibility','!=','private')->where(function($q){
            return $q->where('post_date_gmt','<=',time())->orWhereNull('post_date_gmt');
        });

       
        if( !is_admin() ){
            $posts->where(function($q){
                return $q->where('is_homepage',0)->orWhereNull('is_homepage');
            });
        }

        $posts = do_action('get_posts', $posts, $post_type);

        if( is_array($callback) ){

            foreach ($callback as $c) {
                call_user_func_array($c,[$posts]);
                // $posts = call_user_func_array($c,[$posts]);
            }

        }elseif(is_callable ($callback) ){
            call_user_func_array($callback,[$posts]);
            // $posts = call_user_func_array($callback,[$posts]);
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
            $posts = self::withRelationships($posts, $with, $admin_object, $post_type);
        }

        return $posts;
    }

    public static function withRelationships($posts, $with, $admin_object, $post_type){

        if( empty($posts) ) return $posts;

        $id = $posts->pluck(Vn4Model::$id)->toArray();



        if( is_string($with) ){

            $with_temp = $with;

            $with = rtrim($with,'s');

            if( isset($admin_object[$with]) ){

                if( isset($admin_object[$post_type]['fields'][$with]) && $admin_object[$post_type]['fields'][$with]['view'] === 'relationship_manytomany'  ){

                    $table_relation = 'vn4_'.$post_type.'_'.$with;

                    $pivot = DB::select('select `'.$admin_object[$with]['table'].'`.*, `'.$table_relation.'`.`post_id` as `pivot_post_id`, `'.$table_relation.'`.`tag_id` as `pivot_tag_id` from `'.$admin_object[$with]['table'].'` inner join `'.$table_relation.'` on `'.$admin_object[$with]['table'].'`.`id` = `'.$table_relation.'`.`tag_id` where `'.$table_relation.'`.`post_id` in ('.implode(', ',$id).')');

                    foreach ($posts as $key => $value) {
                        $posts[$key]->relations[$with_temp] = [];
                        foreach ($pivot as $key2 => $value2) {
                            if( $value2->pivot_post_id === $value->id ){
                                $posts[$key]->relations[$with_temp][] = (new Vn4Model )->clone_o($value2);
                                unset($pivot[$key2]);
                            }
                        }
                        $posts[$key]->relations[$with_temp] = collect($posts[$key]->relations[$with_temp]);
                    }
                }elseif( isset($admin_object[$with]['fields'][$post_type]) && $admin_object[$with]['fields'][$post_type]['view'] === 'relationship_manytomany' ) {

                    $table_relation = 'vn4_'.$with.'_'.$post_type;

                    $pivot = DB::select('select `'.$admin_object[$with]['table'].'`.*, `'.$table_relation.'`.`post_id` as `pivot_post_id`, `'.$table_relation.'`.`tag_id` as `pivot_tag_id` from `'.$admin_object[$with]['table'].'` inner join `'.$table_relation.'` on `'.$admin_object[$with]['table'].'`.`id` = `'.$table_relation.'`.`post_id` where `'.$table_relation.'`.`tag_id` in ('.implode(', ',$id).')');

                    foreach ($posts as $key => $value) {
                        $posts[$key]->relations[$with_temp] = [];
                        foreach ($pivot as $key2 => $value2) {
                            if( $value2->pivot_tag_id === $value->id ){
                                $posts[$key]->relations[$with_temp][] = (new Vn4Model )->clone_o($value2);
                                unset($pivot[$key2]);
                            }
                        }
                        $posts[$key]->relations[$with_temp] = collect($posts[$key]->relations[$with_temp]);
                    }
                }

            }
           

        }else{
            $withArg = $with;

            foreach ($withArg as $with) {

                $with_temp = $with;

                $with = rtrim($with,'s');

                if( isset($admin_object[$with]) ){

                    if( isset($admin_object[$post_type]['fields'][$with]) && $admin_object[$post_type]['fields'][$with]['view'] === 'relationship_manytomany'  ){

                        $table_relation = 'vn4_'.$post_type.'_'.$with;

                        $pivot = DB::select('select `'.$admin_object[$with]['table'].'`.*, `'.$table_relation.'`.`post_id` as `pivot_post_id`, `'.$table_relation.'`.`tag_id` as `pivot_tag_id` from `'.$admin_object[$with]['table'].'` inner join `'.$table_relation.'` on `'.$admin_object[$with]['table'].'`.`id` = `'.$table_relation.'`.`tag_id` where `'.$table_relation.'`.`post_id` in ('.implode(', ',$id).')');

                        foreach ($posts as $key => $value) {
                            $posts[$key]->relations[$with_temp] = [];
                            foreach ($pivot as $key2 => $value2) {
                                if( $value2->pivot_post_id === $value->id ){
                                    $posts[$key]->relations[$with_temp][] = (new Vn4Model )->clone_o($value2);
                                    unset($pivot[$key2]);
                                }
                            }
                            $posts[$key]->relations[$with_temp] = collect($posts[$key]->relations[$with_temp]);
                        }
                    }elseif( isset($admin_object[$with]['fields'][$post_type]) && $admin_object[$with]['fields'][$post_type]['view'] === 'relationship_manytomany' ) {

                        $table_relation = 'vn4_'.$with.'_'.$post_type;

                        $pivot = DB::select('select `'.$admin_object[$with]['table'].'`.*, `'.$table_relation.'`.`post_id` as `pivot_post_id`, `'.$table_relation.'`.`tag_id` as `pivot_tag_id` from `'.$admin_object[$with]['table'].'` inner join `'.$table_relation.'` on `'.$admin_object[$with]['table'].'`.`id` = `'.$table_relation.'`.`post_id` where `'.$table_relation.'`.`tag_id` in ('.implode(', ',$id).')');

                        foreach ($posts as $key => $value) {
                            $posts[$key]->relations[$with_temp] = [];
                            foreach ($pivot as $key2 => $value2) {
                                if( $value2->pivot_tag_id === $value->id ){
                                    $posts[$key]->relations[$with_temp][] = (new Vn4Model )->clone_o($value2);
                                    unset($pivot[$key2]);
                                }
                            }
                            $posts[$key]->relations[$with_temp] = collect($posts[$key]->relations[$with_temp]);
                        }
                    }

                }
            }
        }

        return $posts;
    }

    public function __get($name){

        $argNotIn = ['updated_at'=>'updated_at','created_at'=>'created_at','id'=>'id',Vn4Model::$id=>'id'];

        if( isset($argNotIn[$name]) ) {
            return parent::__get($argNotIn[$name]);
        }

        if( !isset($this->attributes[$name]) ){
            $result = do_action('__Vn4Model_function__get', null, $this, $name);
            if( $result ) return $result;
            else return null;
        }

        return $this->attributes[$name];
    }

    public function related($post_type, $field = null, $param = []){

        $id = $this->id;

        if( !$field ) $field = $this->type;
        
        $admin_object = get_admin_object($post_type);
        // dd($admin_object);
        if( $admin_object['fields'][$field]['view'] === 'relationship_manytomany' ){

            $callback = function($q) use ($id,$post_type,$admin_object,$field) {

                return $q->whereRaw(Vn4Model::$id.' in ( SELECT post_id as id FROM '.vn4_tbpf().$post_type.'_'.$admin_object['fields'][$field]['object'].' WHERE tag_id = '.$id.'  AND field = "'.$field.'" )');

                // return $q->whereIn(Vn4Model::$id,Vn4Model::table(vn4_tbpf().$post_type.'_'.$admin_object['fields'][$field]['object'])->where('tag_id',$id)->pluck('post_id'));
            };

            if( isset($param['callback']) ){
                $param = array_merge($param, ['callback'=>[$callback, $param['callback']]]);
            }else{
                $param = array_merge($param, ['callback'=>$callback]);
            }

            return get_posts($post_type, $param);

        }elseif( $admin_object['fields'][$field]['view'] === 'relationship_onetomany' ){

            $callback = function($q) use ($id,$post_type,$admin_object,$field) {
                return $q->where($field, $id);
            };

            if( isset($param['callback']) ){
                $param = array_merge($param, ['callback'=>[$callback, $param['callback']]]);
            }else{
                $param = array_merge($param, ['callback'=>$callback]);
            }

            return get_posts($post_type, $param);

        }elseif( $admin_object['fields'][$field]['view'] === 'relationship_onetoone' ){
            
            $callback = function($q) use ($id,$post_type,$admin_object,$field) {
                return $q->where(Vn4Model::$id, $id);
            };

            if( isset($param['callback']) ){
                $param = array_merge($param, ['callback'=>[$callback, $param['callback']]]);
            }else{
                $param = array_merge($param, ['callback'=>$callback]);
            }

            $param['count'] = 1;

            $posts = get_posts($post_type, $param);

            if( isset($posts[0]) ) return $posts[0];

            return null; 

        }

    }

    public function relationship($field, $param = []){

        $id = $this->id;
        $post_type = $this->type;
        $admin_object = get_admin_object($post_type);

        if( $admin_object['fields'][$field]['view'] === 'relationship_manytomany' ){

            $callback = function($q) use ($id,$post_type,$admin_object,$field) {

                return $q->whereRaw(Vn4Model::$id.' in ( SELECT tag_id as id FROM '.vn4_tbpf().$post_type.'_'.$admin_object['fields'][$field]['object'].'  WHERE post_id = '.$id.' AND field = "'.$field.'" )');
                // return $q->whereIn(Vn4Model::$id,Vn4Model::table(vn4_tbpf().$post_type.'_'.$admin_object['fields'][$field]['object'])->where('post_id',$id)->pluck('tag_id'));
            };

            if( isset($param['callback']) ){
                $param = array_merge($param, ['callback'=>[$callback, $param['callback']]]);
            }else{
                $param = array_merge($param, ['callback'=>$callback]);
            }

            return get_posts($admin_object['fields'][$field]['object'], $param);

        }elseif( $admin_object['fields'][$field]['view'] === 'relationship_onetomany' ){
            return get_post($admin_object['fields'][$field]['object'], $this->{$field} );
        }elseif( $admin_object['fields'][$field]['view'] === 'relationship_onetoone' ){
            return get_post($admin_object['fields'][$field]['object'], $this->{Vn4Model::$id} );
        }elseif( $admin_object['fields'][$field]['view'] === 'relationship_onetoone_show' ){
            return get_post($admin_object['fields'][$field]['object'], $this->{Vn4Model::$id} );
        }
    }

    public function permanentlyDeleted(){
        dd($this);
    }
}

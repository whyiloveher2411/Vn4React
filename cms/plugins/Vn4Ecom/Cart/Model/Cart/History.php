<?php
namespace Vn4Ecom\Cart\Model\Cart;

class History{
    
    const ADDED = 'ADDED';
    const ADDED_MESSAGE = 'Order is created from {{page}}';

    const CHANGE_STATUS = 'CHANGE_STATUS';
    const CHANGE_STATUS_MESSAGE = 'Status Order changed on {{page}} from {{old_status}} to {{new_status}}';

    const ADD_NOTE = 'ADD_NOTE';
    const ADD_NOTE_MESSAGE = '{{message}}';

    const PRIVATE_TYPE = 'primary';
    const CUSTOMER_TYPE = 'customer';

    private $type = self::PRIVATE_TYPE;
   
    private $message;

    private $created_at;

    private $user;

    private $paramMessage;

    public function __construct($byUser){

        $this->user = $byUser;
        
        $this->created_at = date('Y-m-d H:i:s');
    }

    public function addType($type){
        $this->type = $type;
    }

    public function addMessage($type, $param){
        $type = $type.'_MESSAGE';
        $this->message = constant('self::'.$type);
        $this->paramMessage = $param;
    }

    public function setType($type){

        $listAccept = [
            self::PRIVATE_TYPE => true,
            self::CUSTOMER_TYPE => true
        ];

        if( isset( $listAccept[$type]) ){
            $this->type = $type;
        }

    }

    private function setMessage($message, $param){

        if( $param ){
            $keys = array_map( 
                function($key){
                    return '{{'.$key.'}}';
                }, 
                array_keys($param)
            );

            $values = array_values($param);

            $this->message = str_replace( $keys, $values, $message );
        }

    }
    
    public function toArray(){
        return [
            'type'=>$this->type,
            'created_at'=>$this->created_at,
            'message'=>$this->message,
            'by'=>$this->user,
            'paramMessage'=>$this->paramMessage
        ];
    }

}
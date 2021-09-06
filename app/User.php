<?php namespace App;

use Illuminate\Auth\Authenticatable;

use Jenssegers\Mongodb\Eloquent\Model;
// use Illuminate\Database\Eloquent\Model;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Vn4Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	public function __construct($tablename = 'table_name'){
        $this->table = vn4_tbpf().'user';
    }
    
	public function fillDynamic(array $input){
        $arg = [];
        foreach($input as $key=>$value){
            array_push($arg, $key);
        }

        $this->fillable = $arg;

        parent::fill($input);
    }

}

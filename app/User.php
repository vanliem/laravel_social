<?php

namespace App;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class User extends Model implements Authenticatable
{
    use \Illuminate\Auth\Authenticatable;

    public static $rules = array('first_name' => 'required');
    public static $errors;
    protected $fillable = ['first_name', 'email', 'password'];
    protected $guarded = [
        'id'
    ];
    protected $hidden = ['password', 'remember_token'];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function likes()
    {
    	return $this->hasMany(Like::class);
    }

    public static function validateRequest($data)
    {
        $validate = Validator::make($data, self::$rules);

        if ($validate->fails()) {
            self::$errors = $validate->errors()->all();

            return false;
        }

        return true;
    }

    public static function getErrors()
    {
        return self::$errors;
    }

}

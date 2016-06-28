<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Post extends Model
{
    protected $fillable = ['body', 'user_id'];
    public static $rules = array(
        'body' => 'required|min:6|max:1000'
    );
    public static $errors;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
    	return $this->hasMany(Like::class);
    }

    public function scopePost($query)
    {
        return $query->orderBy('created_at', 'desc');
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

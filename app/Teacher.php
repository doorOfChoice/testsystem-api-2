<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model {
    public $timestamps = false;

    protected $keyType = 'string';

    protected $table = 'teacher';

    protected $fillable = ['id', 'name', 'password'];

    protected $dates = [];

    protected $hidden = ['password', 'pivot'];

    public static $rules = [
        // Validation rules
    ];

    public function students(){
        return $this->belongsToMany('App\Student', 'teacher_student');
    }

    public function papers(){
        return $this->hasMany('App\Paper');
    }

    public function questions(){
        return $this->hasMany('App\Question');
    }
}

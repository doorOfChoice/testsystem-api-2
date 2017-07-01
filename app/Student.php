<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model {
    public $timestamps = false;

    protected $keyType = 'string';

    protected $table = 'student';

    protected $fillable = ['id', 'password', 'name'];

    protected $dates = [];

    protected $hidden = ['password', 'pivot'];

    public static $rules = [
        // Validation rules
    ];

    public function teachers(){
        return $this->belongsToMany('App\Teacher', 'teacher_student');
    }
}

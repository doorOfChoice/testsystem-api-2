<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Paper extends Model {
    public $timestamps = false;

    protected $table = 'paper';

    protected $fillable = [
        'id',
        'teacher_id',
        'create_date',
        'update_date',
        'subject_id',
        'title',
        'has_password',
        'password'
    ];

    protected $dates = [];

    protected $hidden = ['password'];

    public static $rules = [
        // Validation rules
    ];

    public function teacher(){
        return $this->belongsTo('App\Teacher');
    }

    public function questions(){
        return $this->belongsToMany('App\Question')->withPivot(['grade']);
    }

    public function subject(){
        return $this->belongsTo('App\Subject');
    }
}

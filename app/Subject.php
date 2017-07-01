<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model {
    public $timestamps = false;
    
    protected $table = 'subject';
    
    protected $fillable = ['id', 'name'];

    protected $dates = [];

    public static $rules = [
        // Validation rules
    ];

    public function questions(){
        return $this->hasMany('App\Question');
    }

    public function papers(){
        return $this->hasMany('App\Paper');
    }
    
}

<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model {
    public $timestamps = false;
    
    protected $table = 'type';

    protected $fillable = ['id', 'name'];

    protected $dates = [];

    public static $rules = [
        // Validation rules
    ];

    public function questions(){
        return $this->hasMany('App\Question');
    }

}

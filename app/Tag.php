<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model {
    public $timestamps = false;

    protected $table = 'tag';

    protected $fillable = ['id', 'name'];

    protected $dates = [];

    public static $rules = [];

    public function questions(){
        return $this->belongsToMany('App\Question');
    }
}

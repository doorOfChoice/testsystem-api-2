<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model {
    public $timestamps = false;

    protected $fillable = [
        'id',
        'teacher_id',
        'subject_id',
        'type_id',
        'tag_id',
        'content',
        'hot',
        'difficulty'
    ];
    protected $table = 'question';

    protected $dates = [];

    public static $rules = [
        // Validation rules
    ];

    public function tags(){
        return $this->belongsToMany('App\Tag');
    }

    public function options(){
        return $this->hasMany('App\Option');
    }

    public function subject(){
        return $this->belongsTo('App\Subject');
    }

    public function type(){
        return $this->belongsTo('App\Type');
    }

    public function teacher(){
        return $this->belongsTo('App\Teacher');
    }

    public function scopeAttr($query){
        return $query->with('subject', 'tags', 'options', 'type')
                     ->orderBy('hot','desc')
                     ->orderBy('id', 'desc');
    }
}

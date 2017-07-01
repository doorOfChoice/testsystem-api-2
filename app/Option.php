<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model {
    public $timestamps = false;

    protected $table = 'option';

    protected $fillable = [
        'id',
        'question_id',
        'correct',
        'content'
    ];
    protected $hidden = ['question_id'];
    public static $rules = [
        // Validation rules
    ];


}

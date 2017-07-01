<?php

namespace App\Tool;

use App\Tag;
use App\Type;
use App\Option;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagTool{
    public static function add(Request $req, $question){
        $validate = Validator::make($req->all(), [
            'tags'   => 'required',
            'tags.*' => 'required'
        ]);

        if(!$validate->fails()){
            //清除之前的标签联系
            $question->tags()->detach();
            
            $tags = [];
            $tagnames = array_unique($req->input('tags'));
            foreach($tagnames as $tagname){
                $tags[] = Tag::firstOrCreate(['name' => $tagname])->id;
            }

            $question->tags()->attach($tags);
            return $tags;
        }

        return NULL;
    }
}
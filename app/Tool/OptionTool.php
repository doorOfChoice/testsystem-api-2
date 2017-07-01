<?php

namespace App\Tool;

use App\Tag;
use App\Type;
use App\Option;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class OptionTool{
    public static function modify(Request $req, $question){
        $validate = Validator::make($req->all(), [
            'modify' => 'required',
            'modify.*.id' => 'required',
            'modify.*.correct' => 'required',
            'modify.*.content' => 'required'
        ]);
        if(!$validate->fails()){
            /**更新选项**/
            foreach($req->input('modify') as $modify){
                $option = $question->options()->where('id', $modify['id'])->first();
                if($option != NULL){
                    $option->correct = $modify['correct'];
                    $option->content = $modify['content'];
                    $option->save();
                }
            }
            return TRUE;
        }

        return FALSE;
    }

    public static function add(Request $req, $question){
        $validate = Validator::make($req->all(), [
            'corrects.*' => 'required',
            'contents.*' => 'required'
        ]);

        $options = [];
        if(!$validate->fails()){
            $corrects = $req->input('corrects');
            $contents = $req->input('contents');
            for($i = 0, $len = count($corrects); $i < $len; $i++){
                $options[] = new Option([
                    'correct' => $corrects[$i],
                    'content' => $contents[$i]
                ]);
                $question->options()->save($options[$i]);
            }
            return $options;
        }

        return NULL;
    }

    public static function delete(Request $req, $question){
        $validate = Validator::make($req->all(), [
            'deletes' => 'required'
        ]);

        if(!$validate->fails()){
            $question->options()->whereIn('id', $req->input('deletes'))->delete();

            return TRUE;
        }

        return FALSE;
    }
}
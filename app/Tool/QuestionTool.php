<?php

namespace App\Tool;

use App\Question;
use Illuminate\Support\Facades\DB;
class QuestionTool{
    public static function deal(Question $obj, $option = false, $show_answer = false){
        $array = $obj->attributesToArray();
        $array['subject_name'] = $obj->subject->name;
        $array['type_name']    = $obj->type->name;
        $array['tags'] = $obj->tags;
        foreach($array['tags'] as $key=>$value){
            unset($array['tags'][$key]['pivot']);
        }
        if($option){
            $array['options'] = $obj->options;
        }
        return $array;
    }

    public static function dealAll($arrays, $option = false){
        $result = ['questions' => []];


        if(method_exists($arrays, 'currentPage')){
            $result['curPage'] = $arrays->currentPage();
            $result['count']   = $arrays->count();
            $result['lastPage']= $arrays->lastPage();
            $result['perPage'] = $arrays->perPage();
        }
        foreach($arrays as $array){
            $result['questions'][] = self::deal($array, $option);
        }

        return $result;
    }

    //查找满足 是某一类型也是某一学科也包含某类知识点的题
    public static function qs_build($tags, $typename, $sid, $grade = 5, $limit = 5){
        $query = Question::distinct()
               ->select([
                   'question.*',
                   DB::raw("$grade as grade")])
               ->leftJoin('subject', 'subject.id', '=', 'question.subject_id')
               ->leftJoin('type', 'type.id', '=', 'question.type_id')
               ->where([
                   ['type.name', $typename],
                   ['subject.id', $sid]
                ])
               ->inRandomOrder()->limit($limit);

        if(!empty($tags) &&  count($tags) != 0)
        {
            $query = $query->leftJoin('question_tag', 'question.id', '=', 'question_tag.question_id')
                           ->leftJoin('tag', 'tag.id', '=', 'question_tag.tag_id')
                           ->whereIn('tag.name', $tags);
        }
        return $query;
    }


}

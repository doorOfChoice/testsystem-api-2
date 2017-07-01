<?php

namespace App\Tool;

use App\Paper;
use App\Question;
use App\Tool\QuestionTool;
use Illuminate\Support\Facades\DB;
class CorrectTool{
    public static function insert($tid, $sid, $qid, $pid, $has_correct = 0, $grade = 0, $description = NULL){
        return DB::table('correct_paper')->insertGetId([
          'teacher_id' => $tid,
          'student_id' => $sid,
          'question_id' => $qid,
          'paper_id'   => $pid,
          'has_correct' => $has_correct,
          'grade'      => $grade,
          'description' => $description
        ]);

    }

    public static function update($tid, $sid, $qid, $pid, $has_correct = 1, $grade = 0){
        return DB::table('correct_paper')->where([
          ['teacher_id', $tid],
          ['student_id', $sid],
          ['question_id', $qid],
          ['paper_id', $pid]
        ])->update([
          'has_correct' => $has_correct,
          'grade'       => $grade
        ]);
    }

    public static function verify_answer($id, $replys){
        $question = Question::where('id', $id)->first();
        $replys = array_unique($replys);
        $corrects = [];

        foreach($question->options as $option){
            if($option->correct){
              $corrects[] = $option->id;
            }
        }

        if(count($corrects) !== count($replys))
            return FALSE;

        foreach($replys as $reply){
          if(!in_array($reply, $corrects)){
              return FALSE;
          }
        }

        return TRUE;
    }
}

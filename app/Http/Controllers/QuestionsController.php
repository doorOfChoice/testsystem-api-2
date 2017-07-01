<?php
namespace App\Http\Controllers;

use App\Tag;
use App\Type;
use App\Option;
use App\Question;
use App\Teacher;
use App\Paper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Tool\TagTool;
use App\Tool\OptionTool;
use App\Tool\QuestionTool;
use App\Tool\ResponseTool;
class QuestionsController extends Controller {
    //每页的题目个数
    const PAGE = 15;

    public function __construct(){}

    //添加题目
    public function add(Request $req){
        $this->validate($req, [
            'subject_id' => 'required',
            'type_id'    => 'required',
            'content'    => 'required',
            'tags.*'     => 'required',
            'corrects.*' => 'required',
            'contents.*' => 'required'
        ]);

        $user = ['teacher_id' => $req->username];

        $question = Question::create(array_merge($req->except(['corrects', 'cotents', 'tags']), $user));

        OptionTool::add($req, $question);

        TagTool::add($req, $question);

        return ResponseTool::back($question);
    }

    //加试题到试卷
    public function add_to_paper(Request $req){

        $this->validate($req, [
            'paper_id' => 'required',
            'questions' => 'required',
            'questions.*.id' => 'required',
            'questions.*.grade' => 'required'
        ]);

        $paper = Paper::findOrFail($req->get('paper_id'));

        if($paper->teacher_id !== $req->username){
            return ResponseTool::back([], ResponseTool::UNAUTHORIZED, '这不是属于你的属性');
        }

        foreach($req->input('questions') as $qs){
            $q = Question::where('id', $qs['id'])->first();
            if($q != NULL){
                if($paper->questions()->where('id', $qs['id'])->first() == NULL)
                    $paper->questions()->attach($qs['id'], ['grade' => $qs['grade']]);
            }
        }

        return ResponseTool::back([], ResponseTool::CREATED);
    }

    //删除试卷上的题
    public function delete_from_paper($qid, $pid){
        $paper = Paper::findOrFail($pid);

        if($paper->teacher_id !== $req->username){
            return ResponseTool::back([], ResponseTool::UNAUTHORIZED, '这不是属于你的属性');
        }

        $question = Question::findOrFail($qid);

        $paper->questions()->detach($question);

        return ResponseTool::back();
    }

    //删除题目
    public function delete($id){
        $question = Question::findOrFail($id);

        if($question->teacher_id !== $req->username){
            return ResponseTool::back([], ResponseTool::UNAUTHORIZED, '这不是属于你的属性');
        }

        $question->delete();

        return ResponseTool::back();
    }

    //更新题目
    public function update(Request $req, $id){
        $question = Question::findOrFail($id);

        if($question->teacher_id !== $req->username){
            return ResponseTool::back([], ResponseTool::UNAUTHORIZED, '这不是属于你的属性');
        }

        $this->validate($req, [
            'content' => 'required',
        ]);

        /**更改内容**/
        $question->content = $req->input('content');
        $question->save();

        /**更新选项**/
        OptionTool::modify($req, $question);
        /**添加选项**/
        OptionTool::add($req, $question);
        /**删除选项**/
        OptionTool::delete($req, $question);
        /**更新标签**/
        TagTool::add($req, $question);

        return ResponseTool::back($question);
    }

    //根据id获取题目
    public function get($id){
        $data = Question::findOrFail($id);

        return ResponseTool::back(QuestionTool::deal($data, true));
    }

    //获取所有题目
    public function all(){
        $datas = QuestionTool::dealAll(
            Question::attr()->paginate(self::PAGE)
        );
        return ResponseTool::back($datas);
    }

    //根据tag获取题目
    public function get_by_tag($tagname){
        $tagname = \urldecode($tagname);

        $tag = Tag::where('name','like',"%$tagname%")->first();

        if($tag == NULL)
            return ResponseTool::back([], ResponseTool::NOT_FOUND, '标签不存在');

        $datas = QuestionTool::dealAll($tag->questions()
                                           ->orderBy('id')
                                           ->paginate(self::PAGE));
        return ResponseTool::back($datas);
    }

    //根据科目获取题目
    public function get_by_subject($id){
        $subject = Subject::findOrFail($id);

        $datas = QuestionTool::dealAll($subject->questions()
                                               ->orderBy('id')
                                               ->paginate(self::PAGE));

        return ResponseTool::back($datas);
    }

    //根据类型获取题目
    public function get_by_type($id){
        $type = Type::findOrFail($id);

        $datas = QuestionTool::dealAll($type->questions()
                                            ->orderBy('id')
                                            ->paginate(self::PAGE));

        return ResponseTool::back($datas);
    }


}

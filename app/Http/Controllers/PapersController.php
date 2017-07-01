<?php namespace App\Http\Controllers;
use App\Teacher;
use App\Paper;
use App\Type;
use App\Tag;
use App\Option;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Tool\QuestionTool;
use App\Tool\PaperTool;
use App\Tool\CorrectTool;
use App\Tool\ResponseTool;
class PapersController extends Controller {
    const PAGE = 15;

    public function __consturct(){}


    public function add(Request $req){
        $this->validate($req, [
            'title' => 'required',
            'subject_id' => 'required'
        ]);

        $user = ['teacher_id' => $req->username];

        $paper = Paper::create(array_merge($req->all(), $user));

        return ResponseTool::back($paper);
    }

    /*
    |随机生成试卷
    |(待定)
    |$tags, $typename, $sid, $grade = 5, $limit = 5
    */

    public function random_questions($tagnames, $sid){
        $tags   = json_decode(\urldecode($tagnames));

        $radio  = QuestionTool::qs_build($tags, '单选题', $sid, 5, 8)->get();
        $multy  = QuestionTool::qs_build($tags, '多选题', $sid, 5, 4)->get();
        $judge  = QuestionTool::qs_build($tags, '判断题', $sid, 5, 4)->get();
        $reply  = QuestionTool::qs_build($tags, '简答题', $sid, 10, 2)->get();

        $datas = $radio->merge($multy);
        $datas = $datas->merge($judge);
        $datas = $datas->merge($reply);

        return ResponseTool::back(QuestionTool::dealAll($datas, true));
    }

    //修改试卷的基本信息
    public function update(Request $req, $id){
        $teacher_id = $req->username;
        $paper = Paper::findOrFail($id);

        if($paper->teacher_id != $teacher_id)
            return ResponseTool::back([], ResponseTool::FORBIDDEN);

        $this->validate($req, [
            'title'        => 'required',
            'has_password' => 'required',
        ]);

        $paper->title        = $req->get('title');
        $paper->has_password = $req->get('has_password');
        if($req->get('has_password'))
            $paper->password     = $req->get('password');

        $paper->save();

        return ResponseTool::back($paper);
    }

    //删除试卷
    public function delete($id){
        $paper = Paper::findOrFail($id);

        if($paper->username !== $paper->teacher_id)
            return ResponseTool::back([], ResponseTool::UNAUTHORIZED);

        $paper->delete();

        return ResponseTool::back([], ResponseTool::NO_CONTENT);
    }

    //根据id查看试卷的具体信息
    public function get_by_id(Request $req, $id){
        $paper = Paper::findOrFail($id);

        $is_teacher = $req->is_teacher;
        //判断是否是老师
        if($is_teacher == 1)
        {
            return ResponseTool::back(PaperTool::deal($paper, true, true));
        }
        //判断是否是学生
        else if($is_teacher == 0)
        {
            //判断是否加密
            if($paper->has_password)
            {
                if($req->get('password') === $paper->password){
                    return ResponseTool::back(PaperTool::deal($paper, true));
                }

                return ResponseTool::back([], ResponseTool::FORBIDDEN);
            }

            return ResponseTool::back(PaperTool::deal($paper, true, true));
        }
    }

    //查看学生提交的试卷
    public function get_from_corrected($pid, $sid, $tid){
        $paper = Paper::findOrFail($pid);

        $questions = PaperTool::join()
        ->where([
          ['correct_paper.teacher_id' , $tid],
          ['correct_paper.student_id' , $sid],
          ['correct_paper.paper_id'   , $pid]
        ])
        ->select('correct_paper.question_id', 'correct_paper.has_correct','correct_paper.grade', 'correct_paper.description')
        ->get();

        $qs = [];
        foreach($questions as $question){
            $q = $paper->questions()->find($question['question_id']);
            $q->current_grade = $question['grade'];
            $q->description = $question['description'];
            $q->max_grade = $q->pivot->grade;
            $qs[] = $q;
        }

        $result = QuestionTool::dealAll($qs, true, true);

        return ResponseTool::back($result);
    }


    //老师获取试卷
    public function get_by_teacher($id){
        $teacher = Teacher::findOrFail($id);

        $datas = PaperTool::dealAll($teacher->papers()->paginate(self::PAGE));

        return ResponseTool::back($datas);
    }

    //学生提交试卷
    public function verify_paper(Request $req){
        $this->validate($req, [
          'paper_id' => 'required',
          'answers.*.id' => 'required',
          'answers.*.replys.*' => 'required'
        ]);

        $paper = Paper::findOrFail($req->get('paper_id'));
            $teacher_id = $paper->teacher->id;
            $student_id = $req->username;

            $teacher = Student::findOrFail($student_id)
                              ->teachers()->where('id', $teacher_id)->first();

            if($teacher->id !== $teacher_id)
                return ResponseTool::back([], ResponseTool::FORBIDDEN);

            foreach($req->get('answers') as $answer){
                //学生答案
                $replys = [];

                foreach($answer['replys'] as $reply){
                  $replys[] = $reply;
                }

                $question = Question::find($answer['id']);

                $is_reply = $question->type->name == '简答题';
                $is_right = CorrectTool::verify_answer($question->id, $replys);
                //第一次批改客观题目，留下主观题目
                CorrectTool::insert(
                  $teacher_id,
                  $student_id,
                  $question->id,
                  $paper->id,
                  $is_reply ? 0 : 1,
                  $is_right ? $paper->questions()->find($question->id)->pivot->grade : 0,
                  $is_reply ? $answer['description'] : implode(",", $replys)
                );
            }
            return ResponseTool::back([], ResponseTool::CREATED);

    }

    //老师修改剩下简答题
    public function correct_reply(Request $req, $pid, $sid){
        $this->validate($req, [
            'corrects.*.id' => 'required',
            'corrects.*.grade' => 'required'
        ]);

        $paper = Paper::findOrFail($pid);

        $teacher_id = $paper->teacher->id;

        if($teacher_id !== $req->username)
            return ResponseTool::back([], ResponseTool::FORBIDDEN);

        $student_id = $sid;

        foreach($req->get('corrects') as $correct){
            CorrectTool::update(
              $teacher_id,
              $student_id,
              $correct['id'],
              $paper->id,
              1,
              $correct['grade']
            );
        }
        return ResponseTool::back([], ResponseTool::OK);
    }

    //老师获取未批改的试卷
    public function uncorrect_paper_teacher(Request $req){
       $teacher_id = $req->username;
       $papers = PaperTool::join()
                ->where([
                  ['correct_paper.teacher_id', $teacher_id],
                  ['correct_paper.has_correct', 0]
                ])
                ->select('correct_paper.teacher_id', 'correct_paper.student_id', 'correct_paper.paper_id', 'paper.title')
                ->groupBy('correct_paper.teacher_id', 'correct_paper.student_id', 'correct_paper.paper_id')
                ->havingRaw('COUNT(*) > 0')
                ->paginate(self::PAGE);

       return ResponseTool::back($papers, ResponseTool::OK);
    }
    //老师获取已经批改过的试卷
    public function correct_paper_teacher(Request $req){
      $teacher_id = $req->username;
      $papers = PaperTool::join()
               ->where([
                 ['correct_paper.teacher_id', $teacher_id]
               ])
               ->select('correct_paper.teacher_id', 'correct_paper.student_id', 'correct_paper.paper_id',
                        'paper.title', DB::raw('SUM(grade) as sum'))
               ->groupBy('correct_paper.teacher_id', 'correct_paper.student_id', 'correct_paper.paper_id')
               ->havingRaw('MIN(has_correct)=1')
               ->paginate(self::PAGE);
      return ResponseTool::back($papers, ResponseTool::OK);
    }

    //学生获取没有批改过的试卷
    public function uncorrect_paper_student(Request $req){
        $student_id = $req->username;
        $papers = PaperTool::join()
                 ->where([
                   ['correct_paper.student_id', $student_id],
                   ['correct_paper.has_correct', 0]
                 ])
                 ->select('correct_paper.teacher_id', 'correct_paper.student_id', 'correct_paper.paper_id', 'paper.title')
                 ->groupBy('correct_paper.teacher_id', 'correct_paper.student_id', 'correct_paper.paper_id')
                 ->havingRaw('COUNT(*) > 0')
                 ->paginate(self::PAGE);
        return ResponseTool::back($papers, ResponseTool::OK);
    }

    //学生获取批改过的试卷
    public function correct_paper_student(Request $req){
        $student_id = $req->username;
        $papers = PaperTool::join()
                 ->where([
                   ['correct_paper.student_id', $student_id]
                 ])
                 ->select('correct_paper.teacher_id', 'correct_paper.student_id', 'correct_paper.paper_id',
                          'paper.title', DB::raw('SUM(grade) as sum'))
                 ->groupBy('correct_paper.teacher_id', 'correct_paper.student_id', 'correct_paper.paper_id')
                 ->havingRaw('MIN(has_correct)=1')
                 ->paginate(self::PAGE);

        return ResponseTool::back($papers, ResponseTool::OK);
    }
}

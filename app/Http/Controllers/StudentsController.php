<?php
namespace App\Http\Controllers;
use App\Tag;
use App\Type;
use App\Option;
use App\Question;
use App\Teacher;
use App\Paper;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Tool\ResponseTool;
use App\Tool\JWTTool;
class StudentsController extends Controller{
    public function __contruct(){}

    public function register(Request $req){
        $this->validate($req, [
            'username' => 'required|alpha_num|between:4,11',
            'password' => 'required|alpha_num|between:4,11',
        ]);

        $user = Student::where('id', $req->get('username'))->first();

        if($user !== NULL)
            return ResponseTool::back();

        return ResponseTool::back(Student::create([
          'id'       => $req->get('username'),
          'password' => sha1($req->get('password')),
          'nickname' => $req->get('nickname')
        ]), ResponseTool::CREATED);
    }

    public function login(Request $req){
        $this->validate($req, [
            'username' => 'required|alpha_num|between:4,11',
            'password' => 'required|alpha_num|between:4,11',
        ]);

        $user = Student::findOrFail($req->get('username'));

        if($user->password === sha1($req->get('password'))){
            return ResponseTool::back([
              'token' => JWTTool::build($user->id, 0)
            ]);
        }

        return ResponseTool::back([], ResponseTool::UNAUTHORIZED);
    }

    public function follow_teacher(Request $req){
        $this->validate($req, [
            'teacher_id' => 'required|alpha_num|between:4,11'
        ]);

        $student = Student::findOrFail($req->username);
        $teacher = Teacher::findOrFail($req->get('teacher_id'));

        $result = $student->teachers()->attach($teacher->id);

        return ResponseTool::back([], ResponseTool::CREATED);
    }

    public function unfollow_teacher(Request $req, $teacher_id){
        $student = Student::findOrFail($req->username);
        $teacher = Teacher::findOrFail($teacher_id);

        $student->teachers()->detach($teacher->id);

        return ResponseTool::back([], ResponseTool::NO_CONTENT);
    }

    public function get_teachers(Request $req){
        $student = Student::findOrFail($req->username);
        $result = $student->teachers()->orderBy('id')->paginate(15);

        return ResponseTool::back($result);
    }
}

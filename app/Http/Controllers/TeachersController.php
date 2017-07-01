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
class TeachersController extends Controller{
    public function __contruct(){}

    public function register(Request $req){
        $this->validate($req, [
            'username' => 'required|alpha_num|between:4,11',
            'password' => 'required|alpha_num|between:4,11',
        ]);

        $user = Teacher::where('id', $req->get('username'))->first();

        if($user !== NULL)
            return ResponseTool::back();

        return ResponseTool::back(Teacher::create([
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

        $user = Teacher::findOrFail($req->get('username'));

        if($user->password === sha1($req->get('password'))){
            return ResponseTool::back([
              'token' => JWTTool::build($user->id, 1)
            ]);
        }

        return ResponseTool::back([], ResponseTool::UNAUTHORIZED);
    }

    public function unfollowed_student(Request $req, $student_id){
        $teacher = Teacher::findOrFail('dawndevil');
        $student = Student::findOrFail($student_id);

        $teacher->students()->detach($student->id);

        return ResponseTool::back([], ResponseTool::NO_CONTENT);
    }

    public function get_students(Request $req){
        $teacher = Teacher::findOrFail('dawndevil');
        $result = $teacher->students()->orderBy('id')->paginate(15);

        return ResponseTool::back($result);
    }
}

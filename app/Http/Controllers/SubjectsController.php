<?php namespace App\Http\Controllers;
use App\Subject;
use App\Tool\ResponseTool;
class SubjectsController extends Controller {
    public function all(){
        return ResponseTool::back(Subject::all());
    }
}

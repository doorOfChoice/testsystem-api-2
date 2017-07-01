<?php namespace App\Http\Controllers;
use App\Type;
use App\Tool\ResponseTool;
class TypesController extends Controller {

    public function all(){
        return ResponseTool::back(Type::all());
    }

}

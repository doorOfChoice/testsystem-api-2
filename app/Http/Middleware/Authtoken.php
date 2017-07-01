<?php

namespace App\Http\Middleware;

use Closure;
use App\Tool\JWTTool;
use App\Tool\ResponseTool;
class Authtoken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $obj = NULL)
    {
        if($request->header('token') === NULL
        || !JWTTool::verify($request->header('token'))){
            return ResponseTool::back([], ResponseTool::UNAUTHORIZED, '未登录');
        }
        $result = JWTTool::decode($request->header('token'));
        $request->username = $result['username'];
        $request->is_teacher = $result['is_teacher'];

        if($obj === 'student'){
            if($request->is_teacher !== 0){
                return ResponseTool::back([], ResponseTool::UNAUTHORIZED, '非学生身份不可操作');
            }
        }else if($obj === 'teacher'){
            if($request->is_teacher !== 1){
                return ResponseTool::back([], ResponseTool::UNAUTHORIZED, '非教师身份不可操作');
            }
        }

        return $next($request);
    }
}

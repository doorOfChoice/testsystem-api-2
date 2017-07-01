<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/


$app->group(['middleware' => 'crossover'], function() use ($app){
  $app->group(['prefix' => 'v2'], function() use ($app){
      /**题目路由**/
      $app->group(['prefix' => 'question'], function() use ($app){
          $app->group(['middleware' => 'authtoken:teacher'], function() use ($app){
              //删除题目
              $app->delete('{id:[0-9]+}', 'QuestionsController@delete');
              //更新题目
              $app->put('{id:[0-9]+}', 'QuestionsController@update');
              //添加题目
              $app->post('/', 'QuestionsController@add');
              //把题目添加到试卷
              $app->post('paper', 'QuestionsController@add_to_paper');
              //从试卷上删除题目
              $app->delete('{qid:[0-9]+}/from/{pid:[0-9]+}', 'QuestionsController@delete_from_paper');
          });
          //获取所有题目，可分页
          $app->get('/', 'QuestionsController@all');
          //根据知识点查题目
          $app->get('tag/{tagname}', 'QuestionsController@get_by_tag');
          //根据课程查询题目
          $app->get('subject/{id:[0-9]+}', 'QuestionsController@get_by_subject');
          //根据类型查询题目
          $app->get('type/{id:[0-9]+}', 'QuestionsController@get_by_type');
          //根据id获取题目详细信息
          $app->get('{id:[0-9]+}', 'QuestionsController@get');
      });


      /**试卷路由**/
      $app->group(['prefix' => 'paper'], function() use ($app){
          $app->group(['middleware' => 'authtoken:teacher'], function() use ($app){
              //新增试卷
              $app->post('/', 'PapersController@add');
              //更新试卷基本信息
              $app->put('{id:[0-9]+}', 'PapersController@update');
              //删除试卷
              $app->delete('{id:[0-9]+}', 'PapersController@delete');
              //根据知识点随机生成试卷
              $app->get('subject/{sid:[0-9]+}/tag/{tagnames}', 'PapersController@random_questions');
              //老师修改简答题
              $app->put ('{pid:[0-9]+}/student/{sid}', 'PapersController@correct_reply');
              //老师获取未批改的试卷
              $app->get('uncorrected/teacher', 'PapersController@uncorrect_paper_teacher');
              //老师获取批改的试卷
              $app->get('corrected/teacher', 'PapersController@correct_paper_teacher');
          });

          $app->group(['middleware' => 'authtoken:student'], function() use ($app){
              //学生获取未批改的试卷
              $app->get('uncorrected/student', 'PapersController@uncorrect_paper_student');
              //学生获取批改的试卷
              $app->get('corrected/student', 'PapersController@correct_paper_student');
              //学生提交试卷
              $app->post('validity', 'PapersController@verify_paper');

          });

          $app->group(['middleware' => 'authtoken'], function() use ($app){
              //查看某一学生的具体的考试答案
              $app->get('{pid:[0-9]+}/student/{sid}/teacher/{tid}', 'PapersController@get_from_corrected');
              //根据id查看试卷详细信息
              $app->get('{id:[0-9]+}', 'PapersController@get_by_id');
              //根据老师id获取试卷
              $app->get('teacher/{id}', 'PapersController@get_by_teacher');
          });
      });

      $app->group(['prefix' => 'student'], function() use ($app){
          $app->group(['middleware' => 'authtoken:student'], function() use ($app){
              //关注老师
              $app->post('teacher', 'StudentsController@follow_teacher');
              //取消关注老师
              $app->delete('teacher/{teacher_id}', 'StudentsController@unfollow_teacher');
              //获取关注的老师
              $app->get('teacher', 'StudentsController@get_teachers');
          });
          //学生注册
          $app->post('/', 'StudentsController@register');
          //学生登录
          $app->post('session', 'StudentsController@login');
      });

      $app->group(['prefix' => 'teacher'], function() use ($app){
          $app->group(['middleware' => 'authtoken:teacher'], function() use ($app){
              //获取关注老师的学生
              $app->get('student', 'TeachersController@get_students');
              //删除关注老师的学生
              $app->delete('student/{student_id}', 'TeachersController@unfollowed_student');
          });
          //老师注册
          $app->post('/', 'TeachersController@register');
          //老师登录
          $app->post('session', 'TeachersController@login');
      });

      $app->group(['prefix' => 'subject'], function() use ($app){
          $app->get('/', 'SubjectsController@all');
      });

      $app->group(['prefix' => 'type'], function() use ($app){
          $app->get('/', 'TypesController@all');
      });
  });

});

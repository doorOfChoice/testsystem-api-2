# testsystem version 2 api

经过漫长的LOL，第二版终于出来了，相对于第一版多了很多验证功能还有操作题目的功能，不过稳定性还有待商榷.

## 使用说明

+ 分页的方法是在url后面加 ?page=页码
+ 注意文档中有些地方需要把url的参数编码
+ 参数分为三类, url(传在url上的), payload(传在json里面的), header(传在头部里面的)
+ 响应里面返回的主体固定格式是下面这种，写在里面的实例全是成功的响应结果.

```
{
    "datas" : 数据,
    "status" : 消息(通常看响应码就行了)
}
```


## 基本网址

Base : https://api.seeonce.cn/paper/public/v2

## 目录

+ ### paper
  + [新建试卷](paper/add.md)
  + [删除试卷](paper/delete.md)
  + [更新试卷](paper/update.md)
  + [学生提交试卷](paper/submit_paper.md)
  + [老师批改未批改的试题](paper/correct_reply.md)
  + [随机生成一套试题](paper/random_question.md)
  + [查看学生提交的试卷](paper/show_submit_paper.md)
  + [学生查看自己已经被批改的试卷](paper/student_corrected.md)
  + [学生查看自己还未被批改的试卷](paper/student_uncorrected.md)
  + [老师查看自己已经批改的试卷](paper/teacher_corrected.md)
  + [老师查看自己还未批改的试卷](paper/teacher_uncorrected.md)
  + [查看试卷的具体信息](paper/get_by_id.md)
  + [查看老师拥有的试卷](paper/get_by_teacher.md)

+ ### question
  + [新建题目](question/add.md)
  + [修改题目](question/update.md)
  + [删除题目](question/delete.md)
  + [添加题目到试卷](question/add_to_paper.md)
  + [从试卷上删除题目](question/delete_from_paper.md)
  + [查看题目详细信息](question/get_by_id.md)
  + [根据标签分类查看题目](question/get_by_tag.md)
  + [根据科目分类查看题目](question/get_by_subject.md)
  + [根据类型分类查看题目](question/get_by_type.md)
  + [查看所有题目](question/get_all.md)

+ ### student
  + [注册](student/register.md)
  + [登录](student/login.md)
  + [关注老师](student/follow_teacher.md)
  + [取消关注老师](student/unfollow_teacher.md)
  + [获取关注的老师](student/get_teachers.md)

+ ### teacher
  + [注册](teacher/register.md)
  + [登录](teacher/login.md)
  + [获取所有老师](teacher/get_all.md)
  + [取消关注学生](teahcer/unfollow_student.md)
  + [获取关注自己的学生](teacher/get_students.md)

+ ### subject
  + [获取全部科目](subject/get.md)

+ ### type
  + [获取全部类型](type/get.md)

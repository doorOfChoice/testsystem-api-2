#  根据id获取题目的详细信息

## GET [/question/{question_id}]
+ 说明

  详细信息包括题目的具体选项，正确答案

+ 参数
  + url
    + question_id : question的id, 整数

+ 数据类型
  + application/json

+ 响应
  + Body
        {
          datas : {
                "id" : 题目id,
                "teacher_id" : 创建人id,
                "type_id" : 类型id,
                "content" : 问题内容,
                "hot" : 热度,
                "subject_id" : 科目id,
                "difficulty" : 难度,
                "subject_name" : 科目名字,
                "type_name" : 类型名字,
                "tags" : [
                  {
                    "id" : 标签id,
                    "name" : 标签名字
                  },
                  ...
                ],
                "options" : [
                  {
                    "id" : 选项id,
                    "content" : 选项内容,
                    "correct" : 选项是否正确
                  },
                  ...
                ]  
          },
          status: ""
        }
  + HTTP Code
    + 获取成功 200
    + 题目不存在 404 

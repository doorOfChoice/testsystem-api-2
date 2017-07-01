#  查看学生提交的试卷

## GET [/paper/{pid}/student/{sid}/teacher/{tid}]
+ 说明

  登录即可使用，相对普通获取详情，多了得分和description(答案描述)
+ 参数
   + url
     + sid : 学生账户,字符串
     + pid : 试卷id, 整数
     + tid : 老师id, 字符串
   + header
     + token : 登录令牌

+ 数据类型
  + application/json

+ 响应
  + Body
        {
          datas : {
            "questions": [
            {
              "id" : 题目id,
              "teacher_id" : 创建人id,
              "type_id" : 类型id,
              "content" : 问题内容,
              "hot" : 热度,
              "subject_id" : 科目id,
              "difficulty" : 难度,
              "subject_name" : 科目名字,
              "type_name" : 类型名字,
              "grade"     : 得到的分数,
              "description" : 学生填写的答案(如果为简答题，为单纯的字符串；如果是其他题型，返回的是用逗号隔开的选项id)
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
    + 获取成功 204
    + 未登录/无权限 401
    + 科目不存在 404

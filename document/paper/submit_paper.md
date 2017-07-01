#  学生提交做了的试卷

## POST [/paper/validity]
+ 说明

  仅限学生使用
  可以分页

+ 参数
   + payload
     + paper_id : 试卷id, 整数
     + answers : 回答对象数组
     ```
      回答对象
      {
        "id" : 问题id,
        "reply" : 多选，单选，判断题的答案，选项数组. ex [12, 13],
        "description" : 简答题答案，字符串。当题目类型不为简答题的时候，可以忽略这个参数
      }
     ```
   + header
     + token : 登录令牌

+ 数据类型
  + application/json

+ 响应
  + Body
  ```
        {
          datas : [],
          status: ""
        }
  ```
  + HTTP Code
    + 提交成功 201
    + 未登录/无权限 401
    + 非法操作 403
    + 参数错误 422
    + 重复提交 500

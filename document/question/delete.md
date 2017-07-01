#  删除题目

## DELETE [/question/{question_id}]
+ 说明

  仅限教师使用

+ 参数
   + header
     + token : 登录令牌
+ 数据类型
  + application/json

+ 响应
  + Body
        {
          datas : [],
          status: ""
        }
  + HTTP Code
    + 删除成功 204
    + 题目不存在 404
    + 未登录/无权限 401

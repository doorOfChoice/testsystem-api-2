#  删除试卷

## DELETE [/paper/{paper_id}]
+ 说明

  仅限教师使用

+ 参数
   + url
     + paper_id : 试卷id, 整数
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
    + 删除成功 204
    + 未登录/无权限 401
    + 试卷不存在 404

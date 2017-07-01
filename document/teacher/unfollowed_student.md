# 老师删除关注自己的学生

## POST [/teacher/student/{student_id}]

+ 参数
  + url
    + student_id: 学生的id
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
    + 没有登录/没有权限 401
    + 学生不存在 404

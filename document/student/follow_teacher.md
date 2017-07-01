# 学生关注老师

## POST [/teacher]

+ 参数
  + payload
    + teacher_id : 老师id
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
    + 关注成功 201
    + 老师不存在 404
    + 参数不正确 422

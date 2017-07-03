# 老师注册

## POST [/teacher]

+ 参数
  + payload
    + username 字符串4~11位，只能为数字和英文
    + password 字符串4~11位，只能为数字和英文

+ 数据类型
  + application/json

+ 响应
  + Body
  ```
        {
          datas : {
              id : 0
          },
          status: ""
        }
  ```
  + HTTP Code
    + 用户已经存在 200
    + 注册成功 201
    + 参数不正确 422

# 学生登录

## POST [/student/session]

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
          datas : [
            "token" : 登录令牌，权限操作全部放在头里面
          ],
          status: ""
        }
  ```
  + HTTP Code
    + 登录成功 200
    + 密码错误 401
    + 用户不存在 404

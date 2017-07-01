#  新建试卷

## POST [/paper]
+ 说明

  仅限教师使用

+ 参数
   + payload
     + title : 试卷标题, 字符串
     + subject_id : 试卷科目, 整数
   + header
     + token : 登录令牌

+ 数据类型
  + application/json

+ 响应
  + Body
  ```
        {
          datas : {
            "title": 试卷标题,
            "subject_id": 科目id,
            "teacher_id": 创建人id,
            "id": 试卷id
          },
          status: ""
        }
  ```
  + HTTP Code
    + 创建成功 201
    + 未登录/无权限 401
    + 科目不存在 404
    + 参数问题 422

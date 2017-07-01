# 学生取消关注老师

## DELETE [/teacher/{teacher_id}]

+ 参数
  + url
    + teacher_id : 老师id
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
    + 取消关注成功 204
    + 老师不存在 404

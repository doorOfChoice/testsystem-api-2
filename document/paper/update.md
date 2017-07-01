#  更新试卷基本信息

## PUT [/paper/{paper_id}]
+ 说明

  仅限教师使用
  基本信息包括试卷标题，是否设置密码，密码

+ 参数
   + url
     + paper_id : 试卷id, 整数
   + payload
     + title : 要修改为的试卷标题, 字符串
     + has_password : 是否设置密码, 布尔值(0 or 1)
     + password : 密码，字符串 (仅当has_password为1时有效)
   + header
     + token : 登录令牌

+ 数据类型
  + application/json

+ 响应
  + Body
        {
          datas : {
            "title": 试卷标题,
            "subject_id": 科目id,
            "teacher_id": 创建人id,
            "has_password" : 是否设置密码,
            "id": 试卷id
          },
          status: ""
        }
  + HTTP Code
    + 更新成功 200
    + 未登录/无权限 401
    + 非法操作 403
    + 试卷不存在 404
    + 参数问题 422

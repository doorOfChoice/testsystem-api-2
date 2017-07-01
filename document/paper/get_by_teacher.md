#  查看某一老师下的试卷

## GET [/paper/teacher/{teacher_id}]

+ 说明

  登录即可使用
  可分页
  
+ 参数
   + url
     + teacher_id : 老师id,字符串
   + header
     + token : 登录令牌

+ 数据类型
  + application/json

+ 响应
  + Body
        {
          datas : {
            "papers": [
              {
                "id" : 试卷id,
                "teacher_id" : 创建人id,
                "create_date" : 创建日期,
                "update_date" : 修改日期,
                "subject_id" : 科目id,
                "title" : 试卷标题,
                "has_password" : 是否设有密码,
                "subject_name" : 科目名称，
              },
              ...
            ],
            "curPage": 当前页,
            "count": 当前页试卷数量,
            "lastPage": 最后一页下标,
            "perPage": 每一页最大数量
          },
          status: ""
        }
  + HTTP Code
    + 获取成功 204
    + 未登录/无权限 401
    + 试卷不存在 404

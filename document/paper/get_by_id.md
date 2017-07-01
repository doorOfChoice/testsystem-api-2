#  查看试卷的详细信息

## GET [/paper/{paper_id}?password=xx]

+ 说明

  登录即可使用

+ 参数
   + url
     + paper_id : 科目id,整数
     + password : 密码，(可选)，当试卷设置了密码的时候启用
   + header
     + token : 登录令牌

+ 数据类型
  + application/json

+ 响应
  + Body
  ```
        {
          datas : {
            "id" : 试卷id,
            "teacher_id" : 创建人id,
            "create_date" : 创建日期,
            "update_date" : 修改日期,
            "subject_id" : 科目id,
            "title" : 试卷标题,
            "has_password" : 是否设有密码,
            "subject_name" : 科目名称，
            "questions" : [{
              "id" : 题目id,
              "teacher_id" : 创建人id,
              "type_id" : 类型id,
              "content" : 问题内容,
              "hot" : 热度,
              "subject_id" : 科目id,
              "difficulty" : 难度,
              "subject_name" : 科目名字,
              "type_name" : 类型名字,
              "grade"     : 分数
              "tags" : [
                {
                  "id" : 标签id,
                  "name" : 标签名字
                },
                ...
              ],
              "options" : [
                {
                  "id" : 选项id,
                  "content" : 选项内容,
                  "correct" : 选项是否正确
                },
                ...
              ]  
            },
            ...
            ]
          },
          status: ""
        }
    ```
  + HTTP Code
    + 获取成功 204
    + 未登录/无权限 401
    + 试卷不存在 404

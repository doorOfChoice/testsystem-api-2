#  随机生成试题

## GET [/paper/subject/{subject_id}/tag/{tagnames}]
+ 说明

  仅限教师使用

+ 参数
   + url
     + subject_id : 科目id,整数
     + tag : 字符串数组(如果想省略，请填写[])，该数组需要url编码
   + header
     + token : 登录令牌

+ 数据类型
  + application/json

+ 响应
  + Body
  ```
        {
          datas : [
            {
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
            }
          ],
          status: ""
        }
    ```
  + HTTP Code
    + 获取成功 200
    + 未登录/无权限 401
    + 科目不存在 404

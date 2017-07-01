# 老师获取关注自己的学生

## POST [/teacher/student]
+ 说明

  学生每页只显示15个

+ 参数
  + header
    + token: 登录返回的token

+ 数据类型
  + application/json

+ 响应
  + Body
        {
          datas : [
          "last_page": 最后一页下标,
          "next_page_url": 下一页的url,
          "path": 请求地址,
          "per_page": 每页最多显示数量,
          "prev_page_url": 上一页的url,
          "total": 本页一共有多少数量,
          "data" : [
            {
              "id" : 学生id,
              "name" : 学生昵称
            },
            ...
          ],
          status: ""
        }

  + HTTP Code
    + 获取成功 200
    + 无权限/没登录 401

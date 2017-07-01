# 获取所有题目类型

## GET [/type]

+ 参数

+ 数据类型
  + application/json

+ 响应
  + Body
        {
          datas : [
            {
              id : 类型id
              name : 类型名称
            },
            ...
          ],
          status: ""
        }
  + HTTP Code
    + 成功获取 200

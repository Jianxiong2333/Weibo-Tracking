# Weibo-Tracking
向邮箱推送指定新浪微博用户的微博更新并且在数据库中同步数据。
## 文件修改
  &ensp;index.php <br>
    &ensp;&ensp;&ensp;&ensp;需要修改 $url_api 为微博手机免登录API。<br>
    &ensp;&ensp;&ensp;&ensp;需要修改 数据库信息 为 MySQL 数据库信息。<br>
    &ensp;&ensp;&ensp;&ensp;需要修改 $mailer->send 为发件信息。<br>
  &ensp;PHPMailer\SendMailer.php<br>
    &ensp;&ensp;&ensp;&ensp;需要修改 QQMailer 为邮箱 SMTP 信息。<br>
## 数据保存
  &ensp;将数据库文件导入数据库后连接即可测试抓取保存。<br>
## 定时监控
  &ensp;测试完毕后添加新建定时任务或监控接口以便正常跟踪用户更新，访问频率可自由设置。<br>
## 微博取证
  &ensp;循环创建实例并修改接口分页可以直接 镜像/取证/固定 用户全部微博。<br>

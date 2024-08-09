该项目使用phpMyAdmin数据库、html、css、js等前后端知识完成
操作步骤：
1.启动phpstudy_pro的Apache2.4.39和MySQL5.7.26套件，再将interst-circle文件夹中的index.html在浏览器上运行
2.进行注册登录
3.进入兴趣圈.html后点击右上角的创建按钮即可创建自己的兴趣圈
4.进入兴趣圈后可进行发帖（可上传照片）、评论
5.每个兴趣圈页面左上角会显示用户活跃度。

由于个人操作和家中网络问题，导致打包后的WWW.exe无法使用Node.js运行，原因好像是应用程序依赖于浏览器环境中的 document 对象，但在 Node.js 环境中是不存在的，因此导致了 ReferenceError: document is not defined 错误，所以该项目文件只能通过网页打开 ，要修改的话可能有些复杂，所以就放弃进一步优化了（能力不够，实在抱歉：(  ）
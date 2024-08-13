该项目使用phpMyAdmin数据库、html、css、js等前后端知识完成
操作步骤：
1.先下载phpstudy_pro软件，我是按照 https://www.bilibili.com/video/BV1S3411T7R7/?spm_id_from=333.337.search-card.all.click&vd_source=0138c3e3169bdcbe4ccfd636830bb585 配置的php环境，再启动phpstudy_pro首页的Apache2.4.39和MySQL5.7.26套件，打开右上角的数据库工具的phpMyAdmin，我在里面建立名为lo_db的数据库，创建了四个表：
comments{
    username;content;circlename;comments_id;post_id;
}
tbuild{
    circlename;
}
tcircle{
    circlename;username;content;image_path;post_id;
}
tuser{
    name;password;email;total_score;
}
2.将项目里的interst_circle文件夹中的index.html在浏览器上运行
3.进行注册登录
4.跳转到“兴趣圈.html”后点击右上角的创建按钮即可创建自己的兴趣圈
5.进入兴趣圈页面后可进行发帖（可上传照片）、评论
6.每个兴趣圈页面左上角会显示用户活跃度，发帖、评论会提高活跃度。

由于个人操作和家中网络问题，导致打包后的WWW.exe无法使用Node.js运行，原因好像是应用程序依赖于浏览器环境中的 document 对象，但在 Node.js 环境中是不存在的，因此导致了 ReferenceError: document is not defined 错误，所以该项目文件只能通过网页打开 ，要修改的话可能有些复杂，所以就放弃进一步优化了（尝试了网上许多办法都没成功，能力不够，实在抱歉：( ）
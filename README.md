### 前言
写文章想要配图，但是懒得挑图？
网页背景千遍一律？

最早的时候，经常听说“漫月API”，就很好奇这个是什么东东，因为“漫月”一词勾起了我的好感……

在学长最初布置博客的时候，写文章都会挑选一张图给配上，避免页面太过单调，虽然学长我主张简洁、单栏展示的网页界面，但还是觉得有那么点缀还是舒服点呢 ~

于是，就有了自己的私用随机图服务了。

还是老样子，把代码整理一番，放到 GitHub 上面去……

### 特性
- 完全隐藏图片文件的真实地址
- 支持调用域名白名单
- 支持多文件夹分类目录
- 前端调用支持使用随机数载入

### 部署
1. 下载代码，解压至你域名文件夹根目录
2. 开启 Apache 或者 Nginx 的伪静态功能
3. 访问：你的域名/images
4. 大功告成

### 配置
打开 images.php 文件，添加域名白名单与默认文件夹即可。
照葫芦画瓢，不用多说了吧。

**多文件夹说明：**
第二个文件夹无需配置，直接使用 URL 传递参数即可。

比如：
默认文件夹的分类，调用的域名是：“ 你的域名/images ”  
其它文件夹的分类，调用是域名是：“ 你的域名/images/文件夹名 ”

注意！
若要使用随机数调用，必须启用 Apache 或者 Nginx 的伪静态功能，否则空白输出。  
Nginx 用户需要手动添加 nginx.conf 文件里面的伪静态规则到你的域名配置中去……

使用随机数载入的情况通常在一个页面多次调用随机图的时候，比如首页文章列表，否则图片都是一样的。

随机数载入方式：“ 你的域名/images?随机数 ” ，就是原有 URL 上添加一个英文问号和任意随机数。

示例：
```html
<img src="https://song.acg.sx/images">
<img src="https://song.acg.sx/images/acg">
<img src="https://song.acg.sx/images?d8c196951e5bbf3edd158de4">
<img src="https://song.acg.sx/images/acg?9f0d34f8ee6f96b56d8902d1">
```

项目演示：[https://song.acg.sx/images](https://song.acg.sx/images "")  
项目代码：[https://github.com/galnetwen/Random-Image](https://github.com/galnetwen/Random-Image "")

该随机图代码由 [karnc](https://karnc.com/ "") 提供与帮助，谢谢他！
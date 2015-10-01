<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="text/javascript" src="./resource/js/jQuery/jquery-1.7.2.min.js"></script>
    <link rel="stylesheet" type="text/css" href="./resource/login/css/base.css" />
    <link rel="stylesheet" type="text/css" href="./resource/login/css/style.css" />
    <title>胜网教育</title>
    <script type="text/javascript">
        $(function(){
            /*鼠标点击密码框焦点*/
            $(".kt_loginInputP").focus(function(){
                $(this).next().hide();
            });
            $(".kt_loginInputP").blur(function(){
                if($(".kt_loginInputP").val()==""){
                    $(this).next().show();
                }
                //$(this).val("");
            });
            $(".kt_loginInputP_font").click(function(){
                $(this).hide().prev().focus();

            });
            $("#login-form").submit(function(){
                var user=$("input[name='username']").val();
                var pass=$("input[name='password']").val();
                if(user=='' || user=='用户名/邮箱/手机'){
                    alert("用户名不能为空");
                }
                if(pass=='' || pass=='请输入您的密码'){
                    alert("密码不能为空");
                }
                //异步登录
                $.ajax({url: "/user.php?action=user-login", type:"POST",data: {username: escape(user),password: escape(pass)},
                    success: function(dataStr) {
                        var data = eval('('+dataStr+')');
                        if(data.state=="ok")
                        {
                            document.location.href="/index.html";
                            return;
                        }else{
                           alert('登录失败!');
                        }
                    },
                    error: function(XMLHttpRequest, textStatus) {
                        alert('登陆失败');
                    }
                });

                return false;
            });
        });
    </script>
</head>
<body>
<div class="container">
    <div class="contain">
        <form id="login-form" action="#" method="post">
            <!--头部-->
            <header>
                <div class="w " style="height:55px;">
                    <!--头部信息-->
                    <div class="web_headerBg web_headerPR">
                        <div class="web_header bc">
                            <!-- <div class="ml25"><a href="#"><img src="images/kt_logo.png" /></a></div>-->
                        </div>
                    </div>
                    <!--头部信息 end-->
                </div>
            </header>
            <!--头部 end-->
            <!--头部网站地图-->
            <hgroup>
                <div class="w h20">
                    <div class="web_headerMap web_headerPR"></div>
                </div>
            </hgroup>
            <!--头部网站地图 end-->
            <!--网页内容-->
            <div class="contain bc hidden">
                <div class="content bc  pt35" style="width:960px;">
                    <!--中部-->
                    <div class="kt_loginBg clearfix">
                        <!--登录框-->
                        <div class="kt_login">
                            <div class="w200 bc">
                                <h1 class="font-y color-7 fb f16 mt20">欢迎使胜网教育</h1>
                                <div>
                                    <input class="kt_loginInputN" style="color: rgb(153, 153, 153);" value="用户名/邮箱/手机" onfocus="if(this.value==&#039;用户名/邮箱/手机&#039;) this.value=&#039;&#039;;this.style.color=&#039;#333&#039;" onblur="if(this.value==&#039;&#039;) {this.value=&#039;用户名/邮箱/手机&#039;;this.style.color=&#039;#999999&#039;}" tabindex="1" name="username" id="LoginForm_username" type="text" />                        </div>
                                <div class="pr">
                                    <input class="kt_loginInputP color-5" style="color: rgb(153, 153, 153);" value="" onblur="if(this.value==&#039;&#039;) {this.value=&#039;请输入您的密码&#039;;this.type=&#039;text&#039;;this.style.color=&#039;#999999&#039;}" onfocus="if(this.value==&#039;请输入您的密码&#039;) this.value=&#039;&#039;;this.type=&#039;password&#039;;this.style.color=&#039;#333&#039;" tabindex="1" name="password" id="LoginForm_password" type="password" />                        </div>

                                <div class="f12 mt10">
                                    <div class="fl"><label>
                                            <input id="ytLoginForm_rememberMe" type="hidden" value="0" name="LoginForm[rememberMe]" /><input class="fl mt1" style="*margin-top:-4px;_margin-top:-4px;" name="LoginForm[rememberMe]" id="LoginForm_rememberMe" value="1" type="checkbox" />                            <span class="fl ml5">记住登录状态</span></label></div>
                                    <input name="LoginForm[passwordMD5]" id="LoginForm_passwordMD5" type="hidden" />                            <div class="fr ml10 unl_a"><a href="/index.php?r=user/getPwd">忘记密码？</a></div>
                                    <div class="cb cb_h"></div>
                                </div>
                                <div class="pt15">
                                    <input class="kt_loginBut" type="submit" name="yt0" value="" id="yt0" />						</div>
                                <div class="w200 h20 pt10 hidden">
                                    <!--错误信息提示-->
                                    <p class="red f12 none" id="loginTip">您输出的密码不正确！</p>
                                    <!--错误信息提示 end-->
                                </div>
                                <div class="mt5">
                                    <div class="kt_loginBut2 fr"><a href="register.html"></a></div>
                                    <div class="fr color-4_1 f12 mt8 mr5">还没有账号？</div>
                                    <div class="cb cb_h"></div>
                                </div>
                            </div>
                        </div>
                        <!--登录框 end-->
                    </div>
                    <!--中部 end-->
                    <!--底部介绍-->
                    <div class="w mt50 pb50 clearfix">
                        <div class="kt_loginImg1 ml30 font-y fl">
                            <h2 class="f24">为老师助力</h2>
                            <P class="mt10">海量优质资源助力课堂创新教学</P>
                            <P class="mt5">在线备课、自由组卷</P>
                            <P class="mt5">预习反馈、布置作业</P>
                        </div>
                        <div class="kt_loginImg2 ml25 font-y fl">
                            <h2 class="f24">为学生减负</h2>
                            <P class="mt10">提高自主学习与沟通交流能力</P>
                            <P class="mt5">课前预习、课堂探究</P>
                            <P class="mt5">在线问答、课后作业</P>
                        </div>
                        <div class="kt_loginImg3 ml25 font-y fl">
                            <h2 class="f24">为家长分忧</h2>
                            <P class="mt10">实时科学掌握孩子学习动态</P>
                            <P class="mt5">家校互动、学业报表</P>
                            <P class="mt5">亲子教育、课程推荐</P>
                        </div>
                    </div>
                    <!--底部介绍 end-->
                </div>
            </div>
            <!--网页内容 end-->
        </form>
    </div>
</div>
<div class="footer bc tc">
    <p class="pt15">指导单位：教育部教育管理信息中心&nbsp;&nbsp;研究支持：广东胜网科技有限公司&nbsp;&nbsp;平台提供：广东胜网科技有限公司</p>
</div></body>
</html>
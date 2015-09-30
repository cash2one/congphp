jQuery.cookie=function(name,value,options){if(typeof value!='undefined'){options=options||{};if(value===null){value='';options.expires=-1}var expires='';if(options.expires&&(typeof options.expires=='number'||options.expires.toUTCString)){var date;if(typeof options.expires=='number'){date=new Date();date.setTime(date.getTime()+(options.expires*24*60*60*1000))}else{date=options.expires}expires='; expires='+date.toUTCString()}var path=options.path?'; path='+(options.path):'';var domain=options.domain?'; domain='+(options.domain):'';var secure=options.secure?'; secure':'';document.cookie=[name,'=',encodeURIComponent(value),expires,path,domain,secure].join('')}else{var cookieValue=null;if(document.cookie&&document.cookie!=''){var cookies=document.cookie.split(';');for(var i=0;i<cookies.length;i++){var cookie=jQuery.trim(cookies[i]);if(cookie.substring(0,name.length+1)==(name+'=')){cookieValue=decodeURIComponent(cookie.substring(name.length+1));break}}}return cookieValue}};
;(function($){
	$.fn.autoTextarea=function(options){var defaults={maxHeight:null,minHeight:$(this).height()};var opts=$.extend({},defaults,options);return $(this).each(function(){$(this).bind("paste cut keydown keyup focus blur",function(){var height,style=this.style;this.style.height=opts.minHeight+'px';if(this.scrollHeight>opts.minHeight){if(opts.maxHeight&&this.scrollHeight>opts.maxHeight){height=opts.maxHeight;style.overflowY='scroll'}else{height=this.scrollHeight;style.overflowY='hidden'}style.height=height+'px'}})})}})(jQuery);
String.prototype.strip_tags=function (allow) {
	var allow = allow ? allow.toLowerCase() : '';
	return this.replace(/<[\/\!\?]?([\w_-]*)[^>]*>/igm , function($0, $1) {
		return allow.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
	});
}
function tip(html){
	var showTip=$('#tip');
	showTip.animate({height:'42px'},300).html(html);
	setTimeout(function(){showTip.animate({height:'0px'},300).html('');},2000);
}
var YUUR={
	Init:function(){
		YUUR.scrolltop();
		$(function(){
			$("textarea[name=content]").autoTextarea({maxHeight:220});
			$("#totop").scrollToTop();
		});
	},
	getComment:function(id){
		$.ajax({
			type:'GET',
			url:'/view.php?action=comment-list&tid='+id,
			success:function(result){
				$("#comment").html(result);
				var cookie_comment_name=$.cookie('comment_name');
				var cookie_comment_email=$.cookie('comment_email');
				if(cookie_comment_name!=null&&$('#nickname').val()==''){
					$('#nickname').val(cookie_comment_name);	
				}
				if(cookie_comment_email!=null&&$('#email').val()==''){
					$('#email').val(cookie_comment_email);	
				}
				if($('#nickname').val()!=''&&$('#email').val()!=''){
					var welcome='',
						isShowinput=$('#welcome');
					welcome+='<div style="line-height:24px;font-size:14px;height:30px;">匿名网友 ';
					welcome+='<strong>'+cookie_comment_name+'</strong> 回应：</div>';
					if(isShowinput){
						$('#content').on('click',function(e){
							isShowinput.html(welcome);
							$(this).animate({height:'80px'},200);
						});
					}
				}else{
					$('#content').on('click',function(e){
						$('.showinput').show();
						$(this).animate({height:'80px'},200);
					});
				}
				$('#comment-submit').on('click',function(e){
					e.preventDefault();
					var nickname=$.trim($('#nickname').val());
					var email=$.trim($('#email').val());
					var content=$.trim($('#content').val());
					var reg=/([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)/;
					if(nickname==''){
						tip("昵称不能为空");
						$('#nickname').focus();
						return false;
					}
					if(email==''){
						tip("邮箱不能为空");
						$('#email').focus();
						return false;
					}
					if(!reg.test(email)){
						tip("邮箱地址不正确");
						$('#email').focus();
						return false;
					}
					if(content==''){
						tip("内容不能为空");
						$('#content').focus();
						return false;
					}
					var emailTo=$.trim($('#emailTo').val());
					$.cookie('comment_name',nickname.strip_tags());
					$.cookie('comment_email',email.strip_tags());
					$.ajax({
						type:'GET',
						url:'/view.php?action=comment&tid='+id+'&nickname='+encodeURIComponent(nickname)+'&email='+encodeURIComponent(email)+'&content='+encodeURIComponent(content)+'&emailTo='+encodeURIComponent(emailTo)+'&ran='+Math.round(Math.random()*10000),
						dataType:"text",
						beforeSend:function(){ 
							$('#comment-submit').val('提交中...');
						},
						success:function(e){
							tip("\u56de\u5e94\u6210\u529f");
							YUUR.getComment(id);
						}
					});
				});
			}
		});
	},
	update_click:function(id){
		$.ajax({
			type:'GET',
			url:'/view.php?action=click&tid='+id,
			success:function(result){
				$("#click_count").html(result);
			}
		});
	},
	replyDel:function(pid,tid){
		$.ajax({
			type: "GET",
			url: "/view.php?action=delete&pid="+pid,
			success: function() {
				tip("删除成功");
				YUUR.getComment(tid);
			}
		});
	},
	scrolltop:function(){
		$.fn.scrollToTop=function(){
			var me=$(this);
			$(window).scroll(function(){
				if($(window).scrollTop()<10){
					me.fadeOut();
				}else{
					me.fadeIn();
				}
			});
			me.click(function(){
				$("html,body").animate({scrollTop:0});return false;
			});
		}
	},
	topictid:function(a) {
		$.ajax({
			type: "GET",
			url: "/view.php?action=top&tid=" + a,
			success: function() {
				tip("\u5e16\u5b50\u63a8\u9001\u6210\u529f\uff0c\u611f\u8c22\u60a8\u7684\u63a8\u8350");
			}
		});
	},
	emoji:function(){
		var emoji='';
		emoji+='<img src="/common/emot/0.gif"alt=""title="调皮"/><img src="/common/emot/1.gif"alt=""title="惊讶"/><img src="/common/emot/2.gif"alt=""title="撇嘴"/><img src="/common/emot/3.gif"alt=""title="色"/><img src="/common/emot/4.gif" alt="" title="发呆"/><img src="/common/emot/5.gif" alt="" title="得意"/><img src="/common/emot/6.gif" alt="" title="害羞"/><img src="/common/emot/7.gif" alt="" title="闭嘴"/><img src="/common/emot/8.gif" alt="" title="睡"/><img src="/common/emot/9.gif" alt="" title="流泪"/><img src="/common/emot/10.gif" alt="" title="尴尬"/><img src="/common/emot/11.gif" alt="" title="发怒"/><img src="/common/emot/12.gif" alt="" title="可怜"/><img src="/common/emot/13.gif" alt="" title="大笑"/><img src="/common/emot/14.gif" alt="" title="微笑"/><img src="/common/emot/15.gif" alt="" title="难过"/><img src="/common/emot/16.gif" alt="" title="酷"/><img src="/common/emot/17.gif" alt="" title="抓狂"/><img src="/common/emot/18.gif" alt="" title="吐"/><img src="/common/emot/19.gif" alt="" title="偷笑"/><img src="/common/emot/20.gif" alt="" title="可爱"/><img src="/common/emot/21.gif" alt="" title="白眼"/><img src="/common/emot/22.gif" alt="" title="傲慢"/><img src="/common/emot/23.gif" alt="" title="饥饿"/><img src="/common/emot/24.gif" alt="" title="困"/><img src="/common/emot/25.gif" alt="" title="惊恐"/><img src="/common/emot/26.gif" alt="" title="汗"/><img src="/common/emot/27.gif" alt="" title="憨笑"/><img src="/common/emot/28.gif" alt="" title="牛逼"/><img src="/common/emot/29.gif" alt="" title="奋斗"/><img src="/common/emot/30.gif" alt="" title="疑惑"/><img src="/common/emot/31.gif" alt="" title="安静"/><img src="/common/emot/32.gif" alt="" title="晕"/><img src="/common/emot/33.gif" alt="" title="衰"/><img src="/common/emot/34.gif" alt="" title="骷髅"/><img src="/common/emot/35.gif" alt="" title="敲打"/><img src="/common/emot/36.gif" alt="" title="分手"/><img src="/common/emot/37.gif" alt="" title="发抖"/><img src="/common/emot/38.gif" alt="" title="喜欢"/><img src="/common/emot/39.gif" alt="" title="跳跳"/><img src="/common/emot/40.gif" alt="" title="猪"/><img src="/common/emot/41.gif" alt="" title="拥抱"/><img src="/common/emot/42.gif" alt="" title="蛋糕"/><img src="/common/emot/43.gif" alt="" title="劈死你"/><img src="/common/emot/44.gif" alt="" title="炸死你"/><img src="/common/emot/45.gif" alt="" title="刀"/><img src="/common/emot/46.gif" alt="" title="祈福"/><img src="/common/emot/47.gif" alt="" title="便便"/><img src="/common/emot/48.gif" alt="" title="亲"/><img src="/common/emot/49.gif" alt="" title="米饭"/><img src="/common/emot/50.gif" alt="" title="玫瑰"/><img src="/common/emot/51.gif" alt="" title="花谢"/><img src="/common/emot/52.gif" alt="" title="爱"/><img src="/common/emot/53.gif" alt="" title="好"/><img src="/common/emot/54.gif" alt="" title="礼物"/><img src="/common/emot/55.gif" alt="" title="太阳"/><img src="/common/emot/56.gif"alt=""title="月亮"/><img src="/common/emot/57.gif"alt=""title="赞"/><img src="/common/emot/58.gif"alt=""title="踩"/><img src="/common/emot/59.gif"alt=""title="握手"/><img src="/common/emot/60.gif"alt=""title="飞吻"/><img src="/common/emot/61.gif"alt=""title="大叫"/><img src="/common/emot/62.gif"alt=""title="西瓜"/><img src="/common/emot/63.gif"alt=""title="冷汗"/><img src="/common/emot/64.gif"alt=""title="抠鼻"/><img src="/common/emot/65.gif"alt=""title="欢呼"/><img src="/common/emot/66.gif"alt=""title="糗大了"/><img src="/common/emot/67.gif"alt=""title="坏笑"/><img src="/common/emot/68.gif"alt=""title="不理你"/><img src="/common/emot/69.gif"alt=""title="不理你"/><img src="/common/emot/70.gif"alt=""title="打哈欠"/><img src="/common/emot/71.gif"alt=""title="鄙视"/><img src="/common/emot/72.gif"alt=""title="委屈"/><img src="/common/emot/73.gif"alt=""title="想哭"/><img src="/common/emot/74.gif"alt=""title="阴笑"/><img src="/common/emot/75.gif"alt=""title="亲亲"/><img src="/common/emot/76.gif"alt=""title="吓"/><img src="/common/emot/77.gif"alt=""title="广场舞"/><img src="/common/emot/78.gif"alt=""title="菜刀"/><img src="/common/emot/79.gif"alt=""title="啤酒"/>';
		return emoji;
	}
}
YUUR.Init();
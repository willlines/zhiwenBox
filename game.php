<?php
require_once "jssdk.php";
$jssdk = new JSSDK("wxe76912e8e1f48de0", "d5f8cbad45aebf9ecc4d2279f0f731e7");
$signPackage = $jssdk->GetSignPackage();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>超级好玩的游戏</title>
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <style type="text/css">
    * {
      margin: 0;
      padding: 0;
    }
    #box {
      width: 36vw;
      height: 36vw;
      margin: 20% auto;
      border-radius: 100%;
      background-color: blue;
      color: #fff;
      font-size: 32px;
      text-align: center;
      line-height: 36vw;
      font-family: "Microsoft Yahei";
      -webkit-user-select: none;
      user-select: none;
    }
    #tips {
      margin: 5% 12%;
    }
    #timerBar {
      margin: 5%;
      font-family: "Microsoft Yahei";
      -webkit-user-select: none;
      user-select: none;
    }
  </style>
</head>
<body>

  <a href="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxe76912e8e1f48de0&redirect_uri=http%3A%2F%2Fzhiwenlao.duapp.com%2Fgame.php&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect">授权登录</a>

  <div id="timerBar">剩余时间：<span>60</span></div>
  <div id="box">0</div>
  <div id="topbar"><a href="###" id="topbara">排行榜</a></div>
  <p id="tips">
    游戏说明：在规定时间内点击蓝色框的次数多者胜
  </p>
  <?php
    // $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxe76912e8e1f48de0&redirect_uri=http%3A%2F%2Fzhiwenlao.duapp.com%2Fgame.php&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect";

      
      $code = $_GET["code"];
      $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=wxe76912e8e1f48de0&secret=d5f8cbad45aebf9ecc4d2279f0f731e7&code={$code}&grant_type=authorization_code"
      $content = json_decode(file_get_contents($url));
      $token = $content -> access_token;
      $openid = $content -> openid;

      #拉取用户的信息
      $infoUrl = "https://api.weixin.qq.com/sns/userinfo?access_token={$token}&openid={$openid}&lang=zh_CN"

  ?>
  <button id="btn">点击分享朋友</button>
  <script type="text/javascript">
    var $ = function(id) {
      return document.getElementById(id);
    },
      timerBar = $("timerBar").children[0];
      box   = $("box"),
      tips  = $("tips"),
      timerId = 0,
      nowTime = 6,
      score   = 0;


    timerId = setInterval(function() {
      nowTime--;
      timerBar.innerHTML = nowTime;
      if(nowTime <= 0) {
        clearInterval(timerId);
        box.removeEventListener("touchstart", add, false)
      }
    }, 1000)


    function add() {
      box.innerHTML = ++score;
    }
    box.addEventListener("touchstart", add, false);

  </script>
</body>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
  /*
   * 注意：
   * 1. 所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
   * 2. 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
   * 3. 常见问题及完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
   *
   * 开发中遇到问题详见文档“附录5-常见错误及解决办法”解决，如仍未能解决可通过以下渠道反馈：
   * 邮箱地址：weixin-open@qq.com
   * 邮件主题：【微信JS-SDK反馈】具体问题
   * 邮件内容说明：用简明的语言描述问题所在，并交代清楚遇到该问题的场景，可附上截屏图片，微信团队会尽快处理你的反馈。
   */
  wx.config({
    debug: false,
    appId: '<?php echo $signPackage["appId"];?>',
    timestamp: <?php echo $signPackage["timestamp"];?>,
    nonceStr: '<?php echo $signPackage["nonceStr"];?>',
    signature: '<?php echo $signPackage["signature"];?>',
    jsApiList: [
      // 所有要调用的 API 都要加到这个列表中
      'onMenuShareTimeline',
        'onMenuShareAppMessage',
        'onMenuShareQQ',
        'onMenuShareWeibo',
        'onMenuShareQZone',
        'hideMenuItems',
        'showMenuItems',
        'hideAllNonBaseMenuItem',
        'showAllNonBaseMenuItem',
        'translateVoice',
        'startRecord',
        'stopRecord',
        'onVoiceRecordEnd',
        'playVoice',
        'onVoicePlayEnd',
        'pauseVoice',
        'stopVoice',
        'uploadVoice',
        'downloadVoice',
        'chooseImage',
        'previewImage',
        'uploadImage',
        'downloadImage',
        'getNetworkType',
        'openLocation',
        'getLocation',
        'hideOptionMenu',
        'showOptionMenu',
        'closeWindow',
        'scanQRCode',
        'chooseWXPay',
        'openProductSpecificView',
        'addCard',
        'chooseCard',
        'openCard'
    ]
  });
  var btn = document.getElementById("btn");
 btn.onclick = function(){
  wx.onMenuShareQQ({
    title: '当然是选择原谅她', // 分享标题
    desc: '男人看了沉默，女人看了流泪' + score, // 分享描述
    link: '', // 分享链接
    imgUrl: 'http://img5.imgtn.bdimg.com/it/u=2514909625,3167485610&fm=11&gp=0.jpg', // 分享图标
    success: function () { 
       // 用户确认分享后执行的回调函数
    },
    cancel: function () { 
       // 用户取消分享后执行的回调函数
    }
});
  }
</script>
</html>
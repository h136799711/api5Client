# dbh/api5client

1. api5 客户端调用

## 简介

1. 对接了登录校验接口

```

$loginSessionApi = new LoginSessionApi();
// 请求接口域名地址
$loginSessionApi->setApiUri($devUri);
// clientId
$loginSessionApi->setClientId($clientId);
// clientSecret
$loginSessionApi->setClientSecret($clientSecret);
// 平台公钥 
$loginSessionApi->setSystemPublicKey($systemPublicKey);
// 用户私钥
$loginSessionApi->setUserPrivateKey($userPrivateKey);

// 登录校验码
$token = '';

$ret = $loginSessionApi->setAuthorization($token)->check();
var_dump($ret);

// 调用发送邮件接口
$ret = $emailApi->sendEmail('hebiduhebi@126.com', '通知', '123456');
var_dump($ret);
```

## 安装

```
composer require dbh/api5client
```

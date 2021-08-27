<?php

require_once 'vendor/autoload.php';

date_default_timezone_set("PRC");

$devUri = 'http://127.0.0.1:8011/base';
$clientId = 'by04esfH0glASt';
$clientSecret = 'ee7c5016ee68051d9d3d9448ff3c89e7';
//
$systemPublicKey = "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAu4ZtNXrVVtplpWbziT+7l3uS1rlZ6CcvaSpCKelHOk5olrRiePaRRviC4D2Sh4smbXQmyZvDuLp0oZg6OvSjTIrYKKViE0Kx49lkIz2jlgsypGJjACNtiVWKjbPo0aOqYB0Mve1IEHXOovOFMqfRYVREf0otK2Rbtsh2VNdIW2zUwYti6DIv0wknTZvIXEFpWWzM8+1vutVSwxE0GoBN9npKrdUJUBLWDWeVYexqgn81DG0BJV7Ke+ahxHWWq5czHdorJhIwYrHLCdrDRkY3+nXiPwoAvSQpqA0BwkfaRrBJdRhjeA4+6cpm0kLcQiBkN0Y6vcjhY9aSlH4HBOBzBwIDAQAB";
// 用户私钥
$userPrivateKey = "MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQDK8HPvpvz8lLAPrrvJWXyUoOlaHMYDfNsV0O3SjU/sEMFoegD0OlZwjBbn2vQDcUzwsWHXLUgIFnL05C5B/cnkQ6qZuZKh8YKflPbJD+lajR8nRP6dWFlhUAhsqNSr+Y4Hjt3b+a7aeVmUcwaHOWYAEEAshw61vLA+JHf+FVBjDMfo6TdPTt2Yc2/qUF/ljwPgc+YBPcoMadi0wAJZ8yzcogIEqRP592UxTYMKsjHDJVMgfbnVqlNojYR+xhAE50VvB1C6RtiQWgmgShbJhoWywIOhcVU4JKMLZX8kKDO7uPGMVV2Xul7NrsUFvy1VasXSzxFQJ/eMr7ohujMIxh8NAgMBAAECggEBALpnVMZrJvNGC9XL1NckaCcJCm5oAYXQmFgYmWoNvLyDw3MYpWmvcBhexOdgmUPUPSzUcZ85C3HKVPsV4FtjJp+Re9FJwCMZ97ZnGKsj/17aQyRJ3mlebnLRFXvhM79nMQtGMgjM9cvdLOgLI5LvqP4j7x43S86oq2XZD5KFt1nSDs5VJ0DtcRDsnBKFvwjDeQlzSTHDSFOR6lPiWrMkGjMsaVU0G00x5vc0eViKO4A+lze6ZAFb/vLjI21w1V4oetfISDaPhfQaw07zQDBORMMMHvUG/05zBrs4/mKQs+Obsm9IdscZSa08Ie/CbBRYpKmA2aH0Ph6o5QngRmnFOI0CgYEA9E0UzCdltAFnyq2K42mPP0SBGieuDcVmy7keKq+bPnOLl5ns4ixRO2HqsvTJldkXaMvcKKaHnGbFaRwye1GES7LzrqEJTRKhR+r7uTZV7aDBkqEmDzm7RwGVI5FjYyCt90CDogmv2F1yoRY1MY/CashW9LJL9YRY0nEVVcuk+F8CgYEA1KhPxjXPVw7xft+JMpQm/L7Ep+1TdQ7YbjjLwkSYGVCaJkghBzuDNsNs7pK6Lp4lv/Jg2cHwXaU4oL9Uwr/BDt6XUos/fY1k5VauW2HoVPCli5lbh7NOsb30kSAPbTbhdm/aVNL7PexgXCPPy+rbcpQ4eDDhUbqJRE+E+NJWUBMCgYByvPEToT1G+ZIBwtgETsOUd1wbKJ+6oAfTjrH4YlmLT0E0hnqXDzFnrmlIe2diFX/FHFneTbhLYIk/AJtFB9gWpYmFbuSraiCNYnOvXTGmVWYUs9LoO7kVdEzTU6lWGTcbdRVduSb5e4om1gNNr7Mj68vLSSIbwXjl/W6DyQ1GCQKBgDeMa6Ir5igoiB6LB4yFtJVqw3XWAWnfYduQzHDHeC+MpWeAidgYzJKeg7Lh8u5Acz3rcy8OgNoFUYBz2hExA539uOtf4krKh2N8u/i033pojeWkPot45AJ7ywmppT3zCvvkBdUIc4ZeW2FWHW53v7DzVLjYk9LEdhy45NQWJWOvAoGAHjVlCowJfSyPpFWXVQcCX90dYXUc1nos64nAjmPcTA46pzRViYod36t7s8AojfsPxS33jmhfq7/0BCclh/imPMjvLtXWtpUF3xZarmnIt5VXOn0E1ZQXQhMqRZlKJydpi39rBTP0+XqI+Opf1UtFcf9HuI6/ML+r8iPmePTKnd8=";
$systemPublicKey = \by\component\api5client\infra\RsaUtil::formatPublicText($systemPublicKey);
$userPrivateKey = \by\component\api5client\infra\RsaUtil::formatPrivateText($userPrivateKey);

$emailApi = new \by\component\api5client\tool\EmailApi($devUri, $clientId, $clientSecret, $systemPublicKey, $userPrivateKey);
//$ret = $emailApi->sendEmail('hebiduhebi@126.com', '通知', '123456');
//var_dump($ret);

//return;
$loginSessionApi = new \by\component\api5client\login_session\LoginSessionApi();
$loginSessionApi->setApiUri($devUri);
$loginSessionApi->setClientId($clientId);
$loginSessionApi->setClientSecret($clientSecret);
$loginSessionApi->setSystemPublicKey($systemPublicKey);
$loginSessionApi->setUserPrivateKey($userPrivateKey);

//$ret = $loginSessionApi->login();
$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpc3MiOiJieV9hcGkiLCJhdWQiOiJtODYxMzQ4NDM3OTI5MCIsImlhdCI6MTYzMDA0NzIyNi42NDE3MiwibmJmIjoxNjMwMDQ3MjI2LjY0MTcyLCJleHAiOjE2MzAwNzU0MjYuNjQxNzIsInVpZCI6ODAsIm5hbWUiOiJtODYxMzQ4NDM3OTI5MCIsImhlYWQiOiIwIiwic2lkIjoiMTcjNGM2MGJmMzIzNGYyODQ0MTY0OTI4NjVkZTRhMGM2MDMifQ.RPibPAuKlxDc8P6Umc_HdurkZqnFtApolopQOCk8GI6PptfQu2LL0n2AnMcr4evJHzKfi3bWTR4G-21x-ZN-VR5YdNOVcHr04DS9ASd2zW04j-1zrJcGVsA2TEHo_z4TIOvIXoIaPOBpdBAiSc49--MNB_9Uz_0X8-SCMaaGF1FTqwzsAcMrP4IbBULboByujzJUT2ndXWzR-egExhMyhwRKslo76eWByKT4c5qEqhML6vDJzOFqemsvXWaTEn4k0Ggc80KI7_X9dWwl5uFTJ_pDyXZNG4aLSojcWM2kwfZ52StvyZCZ0V0RgsUIgRJbxg4X0o0Z1e7OUSuP0QISAQ';
//var_dump($ret);
//
//if ($ret->isSuccess()) {
//    $data = $ret->getData();
//    $token = $data['jwt'];
//    var_dump($token);
//}
$ret = $loginSessionApi->setAuthorization($token)->check(80);
var_dump($ret);

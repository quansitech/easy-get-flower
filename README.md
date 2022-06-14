# quansitech/easy-get-flower
```text
腾讯公益小红花API
```

#### 安装

```php
composer require quansitech/easy-get-flower
```


####  实例化类
```php
// 参数说明
// array $config 腾讯公益小红花相关配置项
$config = [
    'appid' => 'xxx',
    'key' => 'xxx',
    'et' => 'xxx',
];
$get_flower = new \EasyGetFlower\Application($config);
```

#### getUserXhhNum
```text
查询用户累计获取小红花数量
```
```php
// 参数说明
// $openid 用户微信openid
$openid = 'xxx';
$get_flower->getUserXhhNum($openid);

// 返回值说明
// 返回用户累计小红花数量
```
  
#### hasBillUsed
```text
判断业务订单是否已使用
```
```php
// 参数说明
// $openid 用户微信openid
// $trans_code 业务订单号，需要以YYYYMMDD开头，不能超过32位
$openid = 'xxx';
$trans_code = date('Ymd').'1';
$get_flower->hasBillUsed($openid,$trans_code);

// 返回值说明
// 0 未使用
// 1 已使用
```
  
#### buildLink
```text
生成领花页链接
```
```php
// 参数说明
// $openid 用户微信openid
// $trans_code 业务订单号，需要以YYYYMMDD开头，不能超过32位
// $xhh_num 期望派发的小红花数量
// $time_expire 订单重试结束时间，格式为YYYY-MM-DD HH:mm:SS，不能超过10分钟，若为空则当前时间加10分钟
$openid = 'xxx';
$trans_code = date('Ymd').'1';
$xhh_num = '1';
$time_expire = '';
$get_flower->buildLink($openid,$trans_code,$xhh_num,$time_expire);

// 返回值说明
// 返回领花页链接
```

#### 返回错误统一说明
```php
// 若接口返回false，说明是正常的业务错误
// 获取具体错误
$get_flower->getError();

// 其它非业务错误直接抛出异常
```
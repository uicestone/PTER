<?php

require_once 'lib/RoyalPay.Api.php';

/**
 * 流程：
 * 1、创建QRCode支付单，取得code_url，生成二维码
 * 2、用户扫描二维码，进行支付
 * 3、支付完成之后，RoyalPay服务器会通知支付成功
 * 4、在支付成功通知中需要查单确认是否真正支付成功（见：notify.php）
 */

//echo $_GET['subject'];
//echo $_GET['price'];
//echo $_GET['intend'];
//echo $_GET['service'];
//echo $_GET['expires_at']; exit;

$order_no = uniqid('', true);
$subject = $_GET['subject'];

$total_fee = $_GET['price'];

if (get_current_user_id() === 1 || get_current_user_id() === 16) {
	$total_fee = $total_fee / 1000;
}

$total_fee = max(round($total_fee, 2), 0.01);

$currency = 'AUD';

$service = $_GET['service'];
$expires_at = $_GET['expires_at'];

//获取扫码
$input = new RoyalPayUnifiedOrder();
$input->setOrderId($order_no);
$input->setDescription($subject);
$input->setPrice($total_fee * 100);
$input->setCurrency($currency);
$input->setNotifyUrl(site_url() . "/payment/wechatpay/notify/");
$input->setOperator(get_current_user_id());

$result = RoyalPayApi::qrOrder($input);

create_order($order_no, $subject, $total_fee, $currency, $service, $expires_at);

//跳转
$inputObj = new RoyalPayRedirect();
$inputObj->setRedirect(urlencode(site_url() . $_GET['intend']));

header('Location: ' . RoyalPayApi::getQRRedirectUrl($result['pay_url'], $inputObj));
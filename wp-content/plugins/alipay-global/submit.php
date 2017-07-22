<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>支付宝境外收单交易接口接口</title>
</head>
<?php
/* *
 * 功能：境外收单交易接口接入页
 * 版本：3.4
 * 修改日期：2016-03*08
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。

 *************************注意*****************

 *如果您在接口集成过程中遇到问题，可以按照下面的途径来解决
 *1、开发文档中心（https://ds.alipay.com/fd-ij9mtflt/home.html）
 *2、支持中心（https://global.alipay.com/service/service.htm）
 *3、支持邮箱（overseas_support@service.alibaba.com）

 *如果想使用扩展功能,请按文档要求,自行添加到parameter数组即可。
 **********************************************
 */

require_once("lib/alipay_submit.class.php");
$alipay_config = get_alipay_config();

//echo $_GET['subject'];
//echo $_GET['price'];
//echo $_GET['intend'];
//echo $_GET['service'];
//echo $_GET['expires_at']; exit;

/**************************请求参数**************************/
//商户订单号，商户网站订单系统中唯一订单号，必填
$out_trade_no = uniqid('', true);

//订单名称，必填
$subject = $_GET['subject'];

//付款外币币种，必填
$currency = 'AUD';

//付款外币金额，必填
$total_fee = $_GET['price'];

//商品描述，可空
$body = '';

if (get_current_user_id() === 1) {
	$total_fee = $total_fee / 10000;
}

$total_fee = max(round($total_fee, 2), 0.01);

/************************************************************/

//构造要请求的参数数组，无需改动
$parameter = array(
	"service"		=> $alipay_config['service'],
	"partner"		=> $alipay_config['partner'],
	"notify_url"	=> $alipay_config['notify_url'],
	"return_url"	=> isset($_GET['intend']) ? site_url() . $_GET['intend'] : $alipay_config['return_url'],

	"out_trade_no"	=> $out_trade_no,
	"subject"	=> $subject,
	"total_fee"	=> $total_fee,
	"body"	=> $body,
	"currency" => $currency,
	"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
	//其他业务参数根据在线开发文档，添加参数.文档地址:https://ds.alipay.com/fd-ij9mtflt/home.html
	//如"参数名"=>"参数值"

);

$order_id = wp_insert_post(array(
	'post_type' => 'member_order',
	'post_author' => get_current_user_id(),
	'post_name' => $out_trade_no,
	'post_title' => $subject,
    'post_status' => 'private'
));

add_post_meta($order_id, 'price', $total_fee);
add_post_meta($order_id, 'currency', $currency);
add_post_meta($order_id, 'no', $out_trade_no);
add_post_meta($order_id, 'user', get_current_user_id());
add_post_meta($order_id, 'service', $_GET['service']);
add_post_meta($order_id, 'status', 'pending_payment');

if (isset($_GET['expires_at'])) {
	add_post_meta($order_id, 'expires_at', $_GET['expires_at']);
}

//建立请求
$alipaySubmit = new AlipaySubmit($alipay_config);
$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
echo $html_text;

?>
</body>
</html>
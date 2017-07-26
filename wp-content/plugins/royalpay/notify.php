<?php

require_once 'lib/RoyalPay.Data.php';

//回调参数读取
$response = json_decode(file_get_contents('php://input'), true);
$input = new RoyalPayDataBase();
$input->setNonceStr($response['nonce_str']);
$input->setTime($response['time']);
$input->setSign();

if ($input->getSign() == $response['sign']) {//验证成功
    //请在这里加上商户的业务逻辑程序代
    //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
    //商户订单号
    $order_id = $response['partner_order_id'];
    //RoyalPay订单号
    $royal_order_id = $response['order_id'];
    //订单金额，单位是最小货币单位
    $order_amt = $response['total_fee'];
    //支付金额，单位是最小货币单位
    $pay_amt = $response['real_fee'];
    //币种
    $currency = $response['currency'];
    //订单创建时间，格式为'yyyy-MM-dd HH:mm:ss'，澳洲东部时间
    $create_time = $response['create_time'];
    //订单支付时间，格式为'yyyy-MM-dd HH:mm:ss'，澳洲东部时间
    $pay_time = $response['pay_time'];

    //读取商户系统订单信息
    //判断支付金额是否和订单金额相等

    //更新订单状态

    //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
    $result = array('return_code' => 'SUCCESS');

    order_paid($order_id, 'wechatpay');

    echo json_encode($result);
} else {//验证失败
    echo "fail";
}

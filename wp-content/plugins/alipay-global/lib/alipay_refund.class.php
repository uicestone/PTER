<?php
/* *
 * 类名：AlipayRefund
 * 功能：支付宝退款类
 * 详细：发起支付宝退款请求
 * 版本：3.3
 * 日期：2017-07-23
 * 说明：
 */
require_once("alipay_core.function.php");
require_once("alipay_md5.function.php");

class AlipayRefund {

	var $alipay_config;
	/**
	 *支付宝网关地址（新）
	 */
	var $alipay_gateway_new = 'https://mapi.alipay.com/gateway.do?';

	function __construct($alipay_config){
		$this->alipay_config = $alipay_config;
	}
	function AlipaySubmit($alipay_config) {
		$this->__construct($alipay_config);
	}

	/**
	 * 生成签名结果
	 * @param $para_sort array 已排序要签名的数组
	 * return 签名结果字符串
	 */
	function buildRequestMysign($para_sort) {
		//把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
		$prestr = createLinkstring($para_sort);

		$mysign = "";
		switch (strtoupper(trim($this->alipay_config['sign_type']))) {
			case "MD5" :
				$mysign = md5Sign($prestr, $this->alipay_config['key']);
				break;
			default :
				$mysign = "";
		}

		return $mysign;
	}

	/**
	 * 生成要请求给支付宝的参数数组
	 * @param $para_temp array 请求前的参数数组
	 * @return array 要请求的参数数组
	 */
	function buildRequestPara($para_temp) {
		//除去待签名参数数组中的空值和签名参数
		$para_filter = paraFilter($para_temp);

		//对待签名参数数组排序
		$para_sort = argSort($para_filter);

		//生成签名结果
		$mysign = $this->buildRequestMysign($para_sort);

		//签名结果与签名方式加入请求提交参数组中
		$para_sort['sign'] = $mysign;
		$para_sort['sign_type'] = strtoupper(trim($this->alipay_config['sign_type']));

		return $para_sort;
	}

	/**
	 * 生成要请求给支付宝的参数数组
	 * @param $para_temp array 请求前的参数数组
	 * @return string 要请求的参数数组字符串
	 */
	function buildRequestParaToString($para_temp) {
		//待请求参数数组
		$para = $this->buildRequestPara($para_temp);

		//把参数组中所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串，并对字符串做urlencode编码
		$request_data = createLinkstringUrlencode($para);

		return $request_data;
	}

	/**
	 * 发起退款请求
	 * @param $order_no
	 */
	function refund($order_no, $amount) {

		$params = array(
			'service' => 'forex_refund',
			'partner' => $this->alipay_config['partner'],
			'_input_charset' => strtoupper($this->alipay_config['input_charset']),
			'out_return_no' => 'refund.' . $order_no,
			'out_trade_no' => $order_no,
			'return_amount' => $amount,
			'currency' => 'AUD',
			'gmt_return' => date('YmdHis'),
			'reason' => '邀请奖励',
		);

		$url = $this->alipay_gateway_new . $this->buildRequestParaToString($params);
		$result = file_get_contents($url);
//		$result = getHttpResponseGET($this->alipay_gateway_new . $this->buildRequestParaToString($params), $this->alipay_config['cacert']);
	}

}
?>
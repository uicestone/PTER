<?php

// # Create Payment using PayPal as payment method
// This sample code demonstrates how you can process a
// PayPal Account based Payment.
// API used: /v1/payments/payment

require_once __DIR__ . '/autoload.php';
require_once __DIR__ . '/common.php';

use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

$order_no = uniqid('', true);
$subject = $_GET['subject'];

$total_fee = $_GET['price'];

if (get_current_user_id() <= 18) {
	$total_fee = $total_fee / 1000;
}

$total_fee = max(round($total_fee, 2), 0.01);

$currency = 'AUD';

$service = $_GET['service'];
$expires_at = $_GET['expires_at'];

// ### Payer
// A resource representing a Payer that funds a payment
// For paypal account payments, set payment method
// to 'paypal'.
$payer = new Payer();
$payer->setPaymentMethod("paypal");

// ### Itemized information
// (Optional) Lets you specify item wise
// information
$item1 = new Item();
$item1->setName($subject)
	->setCurrency($currency)
	->setQuantity(1)
//	->setSku("123123") // Similar to `item_number` in Classic API
	->setPrice($total_fee);
$item2 = new Item();

$itemList = new ItemList();
$itemList->setItems(array($item1));

// ### Additional payment details
// Use this optional field to set additional
// payment information such as tax, shipping
// charges etc.
//$details = new Details();
//$details->setShipping(1.2)
//	->setTax(1.3)
//	->setSubtotal(17.50);

// ### Amount
// Lets you specify a payment amount.
// You can also specify additional details
// such as shipping, tax.
$amount = new Amount();
$amount->setCurrency($currency)
	->setTotal($total_fee)
//	->setDetails($details)
;

// ### Transaction
// A transaction defines the contract of a
// payment - what is the payment for and who
// is fulfilling it.
$transaction = new Transaction();
$transaction->setAmount($amount)
//	->setItemList($itemList)
//	->setDescription("Payment description")
	->setInvoiceNumber($order_no)
;

// ### Redirect urls
// Set the urls that the buyer must be redirected to after
// payment approval/ cancellation.
$baseUrl = site_url();
$redirectUrls = new RedirectUrls();
$redirectUrls->setReturnUrl(site_url() . '/payment/paypal/execute/?success=true&intend=' . $_GET['intend'])
	->setCancelUrl(site_url() . '/payment/paypal/execute/?success=false');

// ### Payment
// A Payment Resource; create one using
// the above types and intent set to 'sale'
$payment = new Payment();
$payment->setIntent("sale")
	->setPayer($payer)
	->setRedirectUrls($redirectUrls)
	->setTransactions(array($transaction));


// For Sample Purposes Only.
$request = clone $payment;

// ### Create Payment
// Create a payment by calling the 'create' method
// passing it a valid apiContext.
// (See bootstrap.php for more on `ApiContext`)
// The return object contains the state and the
// url to which the buyer must be redirected to
// for payment approval
try {
	$payment->create(paypal_get_api_context());
} catch (Exception $ex) {
	// NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
//	ResultPrinter::printError("Created Payment Using PayPal. Please visit the URL to Approve.", "Payment", null, $request, $ex);
	exit(1);
}

// ### Get redirect url
// The API response provides the url that you must redirect
// the buyer to. Retrieve the url from the $payment->getApprovalLink()
// method
$approvalUrl = $payment->getApprovalLink();

create_order($order_no, $subject, $total_fee, $currency, $service, $expires_at, 'paypal');

// NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
header('Location: ' . $approvalUrl);
//ResultPrinter::printResult("Created Payment Using PayPal. Please visit the URL to Approve.", "Payment", "<a href='$approvalUrl' >$approvalUrl</a>", $request, $payment);

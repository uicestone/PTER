<?php

// # Sale Refund Sample
// This sample code demonstrate how you can
// process a refund on a sale transaction created
// using the Payments API.
// API used: /v1/payments/sale/{sale-id}/refund

require_once __DIR__ . '/autoload.php';
require_once __DIR__ . '/common.php';

use PayPal\Api\Amount;
use PayPal\Api\Refund;
use PayPal\Api\RefundRequest;
use PayPal\Api\Sale;

function paypal_sale_refund ($sale_id, $amount) {

	// ### Refund amount
	// Includes both the refunded amount (to Payer)
	// and refunded fee (to Payee). Use the $amt->details
	// field to mention fees refund details.
	$amt = new Amount();
	$amt->setCurrency('AUD')
		->setTotal($amount);

	// ### Refund object
	$refundRequest = new RefundRequest();
	$refundRequest->setAmount($amt);

	// ###Sale
	// A sale transaction.
	// Create a Sale object with the
	// given sale transaction id.
	$sale = new Sale();
	$sale->setId($sale_id);

	try {
		// Create a new apiContext object so we send a new
		// PayPal-Request-Id (idempotency) header for this resource
		$apiContext = paypal_get_api_context();

		// Refund the sale
		// (See bootstrap.php for more on `ApiContext`)
		$refundedSale = $sale->refundSale($refundRequest, $apiContext);
	} catch (Exception $ex) {
		// NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
		ResultPrinter::printError("Refund Sale", "Sale", null, $refundRequest, $ex);
		exit(1);
	}

	// NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
	ResultPrinter::printResult("Refund Sale", "Sale", $refundedSale->getId(), $refundRequest, $refundedSale);

	return $refundedSale;
}

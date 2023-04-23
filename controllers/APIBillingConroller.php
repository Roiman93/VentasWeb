<?php
/**
 * @format
 */

namespace Controllers;
header("Access-Control-Allow-Origin: *");
use Model\Model_billing;
class APIBillingConroller
{
	public static function add()
	{
		Model_billing::add_billing();
	}

	public static function seach_product()
	{
		Model_billing::get_stock_product();
	}

	public static function seach_detalle()
	{
		Model_billing::get_detalle_product();
	}

	public static function add_detalle()
	{
		Model_billing::add_detalle_product();
	}

	public static function cancel_billing()
	{
		Model_billing::delete_billing();
	}

	public static function delete_detalle()
	{
		Model_billing::delete_detalle_product();
	}
}

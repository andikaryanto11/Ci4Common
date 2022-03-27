<?php
namespace Ci4Common\Config;

interface IKernel {

	/**
	 * Repository to fetch user when session Ci4Common\Override\Session::USER_FIELD_ID is set;
	 *
	 * @return void
	 */
	public function userRepository();

	/**
	 * Path of any services that will be used for dependency injection
	 *
	 * @return array
	 */
	public function services();
}

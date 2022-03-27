<?php

namespace Ci4Common\Override;

use Ci4Common\Libraries\SessionLib;
use CodeIgniter\HTTP\IncomingRequest;
use Config\Kernel;

class Request extends IncomingRequest {

	/**
	 * Get user as object
	 *
	 * @return mixed
	 */
	public function getUser(){
		$kernel = new Kernel();
		$id = SessionLib::get(Session::USER_FIELD_ID);
		$userRepository = $kernel->userRepository();
		$user = (new $userRepository())->find($id);
        return $user;
	}
}

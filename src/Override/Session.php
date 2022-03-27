<?php

namespace Ci4Common\Override;
use CodeIgniter\Session\Session as CodeIgniterSession;

class Session extends CodeIgniterSession {

	public const USER_DATA = 'userdata';
	public const USER_FIELD_ID = 'id';

}

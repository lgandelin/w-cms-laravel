<?php

namespace Webaccess\WCMSLaravel\Models;

class User extends \Eloquent {

	protected $table = 'w_cms_users';
	protected $fillable = array('login', 'password', 'last_name', 'first_name', 'email');

}
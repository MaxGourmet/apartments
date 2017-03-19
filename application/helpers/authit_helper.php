<?php
function logged_in()
{
	$CI =& get_instance();
	$CI->load->library('authit');
	
	return $CI->authit->logged_in();
}

function user($key = '')
{
	$CI =& get_instance();
	$CI->load->library('session');
	
	$user = $CI->session->userdata('user');
	if($key && isset($user->$key)) return $user->$key;
	return $user;
}
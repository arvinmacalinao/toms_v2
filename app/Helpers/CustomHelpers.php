<?php

use Carbon\Carbon;
use App\Models\User;
use App\Models\Travel;

function format_middle_name($input)
{
	return substr($input, 0, 1).".";
}

function format_date($date)
{
	return Carbon::parse($date)->format('F d, Y');
}

function get_notifications()
{
	$notif_array 				= array();
	$notif_array['travel'] 		= 0;
	$notif_array['disapproved'] = 0;
	$notif_array['approved'] 	= 0;
	$notif_array['comments'] 	= 0;
	if(Auth::user()->r_id == '7' || Auth::user()->r_id == '9') {
		$notif_array['pending'] 	= Travel::where('rg_id', '=', Auth::user()->rg_id)->where('t_rd', '=', '0')->where('is_rd', '=', '0')->where('is_active', '=', '1')->count();
		$notif_array['travel'] 		= Travel::where('rg_id', '=', Auth::user()->rg_id)->whereHas('passengers', function($q) {
			$q->where('to_travel_passengers.u_id', '=', Auth::user()->u_id)->where('is_read', '=', '0');
		})->where('is_active', '=', '1')->count();
		$verifier 					= Travel::where('u_id', '=', Auth::user()->u_id)->where('is_verified', '=', '2')->where('is_active', '=', '1')->where('is_read', '=', '0')->count();
		$usec 						= Travel::where('u_id', '=', Auth::user()->u_id)->where('t_usec', '=', '2')->where('is_active', '=', '1')->where('is_read', '=', '0')->count();
		$sec 						= Travel::where('u_id', '=', Auth::user()->u_id)->where('t_sec', '=', '2')->where('is_active', '=', '1')->where('is_read', '=', '0')->count();
		$notif_array['disapproved'] = $verifier + $usec + $sec;
		$notif_array['approved'] 	= Travel::where('u_id', '=', Auth::user()->u_id)->where('is_verified', '=', '1')->where('t_usec', '=', '1')->where('t_sec', '=', '1')->where('is_active', '=', '1')->where('is_read', '=', '0')->count();
		$notif_array['comments'] 	= Travel::where('is_active', '=', '1')->where('u_id', '=', Auth::user()->u_id)->whereHas('comments', function($q) {
			$q->where('u_id', '!=', Auth::user()->u_id)->where('is_read', '=', '0');
		})->count();
	}
	elseif(Auth::user()->r_id == '5') {
		$notif_array['pending'] 	= Travel::where('is_rd', '=', '1')->where('t_rd', '=', '1')->where('is_verified', '=', '0')->where('is_active', '=', '1')->count();
		$notif_array['comments'] 	= Travel::where('is_rd', '=', '1')->where('t_rd', '=', '1')->where('is_verified', '=', '1')->where('is_active', '=', '1')->where('is_verified', '=', '0')->whereHas('comments', function($q) {
			$q->where('u_id', '!=', Auth::user()->u_id)->where('verified', '=', '0');
		})->count();
	}
	elseif(Auth::user()->r_id == '4') {
		$notif_array['pending'] 	= Travel::where('is_rd', '=', '1')->where('t_rd', '=', '1')->where('is_verified', '=', '1')->where('t_usec', '=', '0')->where('is_active', '=', '1')->count();
		$notif_array['comments'] 	= Travel::where('is_rd', '=', '1')->where('t_rd', '=', '1')->where('is_active', '=', '1')->where('t_rd', '=', '1')->where('is_verified', '=', '1')->where('t_usec', '=', '0')->whereHas('comments', function($q) {
			$q->where('u_id', '!=', Auth::user()->u_id)->where('usec', '=', '0');
		})->count();
	}
	elseif(Auth::user()->r_id == '6') {
		$notif_array['pending'] 	= Travel::where('is_rd', '=', '1')->where('t_rd', '=', '1')->where('is_verified', '=', '1')->where('t_usec', '=', '1')->where('t_sec', '=', '0')->where('is_active', '=', '1')->count();
		$notif_array['comments'] 	= Travel::where('is_rd', '=', '1')->where('t_rd', '=', '1')->where('is_verified', '=', '1')->where('t_usec', '=', '1')->where('t_sec', '=', '0')->where('is_active', '=', '1')->whereHas('comments', function($q) {
			$q->where('u_id', '!=', Auth::user()->u_id)->where('sec', '=', '0');
		})->count();
	}
	else {
		$notif_array['pending'] 	= 0;
		$notif_array['travel'] 		= Travel::where('rg_id', '=', Auth::user()->rg_id)->whereHas('passengers', function($q) {
			$q->where('to_travel_passengers.u_id', '=', Auth::user()->u_id)->where('is_read', '=', '0');
		})->where('is_active', '=', '1')->count();
		$rd 						= Travel::where('u_id', '=', Auth::user()->u_id)->where('t_rd', '=', '2')->where('is_active', '=', '1')->where('is_read', '=', '0')->count();
		$verifier 					= Travel::where('u_id', '=', Auth::user()->u_id)->where('is_verified', '=', '2')->where('is_active', '=', '1')->where('is_read', '=', '0')->count();
		$usec 						= Travel::where('u_id', '=', Auth::user()->u_id)->where('t_usec', '=', '2')->where('is_active', '=', '1')->where('is_read', '=', '0')->count();
		
		$notif_array['disapproved'] = $rd + $verifier + $usec;
		$notif_array['approved'] 	= Travel::where('u_id', '=', Auth::user()->u_id)->where('t_rd', '=', '1')->where('is_verified', '=', '1')->where('t_usec', '=', '1')->where('is_active', '=', '1')->where('is_read', '=', '0')->count();
		$notif_array['comments'] 	= Travel::where('is_active', '=', '1')->where('u_id', '=', Auth::user()->u_id)->whereHas('comments', function($q) {
			$q->where('u_id', '!=', Auth::user()->u_id)->where('is_read', '=', '0');
		})->count();
	}
	$notif_array['total'] 		= $notif_array['pending'] + $notif_array['travel'] + $notif_array['disapproved'] + $notif_array['approved'] + $notif_array['comments'];
	return $notif_array;
}

function get_date_diff($date)
{
	$created_at 	= Carbon::parse($date);
	$seconds 		= $created_at->diffInSeconds(Carbon::now());
	$minutes 		= $created_at->diffInMinutes(Carbon::now());
	$days 			= $created_at->diffInDays(Carbon::now());

	if($minutes == 0) {
		echo Carbon::now()->subSeconds($seconds)->diffForHumans();
	}
	elseif($days == 0) {
		echo Carbon::now()->subMinutes($minutes)->diffForHumans();
	}
	else {
		echo Carbon::now()->subDays($days)->diffForHumans();
	}
}

function create_initials($first, $middle, $last)
{
	$full_name 	= $first." ".$middle." ".$last;
	$full_name 	= preg_replace('/\s+/',' ', $full_name);
	$words 		= explode(" ", $full_name);
	$acronym 	= "";
	foreach($words as $word) {
		$acronym .= $word[0];
	}
	return $acronym;
}


function get_value($array, $fund, $expense)
{
	foreach($array as $a) {
		if($a['f_id'] == $fund && $a['e_id'] == $expense) {
			return 1;
		}
	}
}

function create_semi_initials($first, $middle, $last)
{
	$full_name 	= $first." ".$middle;
	$full_name 	= preg_replace('/\s+/',' ', $full_name);
	$words 		= explode(" ", $full_name);
	$acronym 	= "";
	return $acronym.$last;
}
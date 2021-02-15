<?php

class Util extends CI_Controller {
	
	public static function generateUUIDv4() {
		return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
	        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
	        mt_rand( 0, 0xffff ),
	        mt_rand( 0, 0x0fff ) | 0x4000,
	        mt_rand( 0, 0x3fff ) | 0x8000,
	        mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
	    );
	}
	
	public static function is_leap_year($year) {
	    return ((($year % 4) == 0) && ((($year % 100) != 0) || (($year %400) == 0)));
	}
	
	public static function get_days_count($month, $year) {
		// month: starting from 1
		if ($month == 1) {
			return 31;
		} else if ($month == 2) {
			if (is_leap_year($year)) {
				return 29;
			} else {
				return 28;
			}
		} else if ($month == 3) {
			return 31;
		} else if ($month == 4) {
			return 30;
		} else if ($month == 5) {
			return 31;
		} else if ($month == 6) {
			return 30;
		} else if ($month == 7) {
			return 31;
		} else if ($month == 8) {
			return 31;
		} else if ($month == 9) {
			return 30;
		} else if ($month == 10) {
			return 31;
		} else if ($month == 11) {
			return 30;
		} else if ($month == 12) {
			return 31;
		}
	}
	
	public static function get_formatted_date($day, $month, $year) {
		$formattedDay = str_pad($day, 2, '0', STR_PAD_LEFT);
		$formattedMonth = str_pad($month, 2, '0', STR_PAD_LEFT);
		$formattedYear = str_pad($year, 4, '0', STR_PAD_LEFT);
		return $formattedDay . "-" . $formattedMonth . "-" . $formattedYear;
	}
}

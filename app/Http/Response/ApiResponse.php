<?php

namespace App\Http\Response;

use Illuminate\Foundation\Http\FormRequest;
use Response;


class ApiResponse
{
    
	public $status;
	public $data;
	
	
	public static function build($status, $data, $error_code=200) {
		if ($status) {
			$status_msg = 'success';
			$status = true;
		} else {
			$status_msg = 'error';
			$status = false;
		}
		$result = array('status_msg' => $status_msg,'status' => $status, 'data' =>  $data );
		return $result;
	}
   
}

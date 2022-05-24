<?php

namespace App;

use Illuminate\Http\Request;
use DateTime;

//共通処理が書かれたクラス
class Functions {
	public static function loginCheck(Request $request): bool {
		$result = false;
		$session = $request->session();
		if(!$session->has("loginFlg") || $session->get("loginFlg") == false || !$session->has("id") || !$session->has("name") || !$session->has("auth")) {
			$result =  true;
		}
		return $result;
	}

	public static function dayCheck(string $limit) {
		$result = false;
		$today = date('Y-m-d');
		if(strtotime($today) <= strtotime($limit)) {
			$result = true;
		}
		return $result;
	}
}
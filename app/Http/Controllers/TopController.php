<?php

	namespace App\Http\Controllers;

	use Illuminate\Http\Request;
	use App\Functions;
	use App\Http\Controllers\Controller;

	//TOPに関するコントローラークラス
	class TopController extends Controller {
		//Top画面表示処理
		public function goTop(Request $request) {
			$assign = [];
			if(Functions::loginCheck($request)) {
				$validationMsgs[] = "ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインしなおしてください。";
				$assign["validationMsgs"] = $validationMsgs;
				$templatePath = "login";
			}
			else {
				$templatePath = "top";
			}
			return view($templatePath, $assign);
		}
	}
<?php

	namespace App\Http\Controllers;

	use Illuminate\Http\Request;
	use Illuminate\Support\Facades\DB;
	use App\Functions;
	use App\Entity\Subject;
	use App\DAO\SubjectDAO;
	use App\Http\Controllers\Controller;

	//部門情報管理に関するコントローラクラス
	class SubjectController extends Controller {
		//部門リスト画面表示処理
		public function showSubjectList(Request $request) {
			$templatePath = "subject.subjectList";
			$assign = [];
			if(Functions::loginCheck($request)) {
				$validationMsgs[] = "ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインしなおしてください。";
				$assign["validationMsgs"] = $validationMsgs;
				$templatePath = "login";
			}
			else {
				$db = DB::connection()->getPdo();
				$subjectDAO = new SubjectDAO($db);
				$subjectList = $subjectDAO->findAll();
				$assign["subjectList"] = $subjectList;
			}
			return view($templatePath, $assign);
		}

		// //部門情報登録画面表示処理
		public function goSubjectAdd(Request $request) {
			$templatePath = "subject.subjectAdd";
			$assign = [];
			if(Functions::loginCheck($request)) {
				$validationMsgs[] = "ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインしなおしてください。";
				$assign["validationMsgs"] = $validationMsgs;
				$templatePath = "login";
			}
			else {
				$assign["subject"] = new Subject();
			}
			return view($templatePath, $assign);
		}

		//部門情報登録処理
		public function subjectAdd(Request $request) {
			$templatePath = "subject.subjectAdd";
			$isRedirect = false;
			$assign = [];
			if(Functions::loginCheck($request)) {
				$validationMsgs[] = "ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインしなおしてください。";
				$assign["validationMsgs"] = $validationMsgs;
				$templatePath = "login";
			}
			else {
				$addMark = $request->input("addMark");
				$addName = $request->input("addName");
				$addMark = str_replace("", " ", $addMark);
				$addName = str_replace("", " ", $addName);
				$addMark = trim($addMark);
				$addName = trim($addName);
				
				$subject = new Subject();
				$subject->setMark($addMark);
				$subject->setName($addName);
				
				$validationMsgs = [];
				
				if(empty($addMark)) {
					$validationMsgs[] = "科目記号の入力は必須です。";
				}
				if(empty($addName)) {
					$validationMsgs[] = "科目名の入力は必須です。";
				}
				$db = DB::connection()->getPdo();
				$subjectDAO = new SubjectDAO($db);
				$subjectDB = $subjectDAO->findByMark($subject->getMark());
				if(!empty($subjectDB)) {
					$validationMsgs[] = "その科目記号はすでに使われています。別のものを指定してください。";
				}
				if(empty($validationMsgs)) {
					$mark = $subjectDAO->insert($subject);
					if($mark === -1) {
						$assign["errorMsg"] = "情報登録に失敗しました。もう一度はじめからやり直してください。";
						$templatePath = "error";
					}
					else {
						$isRedirect = true;
					}
				}
				else {
					$assign["subject"] = $subject;
					$assign["validationMsgs"] = $validationMsgs;
				}
				if($isRedirect) {
					$response = redirect("/subject/showSubjectList")->with("flashMsg", "科目記号" . $mark . "で科目情報を登録しました。");
				}
				else {
					$response = view($templatePath, $assign);
				}
				return $response;
			}
		}

		// 	//部門情報編集画面表示処理
			public function prepareSubjectEdit(Request $request, string $mark) {
				$templatePath = "subject.subjectEdit";
				$assign = [];
				if(Functions::loginCheck($request)) {
					$validationMsgs[] = "ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインしなおしてください。";
					$assign["validationMsgs"] = $validationMsgs;
					$templatePath = "login";
				}
				else {
					$db = DB::connection()->getPdo();
					$subjectDAO = new SubjectDAO($db);
					$subject = $subjectDAO->findByMark($mark);
					if(empty($subject)) {
						$assign["errorMsg"] = "部門情報の取得に失敗しました。";
						$templatePath = "error";
					}
					else {
						$assign["subject"] = $subject;
					}
				}
				return view($templatePath, $assign);
			}

		// 	//部門情報編集処理
			public function subjectEdit(Request $request) {
				$templatePath = "subject.subjectEdit";
				$isRedirect = false;
				$assign = [];
				if(Functions::loginCheck($request)) {
					$validationMsgs[] = "ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインしなおしてください。";
					$assign["validationMsgs"] = $validationMsgs;
					$templatePath = "login";
				}
				else {
					$editMark = $request->input("editMark");
					$editName = $request->input("editName");
					$editDpMark = str_replace("", " ", $editMark);
					$editDpName = str_replace("", " ", $editName);
					$editDpMark = trim($editDpMark);
					$editDpName = trim($editName);
					
					$subject = new Subject();
					$subject->setMark($editMark);
					$subject->setName($editName);
					
					$validationMsgs = [];
					
					if(empty($editDpName)) {
						$validationMsgs[] = "科目名の入力は必須です。";
					}
					
					$db = DB::connection()->getPdo();
					$subjectDAO = new SubjectDAO($db);
					$subjectDB = $subjectDAO->findBymark($subject->getMark());
					if(!empty($subjectDB) && $subjectDB->getMark() != $editMark) {
						$validationMsgs[] = "その科目記号はすでに使われています。別のものを指定してください。";
					}
					if(empty($validationMsgs)) {
						$result = $subjectDAO->update($subject);
						if($result) {
							$isRedirect = true;
						}
						else {
							$assign["errorMsg"] = "情報更新に失敗しました。もう一度はじめからやり直してください。";
							$templatePath = "error";
						}
					}
					else {
						$assign["subject"] = $subject;
						$assign["validationMsgs"] = $validationMsgs;
					}
				}
				if($isRedirect) {
					$response = redirect("/subject/showSubjectList")->with("flashMsg", "科目記号" . $subject->getMark() . "の科目情報を更新しました。");
				}
				else {
					$response = view($templatePath, $assign);
				}
				return $response;
			}

			//部門情報削除確認画面表示処理
			public function confirmSubjectDelete(Request $request, string $mark) {
				$templatePath = "subject.subjectConfirmDelete";
				$assign = [];
				if(Functions::loginCheck($request)) {
					$validationMsgs[] = "ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインしなおしてください。";
					$assign["validationMsgs"] = $validationMsgs;
					$templatePath = "login";
				}
				else {
					$db = DB::connection()->getPdo();
					$subjectDAO = new SubjectDAO($db);
					$subject = $subjectDAO->findByMark($mark);
					if(empty($subject)) {
						$assign["errorMsg"] = "科目情報の取得に失敗しました。";
						$templatePath = "error";
					}
					else {
						$assign["subject"] = $subject;
					}
				}
				return view($templatePath, $assign);
			}

		// 	//部門情報削除処理
			public function subjectDelete(Request $request) {
				$templatePath = "error";
				$isRedirect = false;
				$assign = [];
				if(Functions::loginCheck($request)) {
					$validationMsgs[] = "ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインしなおしてください。";
					$assign["validationMsgs"] = $validationMsgs;
					$templatePath = "login";
				}
				else {
					$deleteMark = $request->input("deleteMark");
					$db = DB::connection()->getPdo();
					$subjectDAO = new SubjectDAO($db);
					$result = $subjectDAO->delete($deleteMark);
					if($result) {
						$isRedirect = true;
					}
					else {
						$assign["errorMsg"] = "情報削除に失敗しました。もう一度はじめからやり直してください。";
					}
				}
				if($isRedirect) {
					$response = redirect("/subject/showSubjectList")->with("flashMsg", "科目記号" . $deleteMark . "の科目情報を削除しました。");
				}
				else {
					$response = view($templatePath, $assign);
				}
				return$response;
			}
		}
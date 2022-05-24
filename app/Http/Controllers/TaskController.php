<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Functions;
use App\Entity\Task;
use App\Entity\Subject;
use App\DAO\TaskDAO;
use App\DAO\SubjectInfo;
use App\Http\Controllers\Controller;


class TaskController extends Controller {

    public function showTaskList(Request $req) {
        $templatePath = 'task.taskList';
        $assign = [];
        if(Functions::loginCheck($req)) {
            $validationMsgs[] = 'ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインし直して下さい。';
            $assign['validationMsgs'] = $validationMsgs;
            $templatePath = 'login';
        }else {
            $db = DB::connection()->getPdo();
            $taskDAO = new TaskDAO($db);
            $taskList = $taskDAO->findAll();
            $assign['taskList'] = $taskList;
        }
        return view($templatePath, $assign);
    }


    public function goTaskAdd(Request $req) {
        $templatePath = 'task.taskAdd';
        $assign = [];
        if(Functions::loginCheck($req)) {
            $validationMsgs[] = 'ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインしなおしてください。';
            $assign['validationMsgs'] = $validationMsgs;
            $templatePath = 'login';
        }else {
            $db = DB::connection()->getPdo();
            $assign['task'] = new Task();
            $subjectInfo = new SubjectInfo($db);
            $assign['subjectAll'] = $subjectInfo->subjectAll();
        }
        return view($templatePath, $assign);
    }


    public function taskAdd(Request $req) {
        $templatePath = 'task.taskAdd';
        $isRedirect = false;
        $assign = [];

        if(Functions::loginCheck($req)) {
            $validationMsgs[] = 'ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインしなおしてください。';
            $assign['validationMsgs'] = $validationMsgs;
            $templatePath = 'login';
        }else {
            $addMark = $req->input('addMark');
            $addName = $req->input('addName');
            $addTaskNo = $req->input('addTaskNo');
            $addDescription = $req->input('addDescription');
            $addLimit = $req->input('addLimit');
            $addMark = str_replace("　", " ", $addMark);
            $addName = str_replace("　", " ", $addName);
            $addTaskNo = str_replace("　", " ", $addTaskNo);
            $addDescription = str_replace("　", " ", $addDescription);
            $addMark = trim($addMark);
            $addName = trim($addName);
            $addTaskNo = trim($addTaskNo);
            $addDescription = trim($addDescription);

            $task = new Task();
            $task->setMark($addMark);
            $task->setName($addName);
            $task->setTaskNo($addTaskNo);
            $task->setDescription($addDescription);
            $task->setLimit($addLimit);

            $validationMsgs = [];

            if(empty($addMark)) {
                $validationMsgs[] = '科目記号の選択は必須です。';
            }
            if(empty($addName)) {
                $validationMsgs[] = '課題名の入力は必須です。';
            }
            if(empty($addTaskNo)) {
                $validationMsgs[] = '課題番号の入力は必須です。';
            }
            if(empty($addLimit)) {
                $validationMsgs[] = '提出期限の入力は必須です。';
            }
            if(!Functions::dayCheck($addLimit)) {
                $validationMsgs[] = '提出期限が過ぎています。可能な日付を指定してください。';
            }
            $db = DB::connection()->getPdo();
            $taskDAO = new TaskDAO($db);
            $taskDB = $taskDAO->findByTaskNo($task->getName(), $task->getTaskNo());
            if(!empty($taskDB)) {
                $validationMsgs[] = 'その科目の課題番号はすでに作成しています。別の課題番号をを指定してください。';
            }
            if(empty($validationMsgs)) {
                $result = $taskDAO->insert($task);
                if(empty($result)) {
                    $assign['errorMsg'] = '情報登録に失敗しました。もう一度はじめからやり直してください。';
                    $templatePath = 'error';
                }else {
                    $isRedirect = true;
                }
            }else {
                $assign['task'] = $task;
                $assign['validationMsgs'] = $validationMsgs;
                $subjectInfo = new SubjectInfo($db);
                $assign['subjectAll'] = $subjectInfo->subjectAll();
            }
            if($isRedirect) {
                $response = redirect('/task/showTaskList')->with('flashMsg', $result['mark'] . 'の課題番号' . $result['taskNo'] . 'を登録しました。');
            }else {
                $response = view($templatePath, $assign);
            }
            return $response;
        }
    }


    public function prepareTaskEdit(request $req, int $taskId) {
        $templatePath = 'task.taskEdit';
        $assign = [];
        if(Functions::loginCheck($req)) {
            $validationMsgs[] = 'ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインしなおしてください。';
            $assign['validationMsgs'] = $validationMsgs;
            $templatePath = 'login';
        }else {
            $db = DB::connection()->getPdo();
            $taskDAO = new TaskDAO($db);
            $task = $taskDAO->findByPK($taskId);
            $subjectInfo = new SubjectInfo($db);
            $assign['subjectAll'] = $subjectInfo->subjectAll();
            if(empty($task)) {
                $assign['errorMsg'] = '課題情報の取得に失敗しました。';
                $templatePath = 'error';
            }else {
                $assign['task'] = $task;
                $subjectInfo = new SubjectInfo($db);
                $assign['subjectAll'] = $subjectInfo->subjectAll();
                // $assign['hiredate'] = explode('-', $emps->getEmHiredate());
                // $assign['findByInputItems'] = $empsDAO->findByInputItems();
            }
        }
        return view($templatePath, $assign);
    }


    public function taskEdit(Request $req) {
        $templatePath = 'task.taskEdit';
        $isRedirect = false;
        $assign = [];
        if(Functions::loginCheck($req)) {
            $validationMsgs[] = 'ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインしなおしてください。';
            $assign['validationMsgs'] = $validationMsgs;
            $templatePath = 'login';
        }else {
            $editId = $req->input('editId');
            $editMark = $req->input('editMark');
            $editName = $req->input('editName');
            $editTaskNo = $req->input('editTaskNo');
            $editDescription = $req->input('editDescription');
            $editLimit = $req->input('editLimit');
            $editMark = str_replace("　", " ", $editMark);
            $editName = str_replace("　", " ", $editName);
            $editTaskNo = str_replace("　", " ", $editTaskNo);
            $editDescription = str_replace("　", " ", $editDescription);
            $editMark = trim($editMark);
            $editName = trim($editName);
            $editTaskNo = trim($editTaskNo);
            $editDescription = trim($editDescription);

            $task = new Task();
            $task->setId($editId);
            $task->setMark($editMark);
            $task->setName($editName);
            $task->setTaskNo($editTaskNo);
            $task->setDescription($editDescription);
            $task->setLimit($editLimit);

            $validationMsgs = [];

            if(empty($editMark)) {
                $validationMsgs[] = '科目記号の選択は必須です。';
            }
            if(empty($editName)) {
                $validationMsgs[] = '課題名の入力は必須です。';
            }
            if(empty($editTaskNo)) {
                $validationMsgs[] = '課題番号の入力は必須です。';
            }
            if(empty($editLimit)) {
                $validationMsgs[] = '提出期限の入力は必須です。';
            }
            if(!Functions::dayCheck($editLimit)) {
                $validationMsgs[] = '提出期限が過ぎています。可能な日付を指定してください。';
            }

            $db = DB::connection()->getPdo();
            $taskDAO = new TaskDAO($db);
            $taskDB = $taskDAO->findByTaskNo($task->getMark(), $task->getTaskNo());
            if(!empty($taskDB)) {
                $validationMsgs[] = 'その科目の課題番号はすでに作成しています。別の課題番号をを指定してください。';
            }
            if(empty($validationMsgs)) {
                $result = $taskDAO->update($task);
                if(empty($result)) {
                    $assign['errorMsg'] = '情報登録に失敗しました。もう一度はじめからやり直してください。';
                    $templatePath = 'error';
                }else {
                    $isRedirect = true;
                }
            }else {
                $assign['task'] = $task;
                $assign['validationMsgs'] = $validationMsgs;
                $subjectInfo = new SubjectInfo($db);
                $assign['subjectAll'] = $subjectInfo->subjectAll();
                // $assign['hiredate'] = explode('-', $emps->getEmHiredate());
                // $assign['validationMsgs'] = $validationMsgs;
                // $assign['findByInputItems'] = $empsDAO->findByInputItems();
            }
            if($isRedirect) {
                $response = redirect('/task/showTaskList')->with('flashMsg', $task->getMark() . 'の課題番号' . $task->getTaskNo() . 'を変更しました。');
            }else {
                $response = view($templatePath, $assign);
            }
            return $response;
        }
    }


    public function confirmTaskDelete(request $req, int $id) {
        $templatePath = 'task.taskConfirmDelete';
        $assign = [];
        if(Functions::loginCheck($req)) {
            $validationMsgs[] = 'ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインしなおしてください。';
            $assign['validationMsgs'] = $validationMsgs;
            $templatePath = 'login';
        }else {
            $db = DB::connection()->getPdo();
            $taskDAO = new TaskDAO($db);
            $task = $taskDAO->findByPK($id);
            if(empty($task)) {
                $assign['errorMsg'] = "課題情報の取得に失敗しました。";
                $templatePath = "error";
            }else {
                $assign['task'] = $task;
            }
        }
        return view($templatePath, $assign);
    }


    public function taskDelete(request $req) {
        $templatePath = 'error';
        $isRedirect = false;
        $assign = [];
        if(Functions::loginCheck($req)) {
            $validationMsgs[] = 'ログインしていないか、前回ログインしてから一定時間が経過しています。もう一度ログインしなおしてください。';
            $assign['validationMsgs'] = $validationMsgs;
            $templatePath = 'login';
        }else {
            $deleteId = $req->input('deleteId');
            $db = DB::connection()->getPdo();
            $taskDAO = new TaskDAO($db);
            $result = $taskDAO->delete($deleteId);
            if($result) {
                $isRedirect = true;
            }else {
                $assign['errorMsg'] = '情報削除に失敗しました。もう一度はじめからやり直してください。';
            }
        }
        if($isRedirect) {
            $response = redirect('/task/showTaskList')->with('flashMsg', '課題ID"' . $deleteId . 'の情報を削除しました。');
        }else {
            $response = view($templatePath, $assign);
        }
        return $response;
    }
}
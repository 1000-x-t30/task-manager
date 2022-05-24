<?php

namespace App\DAO;

use Illuminate\Support\Facades\DB;
use PDO;
use App\DAO\TaskDAO;
use App\DAO\SubjectDAO;


class SubjectInfo extends TaskDAO {
  
  public function subjectAll(): array {
    $db = DB::connection()->getPdo();
    $subjectDAO = new SubjectDAO($db);  
    $assign = $subjectDAO->findAll();
    return $assign;
  }
}
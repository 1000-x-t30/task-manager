<?php

	namespace App\DAO;

	use PDO;
	use App\Entity\User;

	//usersテーブルへのデータ操作クラス
	class UserDAO {
		//PDO DB接続オブジェクト
		private PDO $db;

		//コンストラクタ
		public function __construct(PDO $db) {
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
			$this->db = $db;
		}

		//ログインIDによる検索
		public function findByLoginid(string $loginId): ?User {
			$sql = "SELECT * FROM users WHERE login = :login";
			$stmt = $this->db->prepare($sql);
			$stmt->bindValue(":login", $loginId, PDO::PARAM_INT);
			$result = $stmt->execute();
			$user = null;
			if($result && $row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$id = $row["id"];
				$login = $row["login"];
				$nameLast = $row["name_last"];
				$nameFirst = $row["name_first"];
				$passwd = $row["passwd"];
				$mail = $row["mail"];
				
				$user = new User();
				$user->setId($id);
				$user->setLogin($login);
				$user->setNameFirst($nameFirst);
				$user->setNameLast($nameLast);
				$user->setPasswd($passwd);
				$user->setMail($mail);
			}
			return $user;
		}
	}
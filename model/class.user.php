<?php

class User
{
	public $conn;

	public function __construct()
	{
		require_once("class.database.php");

		$db = new DatabaseConnection;
		$this->conn = $db->ConnectDB();
	}

	/**
	  * User Info Select
	  * @param $userID - the users key in the DB
	  * @param descript - brings back all the user record data
	  *
	  */
	public function getAllUsersInfo()
	{
		try{
			$queryInfo = "SELECT * FROM users ORDER BY id DESC";

			$user = $this->conn->prepare($queryInfo);

			$user->setFetchMode(PDO::FETCH_ASSOC);
			$user->execute();
			$user = $user->fetchAll();

			if(empty($user)){
				return;
			}

			$userList= array();

			for($i=0; $i<count($user); $i++){

				$userInfo = array(
					'id' => $user[$i]['id'],
					'username' => $user[$i]['username'],
					'email' => $user[$i]['email'],
					'name' => $user[$i]['name'],
					'profile_img' => $user[$i]['profile_img'],
					'created' => $user[$i]['created']
				);

				$userList[] = $userInfo;
			}
			
			$userSet = array(
				'users'=>$userList,
			);

			return json_encode($userSet);

		}catch(PDOException $e){
			echo $e->getMessage();
		}
	}

	/**
	  * User Info Select
	  * @param $userID - the users key in the DB
	  * @param descript - brings back all the user record data
	  *
	  */
	public function getUserInfo($userID)
	{
		try{
			$queryInfo = "SELECT * FROM users WHERE id = :id LIMIT 1";

			$user = $this->conn->prepare($queryInfo);

			$user->bindParam(":id", $userID, PDO::PARAM_STR);
			$user->setFetchMode(PDO::FETCH_ASSOC);
			$user->execute();
			$user = $user->fetchAll();

			if(empty($user)){
				return;
			}

			$userInfo = array(
				'id' => $user[0]['id'],
				'username' => $user[0]['username'],
				'email' => $user[0]['email'],
				'name' => $user[0]['name'],
				'profile_img' => $user[0]['profile_img'],
				'created' => $user[0]['created'],
				'created_string' => $this->joinedSince($user[0]['created'])
			);

			return json_encode($userInfo);

		}catch(PDOException $e){
			echo $e->getMessage();
		}
	}

	public static function joinedSince($created){

    $timeFirst  = strtotime($created);
    $timeSecond = strtotime("now");
    $memsince   = $timeSecond - strtotime($created);
    $regged     = date("n/j/Y", strtotime($created));

    if($memsince < 60) {
      $memfor = $memsince . " Seconds";
    }else if($memsince < 120){
      $memfor = floor ($memsince / 60) . " Minute";
    }else if($memsince < 3600 && $memsince > 120){
      $memfor = floor($memsince / 60) . " Minutes";
    }else if($memsince < 7200 && $memsince > 3600){
      $memfor = floor($memsince / 3600) . " Hour";
    }else if($memsince < 86400 && $memsince > 3600){
      $memfor = floor($memsince / 3600) . " Hours";
    }else if($memsince < 172800){
      $memfor = floor($memsince / 86400) . " Day";
    }else if($memsince < 604800 && $memsince > 172800){
      $memfor = floor($memsince / 86400) . " Days";
    }else if($memsince < 1209600 && $memsince > 604800){
      $memfor = floor($memsince / 604800) . " Week";
    }else if($memsince < 2419200 && $memsince > 1209600){
      $memfor = floor($memsince / 604800) . " Weeks";
    }else if($memsince < 4838400){
      $memfor = floor($memsince / 2419200) . " Month";
    }else if($memsince < 31536000 && $memsince > 4838400){
      $memfor = floor($memsince / 2419200) . " Months";
    }else if($memsince < 63072000){
      $memfor = floor($memsince / 31536000) . " Year";
    }else if($memsince > 63072000){
      $memfor = floor($memsince / 31536000) . " Years";
    }
    return (string) $memfor;
  }

	/**
	  * User Edit Info
	  * @param $userID - the users key in the DB
	  * @param $userData - an array of passed values to be edited
	  * @param descript - updates the user record data
	  *
	  */
	public function editUser($userID, $userData)
	{
		$existing = $this->getUserInfo($userID);

		if(isset($userData['id'])){$id = $userData['id'];}else{$id = $existing['id'];}
		if(isset($userData['username'])){$username = $userData['username'];}else{$id = $existing['username'];}
		if(isset($userData['email'])){$email = $userData['email'];}else{$id = $existing['email'];}
		if(isset($userData['name'])){$name = $userData['name'];}else{$id = $existing['name'];}
		if(isset($userData['profile_img'])){$profile_img = $userData['profile_img'];}else{$id = $existing['profile_img'];}
		if(isset($userData['created'])){$created = $userData['created'];}else{$id = $existing['created'];}

		try{

			$queryInfo = "UPDATE users SET
			username = :username,
			email = :email,
			name = :name,
			profile_img = :profile_img,
			created = :created
			WHERE id = :id";

			$statement = $this->conn->prepare($queryInfo);

			$statement->execute(array(
				"username" => $username,
				"email" => $email,
				"name" => $name,
				"profile_img" => $profile_img,
				"created" => $created,
				"id" => $id
			));

			return true;
			exit;

		}catch(PDOException $e){

			return false;
			exit;

		}

	}

	/**
	  * User Delete
	  * @param $userID - the users key in the DB
	  * @param descript - deletes a user record from the system
	  *
	  */
	public function deleteUser($userID)
	{
		try{
			$queryInfo = "DELETE FROM users WHERE id = :id";

			$user = $this->conn->prepare($queryInfo);

			$user->bindParam(":id", $userID, PDO::PARAM_INT);
			$user->setFetchMode(PDO::FETCH_ASSOC);
			$user->execute();

			echo true;
			exit;

		}catch(PDOException $e){

			echo false;
			exit;

		}
	}
}

?>

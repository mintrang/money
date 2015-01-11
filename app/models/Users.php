<?php

class Users extends Admin
{
	public $table = 'Users';

	/*
	 * list user
	 */
	public function listUsers_x($idRoom)
	{
		if (isset($idRoom) && $idRoom != 0) {
			$list = Users::find("idroom = '$idRoom'");
		} else $list = Users::find();

		return $list;
	}

	public function xx($idRoom = '')
	{
		$sql = "SELECT   u.idusers, u.username, u.email, u.password, u.phone, u.start_job, u.end_job,
 				u.fullname, u.birthday, u.address, r.iduser, r.chucvu,
				l.idlevel, l.phong , l.parent
				FROM users u
				 JOIN roomuser r ON r.iduser = u.idusers
				 join level l on l.idlevel = r.idlevel

 					";
		if (isset($idRoom) && $idRoom != 0) {
			$where = " where  l.idlevel = $idRoom ";
		} else $where = "";
		$sql = $sql . ' ' . $where . ' group by u.idusers';
//        echo $sql; die();
		return $this->getModelsManager()->executeQuery($sql);
	}

	public function listUsers($idRoom)
	{
		$sql1 = "SELECT u.idusers , u.username, u.email,
 					u.password, u.phone, u.idroom,
 					u.start_job, u.end_job, u.fullname, u.birthday, u.address,
 					r.name as nameroom FROM users u
 					left JOIN room r ON r.idroom = u.idroom
 					";
		if (isset($idRoom) && $idRoom != 0) {
			$where = " where  u.idroom = $idRoom ";
		} else $where = "";
		$sql = $sql1 . ' ' . $where;
		return $this->getModelsManager()->executeQuery($sql);
	}

	public function getParent()
	{
		$sql = "SELECT u.idusers, u.username, u.email, u.password, u.phone, u.idroom,
 				 r.iduser, r.chucvu,
				l.idlevel, l.phong , l.parent
				FROM users u
				JOIN roomuser r ON r.iduser = u.idusers
				join level l on l.idlevel = r.idlevel
 					";
		return $this->getDI()->get('db')->fetchAll($sql, Phalcon\Db::FETCH_OBJ);
	}


	public function search($name, $idroom = '')
	{
		$sql = "SELECT   u.idusers, u.username, u.email, u.password, u.phone, u.start_job, u.end_job,
	                u.fullname, u.birthday, u.address, r.iduser, r.chucvu,
					l.idlevel, l.phong , l.parent
					FROM $this->table u
					JOIN roomuser r ON r.iduser = u.idusers
					join level l on l.idlevel = r.idlevel
 					where u.username like '%$name%' OR u.fullname like '%$name%'
 					";
        if ($idroom != '') {
            $sql .= " and l.idlevel = $idroom" . ' group by u.idusers';
        }
        return $this->getModelsManager()->executeQuery($sql);
	}

	public function detailUser($id)
	{
		$sql = "SELECT users . * , `group`.name as namegroup, room.name as nameroom
				FROM users
				JOIN room ON room.idroom = users.idroom

				where users.idusers = $id";
		return $this->getDI()->get('db')->fetchOne($sql, Phalcon\Db::FETCH_OBJ);
//		bo JOIN `group` ON `group`.idgroup = users.idgroup
	}

	/**
	 * @param $usr
	 * @return mixed
	 */
	public function login($usr)
	{
		$login = Users::findFirst("username = '$usr'");
		return $login;
	}

	public function editUser($iduser, $arr)
	{
		$user = Users::findFirst("idusers = $iduser");
		$user->save($arr);
	}

	public function getEditUser($iduser)
	{
		$sql = "SELECT users.* FROM `users`
				where users.idusers = $iduser
				";
		return $this->getDI()->get('db')->fetchOne($sql, Phalcon\Db::FETCH_OBJ);
	}

	/**
	 * create new user
	 *
	 * @param array post
	 */
	public function createUser($arrayPost)
	{
		$this->save($arrayPost);
	}

	public function deteleUser($iduser)
	{
		$user = Users::findFirst("idusers = $iduser");
		$user->delete();
	}

	/**
	 * kiem tra username da ton tai hay chua
	 * @param $username
	 * @return mixed
	 */
	public function checkUserName($field, $ofField)
	{
		$sql = "select * from users where $field = '" . $ofField . "'";
//		echo $sql; die();
		return $this->getDI()->get('db')->fetchOne($sql);
	}

	/**
	 * kiem tra khi sua, username va email khong duoc trung vs ng khac
	 * ngoai tru cua chinh thang dang sua
	 *
	 * @param $field
	 * @param $ofField
	 * @return mixed
	 */
	public function checkUpdate($field, $ofField, $where, $ofWhere)
	{
		return $this->checkExistUpdate($this->table, $field, $ofField, $where, $ofWhere);
	}

	/**
	 * tìm kiếm theo tên nhân viên
	 */
	public function searchUser($username)
	{
		$sql = "select * from users where username like '%$username%' or fullname like '%$username%' ";
		return $this->getDI()->get('db')->fetchAll($sql);

	}

}

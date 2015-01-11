<?php

class Level extends Admin
{
	public $table = 'level';

	public function listxx($parent)
	{
		$sql = "select * from $this->table where parent = $parent";
		return $this->getDI()->get('db')->fetchAll($sql, Phalcon\Db::FETCH_OBJ);
	}

	public function getUserRoom($id)
	{
		$sql = "SELECT t.iduser, t.idroom as phong, u.*
				FROM trang_room_user t
				JOIN users u ON t.iduser = u.idusers where t.idroom = $id";
		return $this->getDI()->get('db')->fetchAll($sql, Phalcon\Db::FETCH_OBJ);
	}

	public function getListLevel($idlevel)
	{
		$sql = "SELECT t.*, u.*,ll.chucvu,ll.idlevel FROM `trang_room_user` t
				join users u
				on t.iduser = u.idusers
				join level ll
				on ll.idlevel = t.idlevel
				where ll.idlevel = $idlevel";
		return $this->getDI()->get('db')->fetchAll($sql, Phalcon\Db::FETCH_OBJ);
	}
	/*
	 * lay dsach cac phong
	 */
	public function getAllRoom()
	{
		$sql = 'select * from level';
		return $this->getDI()->get('db')->fetchAll($sql, Phalcon\Db::FETCH_OBJ);
	}
	/*
	 * lay cap tren cua 1 phong
	 */
	public function getParent($parent) {
		$sql = "select * from level where idlevel = $parent";
		return $this->getDI()->get('db')->fetchOne($sql, Phalcon\Db::FETCH_OBJ);
	}
}

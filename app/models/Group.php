<?php

class Group extends Admin
{
	public $table = 'group';

	public function listGroup()
	{
		$listGroup = Group::find();
		return $listGroup;
	}

	public function config($idgroup)
	{
		$status = Group::findFirst("idgroup = $idgroup");
		return $status;
	}

	/**
	 * update value
	 *
	 * @param $jsonValue
	 */
	public function updateValue($idgroup, $jsonValue)
	{
		$update = Group::findFirst("idgroup = $idgroup");
		$update->status = $jsonValue;
		$update->save();
	}

	/*
	 * lay ten cac truong cua bang user
	 * de cau hinh an/hien
	 * ma h pai sua >"<
	 */
	public function getFieldDb()
	{
		$sql = "SELECT COLUMN_NAME
				FROM INFORMATION_SCHEMA.COLUMNS
				WHERE TABLE_SCHEMA = 'tamtay' AND TABLE_NAME ='users' AND COLUMN_NAME not in ('password','idusers')";
		return $this->getDI()->get('db')->fetchAll($sql, Phalcon\Db::FETCH_OBJ);
	}

	/*
	 * lay truong can an/hien trong các bảng khác có liên quan bảng user
	 */
	public function getFieldOtherTable($table, $khac ='')
	{
		$sql = "SELECT COLUMN_NAME
				FROM INFORMATION_SCHEMA.COLUMNS
				WHERE TABLE_SCHEMA = 'tamtay' AND TABLE_NAME = '$table' AND COLUMN_NAME NOT IN ('$khac')";
		return $this->getDI()->get('db')->fetchAll($sql, Phalcon\Db::FETCH_OBJ);
	}


	public function resetStatus($value)
	{
		$sql = "update `group` set `status` = '$value' ";
		return $this->getDI()->get('db')->execute($sql);
	}

	public function updateGroup($name, $idroom)
	{
		$sql = "update `group` set name = '$name' where idgroup = $idroom";
		echo $sql;
		return $this->getDI()->get('db')->execute($sql);
	}

	public function deleteGroup($idgroup)
	{
		$this->deleteAdmin($this->table, 'idgroup', $idgroup);
	}
}

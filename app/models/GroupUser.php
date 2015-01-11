<?php

/**
 * Created by PhpStorm.
 * User: ilu
 * Date: 8/15/14
 * Time: 5:11 PM
 */
class GroupUser extends Admin
{
	public $table = 'group_user';
	public function getIdGroup($idusers)
	{
		$sql = "select idgroup from $this->table where iduser = $idusers";
		echo $sql;
		return $this->getDI()->get('db')->fetchAll($sql, Phalcon\Db::FETCH_OBJ);

	}

	public function insertUserGroup($id, $group)
	{
		$sql = "INSERT INTO $this->table(iduser,idgroup)
		VALUES ($id, $group)";
		echo $sql;
		return $this->getDI()->get('db')->execute($sql);
	}

	/**
	 * xoa han 1 user khoi group, khi ma xoa user
	 * cai nay chua test dau
	 */
	public function deleteUserGroup($id)
	{
		$sql = "Delete from $this->table where iduser = $id";
		return $this->getDI()->get('db')->execute($sql);
	}

	public function getUserGroup($iduser)
	{
		$sql = "SELECT $this->table.*,`group`.name as Gname
				FROM `$this->table`
				JOIN `group`
				ON $this->table.idgroup = `group`.idgroup
				WHERE $this->table.iduser = $iduser";
		return $this->getDI()->get('db')->fetchAll($sql, Phalcon\Db::FETCH_OBJ);
	}

	/*
	 * lay toan bo idgroup cua 1 user
	 */
	public function GetToCompate($table,$where,$iduser,$field)
	{
		$sql = "SELECT $field
				FROM `$table`
				WHERE $where = $iduser";
		return $this->getDI()->get('db')->fetchAll($sql, Phalcon\Db::FETCH_OBJ);
	}

	/*
	 * lay idgroup cua nhung group duoc post len
	 */
	public function GetGroupPost($table,$field1,$ofField1, $field2,$ofField2)
	{
		$sql = "SELECT *
				FROM `$table`
				WHERE $field1 = $ofField1 and $field2 = $ofField2";
		echo $sql;
		return $this->getDI()->get('db')->fetchAll($sql, Phalcon\Db::FETCH_OBJ);
	}

	/**
	 * Them user vao 1 nhom nao do
	 *
	 * @return false/oject
	 */
	public function insertUserToGroup($table,$filed1,$iduser,$field2, $idgroup)
	{
		$sql = "insert into $table(`$filed1`,`$field2`) values($iduser, $idgroup)";
		echo $sql;
		return $this->getDI()->get('db')->execute($sql);
	}

	/**
	 *xoa 1 user khoi 1 group nao do
	 */
	public function deleteUserOfGroup($table, $field1,$ofField1, $field2, $ofField2)
	{
		$sql = "delete from $table where $field1 = $ofField1 and $field2 = $ofField2";
		echo $sql;
		return $this->getDI()->get('db')->execute($sql);

	}
	public function resetUserGroup($idgroup)
	{
		$sql = "update $this->table set idgroup = 1 where idgroup = $idgroup";
		return $this->getDI()->get('db')->execute($sql);
	}
}
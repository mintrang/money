<?php

class Admin extends Phalcon\Mvc\Model
{
	public function deleteAdmin($table, $field, $ofField)
	{
		$del = $table::find("$field = $ofField");
		$del->delete();
	}

	/**
	 * @param $usr
	 * @return object
	 */
	public function listAdmin($table)
	{
		$list = $table::find();
		return $list;
	}
	/**
	 * @return false/object
	 */
	public function editAdmin($table, $field, $iduser, $arr)
	{
		$user = $table::findFirst("$field = $iduser");
		$user->save($arr);
	}

	/*
	 * update theo kieu nao dung ajax (ap dung cho 1 so bang giong nhau)
	 */
	public function updateAjax($table, $where, $id, $field, $value)
	{
		$update = $table::findFirst("$where = $id");
		$update->$field = $value;
		$update->save();
	}

	/**
	 * kiem tra 1 gia tri nao do co ton tai hay chua
	 * @param $username
	 * @return object
	 */
	public function checkExist($table, $field, $value)
	{
		$sql = "select count(*) from $table where $field = $value";
		return $this->getDI()->get('db')->execute($sql);
	}

	/**
	 * kiem tra khi sua, username va email khong duoc trung vs ng khac
	 * ngoai tru cua chinh thang dang sua
	 *
	 * @param $field
	 * @param $ofField
	 * @return object/false
	 */
	public function checkExistUpdate($table, $field, $ofField, $where, $ofWhere)
	{
		$sql = "select * from $table where $field = '" . $ofField . "' and $where != $ofWhere";
		return $this->getDI()->get('db')->fetchOne($sql);
	}
}

<?php

class Room extends Admin
{
	public $table = 'Room';

	/**
	 * @param $usr
	 * @return mixed
	 */
	public function listRoom()
	{
		$list = Room::find("idroom != 0");
		return $list;
	}

	public function updateRoom($field, $name, $idroom)
	{
		$sql = "update room set $field = '$name' where idroom = $idroom";
		echo $sql;
		return $this->getDI()->get('db')->execute($sql);
	}
	/*
	 * khi 1 room bi xoa thi users trong room se nhan idroom = 0
	 */
	public function resetRoom($idroom)
	{
		$sql = "update users set idroom = 0 where idroom = $idroom";
		return $this->getDI()->get('db')->execute($sql);
	}
}

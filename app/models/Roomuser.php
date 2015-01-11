<?php

class Roomuser extends Admin
{
	public $table = 'roomuser';

	public function insertRoomUser($post)
	{
		$sql = "insert into $this->table(idlevel,iduser,chucvu) values ".$post;
		echo $sql;
		return $this->getDI()->get('db')->execute($sql);
	}
	public function getNameChucVu()
	{
		$sql = "select u.idusers, r.chucvu, c.name from users u
				join roomuser r on r.iduser = u.idusers
				join chucvu c on c.idchucvu = r.chucvu
		";
		return $this->getDI()->get('db')->fetchAll($sql, Phalcon\Db::FETCH_OBJ);
	}
	public function deleteUserRoom($id)
	{
		$sql = "delete from $this->table where iduser = $id";
		return $this->getDI()->get('db')->execute($sql);
	}
}
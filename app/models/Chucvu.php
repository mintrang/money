<?php
/**
 * Created by PhpStorm.
 * User: ilu
 * Date: 8/26/14
 * Time: 7:17 AM
 */
class Chucvu extends Admin
{
	public $table = 'chucvu';
	public function listChucVu()
	{
		return $this->listAdmin($this->table);
	}

	public function getUserChucvu($iduser)
	{
		$sql = "SELECT u.idusers,c.idchucvu, c.name,r.idlevel FROM users u
				join roomuser r on r.iduser = u.idusers
				join chucvu c on c.idchucvu = r.chucvu
				WHERE u.idusers = $iduser";
		return $this->getDI()->get('db')->fetchAll($sql, Phalcon\Db::FETCH_OBJ);
	}
}
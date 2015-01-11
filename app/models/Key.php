<?php

/**
 * Created by PhpStorm.
 * User: ilu
 * Date: 7/31/14
 * Time: 9:45 AM
 */
class Key extends Admin
{
	public $table = 'Key';

	public function listAtribute()
	{
		return $this->listAdmin($this->table);
	}

	public function insertAtribute($atribute)
	{
		$sql = 'INSERT INTO `key`(`name`)
		VALUES' . $atribute;
		return $this->getDI()->get('db')->execute($sql);

	}

	public function deteleKey($idkey)
	{
		$user = Key::findFirst("idkey = $idkey");
		$user->delete();
	}

	public function updateKey($idkey, $name)
	{
		return $this->updateAjax($this->table, 'idkey', $idkey, 'name', $name);
	}

	public function insertAjact($atribute)
	{
		$sql = "INSERT INTO `key`(`name`)
		VALUES('$atribute')";
		echo $sql;
		return $this->getDI()->get('db')->execute($sql);
	}

}
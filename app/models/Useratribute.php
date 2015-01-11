<?php

/**
 * Created by PhpStorm.
 * User: ilu
 * Date: 7/31/14
 * Time: 9:45 AM
 */
class Useratribute extends Phalcon\Mvc\Model
{
	/**
	 * insert new value
	 * @param $atribute
	 * @return mixed
	 */
	public $table = 'useratribute';

	public function insertValue($atribute)
	{
		$sql = 'INSERT INTO useratribute(idusers,keyu,valueu)
		VALUES' . $atribute;
		return $this->getDI()->get('db')->execute($sql);
	}

	/**
	 * show list value of every usr
	 */
	public function listValue($iduser)
	{
		$sql = "SELECT useratribute . * , `key`.name
				FROM `useratribute`
				JOIN `key` ON useratribute.`keyu` = `key`.idkey
				WHERE  useratribute.idusers = $iduser
				";
		return $this->getDI()->get('db')->fetchAll($sql, Phalcon\Db::FETCH_OBJ);
	}

	public function FindValueExist($iduser, $key)
	{
		$sql = "SELECT useratribute.*,`key`.idkey FROM `useratribute`
				join `key` ON `key`.idkey = useratribute.keyu
				where idusers = $iduser
				and keyu = $key
				";
//		echo $sql;
		return $this->getDI()->get('db')->fetchOne($sql, Phalcon\Db::FETCH_OBJ);
	}

	public function updateValue($value, $iduser, $key)
	{
		$sql = "UPDATE `useratribute` SET `valueu`= CONCAT(valueu," . "',$value') WHERE idusers = $iduser and keyu = $key" . ';';
		echo $sql;
		return $this->getDI()->get('db')->execute($sql);
	}

	public function updateValueDelete($value, $iduser, $key)
	{
		$sql = "UPDATE `useratribute` SET `valueu`= ('$value') WHERE idusers = $iduser and keyu = $key" . ';';
		echo $sql;
		return $this->getDI()->get('db')->execute($sql);
	}

	public function Exist($iduser, $key)
	{
		$sql = "SELECT useratribute.*,`key`.idkey FROM `useratribute`
				join `key` ON `key`.idkey = useratribute.keyu
				where idusers = $iduser
				and keyu = $key
				";
		echo $sql;
		return $this->getDI()->get('db')->fetchArray($sql, Phalcon\Db::FETCH_OBJ);
	}

	/*
	 * lay value cua cai do ra
	 */
	public function deleteValue($keyu, $idusers)
	{
		$sql = "SELECT `valueu` FROM `useratribute` WHERE `keyu` = $keyu and `idusers` = $idusers";
		return $this->getDI()->get('db')->fetchOne($sql, Phalcon\Db::FETCH_OBJ);
	}

	public function getAvatar($iduser)
	{
		$sql = "SELECT *
				FROM `useratribute` u
				JOIN `key` k ON u.`keyu` = k.idkey
				WHERE k.idkey = 1
				AND u.`idusers` = $iduser";
		return $this->getDI()->get('db')->fetchOne($sql, Phalcon\Db::FETCH_OBJ);
	}
}
<?php

/**
 * Created by PhpStorm.
 * User: ilu
 * Date: 8/17/14
 * Time: 4:47 PM
 */
class Rule extends Admin
{
	public function getRule_($idgroup, $resource)
	{
		$sql = "select action from rule where idgroup = $idgroup and resource = '$resource'";
		return $this->getDI()->get('db')->fetchOne($sql, Phalcon\Db::FETCH_OBJ);
//		$list = Rule::find(array("idgroup"))
	}

	public function getRule($idgroup, $resource)
	{
		$sql = "select action from rule where idgroup in ($idgroup) and resource = '$resource'";
//		echo $sql;
		return $this->getDI()->get('db')->fetchAll($sql, Phalcon\Db::FETCH_OBJ);
	}

	public function checkExistAction($idgroup, $resource)
	{
		$sql = "select * from rule where idgroup = $idgroup and resource = '$resource'";
		return $this->getDI()->get('db')->fetchOne($sql, Phalcon\Db::FETCH_OBJ);
	}

	public function updateAction($action, $idgroup, $resource)
	{
		$sql = "UPDATE `rule` SET `action`= CONCAT(action," . "',$action') WHERE idgroup = $idgroup and resource = '$resource'" . ';';
		return $this->getDI()->get('db')->execute($sql);
	}
}
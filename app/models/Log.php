<?php

/**
 * Created by PhpStorm.
 * User: ilu
 * Date: 7/31/14
 * Time: 9:45 AM
 */
class Log extends Admin
{
	public $table = 'Log';

	public function listLog()
	{
		return $this->listAdmin($this->table);
	}

	public function getLogOfOn($iduser)
	{
		return Log::find("idusers=$iduser");
	}
	public function editLog($idlog,$arrLog)
	{
		$log = Log::findFirst("idlog=$idlog");
		$a = $log->save($arrLog);
		return $a;

	}

}
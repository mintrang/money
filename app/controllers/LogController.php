<?php

/**
 * Created by PhpStorm.
 * User: ilu
 * Date: 8/11/14
 * Time: 10:41 PM
 */
class LogController extends AdminController
{
	public function initialize()
	{
		parent::initialize();
	}

	public function indexAction($iduer)
	{
		if ($this->request->getPost('submit')) {
			$detail = $this->request->getPost('comments');
			$date = $this->request->getPost('time');
			$arrayPost = array('idusers' => $iduer,'detail' => $detail, 'create_time' => $date);
			$log = new Log();
			$log->save($arrayPost);
		}
	}
}
<?php

/**
 * Created by PhpStorm.
 * User: ilu
 * Date: 8/17/14
 * Time: 4:48 PM
 */
class RoleController extends PrivateController
{
	public function initialize()
	{
		parent::initialize();
	}

	public function checkRule()
	{
		$rule = new Rule();
		$iduser = $this->session->get("idusers");
//		$rule->l
	}



	/*
	 * them quyen
	 */
	public function indexAction()
	{
		$this->getGroup();
		if ($this->request->getPost('submit')) {
			$role = new Rule();
			$group = $this->request->getPost('group');
			$resource = $this->request->getPost('resc');
			$check = $role->checkExistAction($group,$resource);
			$action = $this->request->getPost('action');
			if($check == false) {
				$arrPost = array('idgroup' => $group, 'resource' => $resource, 'action' => $action);
				$role->save($arrPost);
			}
			else {
				$role->updateAction($action,$group,$resource);
			}
		}
	}
}
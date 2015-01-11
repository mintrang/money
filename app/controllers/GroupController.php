<?php

/**
 * Created by PhpStorm.
 * User: ilu
 * Date: 8/19/14
 * Time: 11:53 AM
 */
class GroupController extends AdminController
{
	public $modelGroup;

	public function initialize()
	{
		$this->modelGroup = array("modelGroup" => new Group());
		parent::initialize();
	}

	public function indexAction()
	{
		$file = 'my_cache';
		$mycache = $this->cache->get($file);
		if ($mycache === null) {
			$groupList = $this->modelGroup['modelGroup']->listGroup();
			$this->cache->save($file, $groupList);

		}
		$groupList = $this->modelGroup['modelGroup']->listGroup();
		$this->view->setVar('groupList', $groupList);
	}

	public function insertAction()
	{
		$arrField = $this->field();
		foreach ($arrField as $k => $v) {
			$arrField[$k] = 0;
		}
		$status = json_encode($arrField);
		if ($this->request->getPost('submit')) {
			$arr = array('name' => $this->request->getPost('name'),
				'status' => $status
			);
			$this->modelGroup['modelGroup']->save($arr);
		}
	}

	public function editAction()
	{
		$key = $this->request->getPost('key');
		if ($this->request->getPost('value')) {
			$val = $this->request->getPost('value');
			$this->editAdmin('group', 'idgroup', $key, 'name', $val);
		}
	}

	public function deleteAction()
	{
		$id = $this->request->getPost('id');
		$this->modelGroup['modelGroup']->deleteGroup($id);
		$this->modelGroup['modelGroup']->resetUserGroup($id);
	}
}
<?php

/*
 * phan quyen, kiem tra login
 */

class PrivateController extends AdminController
{
	public function initialize()
	{
		$this->redict();
		$this->beforeLoad();
		parent::initialize();
	}

	public function beforeLoad()
	{
		$rule = new Rule();
		$idgroup = $this->session->get('idgroup');
		if ($idgroup == 0) {
			return true;
		}
		if ($idgroup === null || $idgroup == '') {
			die('null');
		} else {

			$listAction = $rule->getRule($idgroup, $this->dispatcher->getControllerName());

			foreach ($listAction as $list) {
				$fuck = in_array($this->dispatcher->getActionName(), explode(',', $list->action));
				if (in_array($this->dispatcher->getActionName(), explode(',', $list->action)) === true) {
					return true;
				} else {

				}
			}
			$this->response->redirect("/abc/index", true);
		}

	}
}
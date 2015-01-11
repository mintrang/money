<?php

/**
 * Created by PhpStorm.
 * User: ilu
 * Date: 8/5/14
 * Time: 10:44 PM
 */
class KeyController extends PrivateController
{
	public $Attr;

	public function initialize()
	{
		parent::initialize();
	}

	/**
	 * nothing is perfect
	 * ms thu deu pai co luat cua no
	 */
	public function indexAction()
	{
		$this->redict();
		if (isset($_POST['submit'])) {
			$keyPost = $this->request->getPost('keyPost');
			$string = '';
			foreach ($keyPost as $key) {
				$string .= "('$key'),";
			}
			$dataInsert = substr($string, 0, -1);
			$atribute = new Key();
			$atribute->insertAtribute($dataInsert);
		}
	}

	public function insertAction()
	{

		$a = $this->request->getPost('key');
		$key = new Key();
		$key->insertAjact($a);
	}

	/**
	 * sua hoac xóa = ajax
	 */
	public function editAction()
	{
		$this->view->setVar('listKey', $this->getKey());
		$key = $this->request->getPost('key');
		if ($this->request->getPost('value')){
			$val = $this->request->getPost('value');
			$this->editAdmin('key','idkey', $key, 'name', $val);
		}
	}
}
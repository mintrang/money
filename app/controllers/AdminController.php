<?php
//define('domain', $_SERVER['SERVER_NAME']);
define('url','http://pri.dt/');
class AdminController extends Phalcon\Mvc\Controller
{
	public $users;
	public $cache;
	public $frontCache;
	public $url = 'http://local.tutorial/';

	public function initialize()
	{
		if ($this->session->has("username")) {
			$name = $this->session->get("username");
			$this->view->setVar('usr', $name);
			$this->view->setVar('url', $this->url);
			$idgroup = $this->session->get('idgroup');
			if ($idgroup == 0) {
				$this->view->setTemplateAfter('usersx');
			} else $this->view->setTemplateAfter('config');

		}
		$this->users = array("modelUsers" => new Users());
	}
	/**
	 * show list users
	 */

	public function listxAction($idRoom, $pp)
	{
        $listUser = $this->users["modelUsers"]->xx($idRoom);
//        var_dump($listUser); die();
		/*
		 * lay cau hinh hien thi
		 * neu la admin thi cai j cung show ra het
		 * neu khong thi theo cau hinh ma admin da dat
		 */
		$idgroup = $this->session->get('idgroup');
		if ($idgroup == 0) {
			$arr = $this->field();
		}
		//cau hinh boi admin
		else {
			foreach (explode(',', $idgroup) as $id) {
				// tra ve mang cau hinh
				$arrConfig = $this->getConfig($id);
				// lay ra nhung cai nao la hien thi
				foreach ($arrConfig as $key => $config) {
					if ($config == 1) {
						$arr[$key] = $config;
					}
				}
			}
		}
//		var_dump($arr); die();
		if ($arr != null) {
			$this->view->setVar('config', $arr);
		}

//		------------------------------------------------------
		// ai lam chuc j
		$r = new Roomuser();

		$this->view->setVar('chucvu',$r->getNameChucVu());
		if ($this->request->getPost('submit_search')) {
			$name = $this->request->getPost('search');
			$listUser = $this->users["modelUsers"]->search($name, $idRoom);
			$page = $this->paginator($listUser, $pp);
			$this->view->setVar('list', $page);
		} else {
            $listUser = $this->users["modelUsers"]->xx($idRoom);
            $page = $this->paginator($listUser, $pp);
            /* neu mun dung memcache
			// dat bien chua cache
			$cacheKey = 'list_user_cache';
			$page = $this->cache->get($cacheKey);
			// neu bien do null thi lay trong csdl
			// khong thi lay o cache
			if ($page === null) {
				$listUser = $this->users["modelUsers"]->xx($idRoom);
				$page = $this->paginator($listUser, $pp);
				$this->cache->save($cacheKey, $page); // nhet du lieu vao bien cache
			}
            */
//			$this->cache->delete($cacheKey);
			$this->view->setVar('list', $page);
		}
	}

	/**
	 * tra ve ten cac truong trong bang users, va gan cho = 1(hien thi)
	 * ap dung voi admin
	 * @return array
	 */
	public function field()
	{
		$group = new Group();
		$a = $group->getFieldDb();
		$levelTable = json_decode(json_encode($group->getFieldOtherTable('level','parent')), true);
		$roomUserTable = json_decode(json_encode($group->getFieldOtherTable('roomuser','chucvu')), true);
		$array = json_decode(json_encode($a), true);
		$total = array_merge($levelTable, $roomUserTable, $array);
		$string = '';
		$value = 0;
		$idgroup = $this->session->get('idgroup');
		if ($idgroup == 0) {
			$value = 1;
		}
		foreach ($total as $key) {
			foreach ($key as $k => $v) {
				$string .= '"' . $v . '"' . ':' . "$value,";
			}
		}
		$json = "{" . substr($string, 0, -1) . "}";
		$xx = json_decode($json);
		$yy = json_decode(json_encode($xx),true);
//		var_dump($yy); die();
		return $yy;
	}

	/**
	 * get "status" field from db
	 *
	 * @return array
	 */
	public function getConfig($idgroup)
	{
		$config = new Group();
		$status = $config->config($idgroup);
		$getStatus = $status->status;
		$arrayStatus = json_decode($getStatus, true);
		return $arrayStatus;
	}

	public function getRoom()
	{
		$roomList = new Room();
		return $this->view->setVar('roomList', $roomList->listRoom());
	}

	public function getGroup()
	{
		$groupList = new Group();
		return $this->view->setVar('groupList', $groupList->listGroup());
	}

	public function paginator($listUser, $currentPage)
	{
		$paginator = new \Phalcon\Paginator\Adapter\Model(
			array(
				"data" => $listUser,
				"limit" => 30,
				"page" => $currentPage
			)
		);
		$page = $paginator->getPaginate();
		return $page;
	}

	public function resetAction()
	{
		$arrField = $this->field();
		foreach ($arrField as $k => $v) {
			$arrField[$k] = 0;
		}
		$json = json_encode($arrField);
		$group = new Group();
		$group->resetStatus($json);
		$this->response->redirect('/users/index', true);
	}

	public function redict()
	{
		if (!$this->session->has("fullname")) {
			$this->response->redirect($this->url, true);
		}
	}

	public function deleteAction()
	{
		$id = $this->request->getPost('id');
		$this->users["modelUsers"]->deteleUser($id);
	}

	public function editAdmin($table, $where, $id, $field, $name)
	{
		$m = new Admin();
		$m->updateAjax($table, $where, $id, $field, $name);
	}

	public function deleteAdmin($table, $field, $ofField)
	{
		$m = new Admin();
		$m->deleteAdmin($table, $field, $ofField);
	}

	public function deleteRoomAction()
	{
		$modelAdmin = new Admin();
		$idroom = $this->request->getPost('id');
		$modelAdmin->deleteAdmin('room', 'idroom', $idroom);
	}

	public function deleteKeyAction()
	{
		$id = $this->request->getPost('id');
		$key = new Key();
		$key->deteleKey($id);
	}

	public function deleteAllAction()
	{
		$ids = substr($this->request->getPost('id'), 0, strlen($this->request->getPost('id')));
		echo $ids;
		$sql = "DELETE FROM Users WHERE idusers in(" . $ids . ")";
		echo $sql;
		$this->modelsManager->executeQuery($sql);
	}

	public function getKey()
	{
		$key = new Key();
		return $listAttr = $key->listAtribute();
		$this->view->setVar('listAttr', $listAttr);
	}

	public function validate()
	{
		$validation = new MyValidation();
		$error = array();
		$messages = $validation->validate($_POST);
		foreach ($validation->getMessages() as $message) {
			$error[$message->getField()] = $message->getMessage();
		}
		return $this->view->setVar('msg', $error);
	}

	public function convertDate($date)
	{
		$arr = explode("/", $date);
		$startFomart = "$arr[2]-$arr[1]-$arr[0]";
		return $startFomart;
	}
}
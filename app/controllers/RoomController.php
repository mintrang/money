<?php

/**
 * Created by PhpStorm.
 * User: ilu
 * Date: 8/11/14
 * Time: 10:41 PM
 */
class RoomController extends AdminController
{
	public function initialize()
	{
		parent::initialize();
	}

	/*
	 * them phong ban moi
	 */
	public function insertAction()
	{
		if ($this->request->getPost('submit')) {
			$name = $this->request->getPost('name');
			$phone = $this->request->getPost('phone');
			$arrPost = array('name' => $name, 'phone' => $phone);
			$room = new Room();
			if ($room->save($arrPost)) {
				$this->response->redirect("/users/index", true);
			}
		}

	}

	/*
	 *sửa tên room
	 */
	public function editAction()
	{

		$key = $this->request->getPost('key');
		$room = new Room();
		if ($this->request->getPost('value')) {
			$val = $this->request->getPost('value');
			$room->updateRoom('name', $val, $key);
		}
	}

	/*
	 * xoa 1 room
	 * đưa toàn bộ user về nhóm 0
	 */
	public function deleteAction()
	{
		$id = $this->request->getPost('id');
		$this->deleteAdmin('level', 'idlevel', $id);
		$room = new Room();
		$room->resetRoom($id);
	}
}
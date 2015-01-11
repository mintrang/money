<?php

/**
 * Created by PhpStorm.
 * User: ilu
 * Date: 8/5/14
 * Time: 10:44 PM
 */
class CategoryController extends PrivateController
{
	public $category;

	public function initialize()
	{
		$this->category = array('modelCate' => new Category());
		parent::initialize();
	}

	public function indexAction()
	{
		$listCate = $this->category['modelCate']->listCategory();
		$this->view->setVar('listCate', $listCate);
	}

	/**
	 * tao category moi
	 */
	public function insertAction()
	{
		if ($this->request->getPost('submit')) {
			$cate = $this->category['modelCate'];
			$nameCate = $this->request->getPost('name');
			$cate->name = $nameCate;
			$cate->save();
		}
	}


	public function editAction()
	{
		$key = $this->request->getPost('key');
		if ($this->request->getPost('value')) {
			$val = $this->request->getPost('value');
			$this->editAdmin('category', 'idcategory', $key, 'name', $val);
		}

	}

	public function deleteAction()
	{
		$id = $this->request->getPost('id');
		$this->deleteAdmin('category', 'idcategory', $id);
	}

	/**
	 * insert cmt to post table
	 * @param $idcate
	 */
	public function postAction($idcate)
	{
		$this->redict();
		$nameCate = $this->category['modelCate']->getNameCate($idcate);
		$this->view->setVar('nameCate', $nameCate);
		if ($this->request->getPost('submit')) {
			$arrayPost = array(
				'detail' => $this->request->getPost('comments'),
				'idusers' => $this->session->get("idusers"),
				'idcategory' => $idcate,
				'start_date' => date('Y-m-d'),
				'end_date' => date("Y-d-m", strtotime($this->request->getPost('end'))),
			);
//			echo date("Y-d-m", strtotime($this->request->getPost('end')));
			$post = new Post();
			$post->save($arrayPost);
		}

	}
}
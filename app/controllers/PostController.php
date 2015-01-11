<?php

/**
 * Created by PhpStorm.
 * User: ilu
 * Date: 8/5/14
 * Time: 10:44 PM
 */
class PostController extends PrivateController
{
	public $post;

	public function initialize()
	{
		$this->post = array('modelPost' => new Post());
		parent::initialize();
	}

	public function indexAction()
	{
		$Cate = new Category();
		$listCate = $Cate->listCategory();
		$this->view->setVar('listCate', $listCate);
	}

	public function insertAction()
	{
		$this->redict();

	}

	public function listAction($cateID)
	{
		$this->redict();
		$listPost = $this->post['modelPost']->listPost($cateID);
		$this->view->setVar('listPost', $listPost);
	}
}
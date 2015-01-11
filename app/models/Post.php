<?php

class Post extends Admin
{
	/**
	 * get name of one category
	 *
	 * @param $idroom
	 * @return mixed
	 */
	public function getNameCate($idcate)
	{
		$nameCate = Category::findFirst($idcate);
		return $nameCate;
	}

	public function showPost()
	{
		$sql = "SELECT category.idcategory as CateID, category.name as Name, post.detail as Detail FROM post join category on category.idcategory = post.idcategory order by post.idpost desc";
		$query = new Phalcon\Mvc\Model\Query($sql, $this->getDI());
		$query->execute();
	}

	public function listPost($cateID)
	{
		$sql = "SELECT post.idpost as idpost,category.idcategory as CateID, category.name as Name, post.detail as Detail
		FROM post
		join category
		on category.idcategory = post.idcategory
		where category.idcategory = $cateID
		";
		return $this->getDI()->get('db')->fetchAll($sql, Phalcon\Db::FETCH_OBJ);
	}
}

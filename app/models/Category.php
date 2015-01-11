<?php

class Category extends Admin
{
	/**
	 * @param $usr
	 * @return mixed
	 */
	public $table = 'Category';
	public function listCategory()
	{
		return $this->listAdmin($this->table);
	}

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
	public function updateCategory($name, $idcategory)
	{
		$sql = "update `category` set name = '$name' where idcategory = $idcategory";
		echo $sql;
		return $this->getDI()->get('db')->execute($sql);
	}
}

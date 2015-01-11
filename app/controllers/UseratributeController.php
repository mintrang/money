<?php

/**
 * Bang mo rong, khi can them 1 truong nao do thi them vao day
 * ma khong can thay doi code
 * User: ilu
 */
class UserAtributeController extends AdminController
{
	public $Attr;

	public function initialize()
	{
		$this->Attr = array("modelAttr" => new UserAtribute());
		parent::initialize();
	}

	public function insertAction($iduser)
	{
		/*
		 * select * from useratribute where iduser = $idusers and keyu = $keyu
		 */
		$m = new Useratribute();
		if ($this->request->getPost('submit')) {
			if ($this->request->getPost('text')) {
				$text = $this->request->getPost('text');
				$this->xuly_value($iduser, $text);
			}
			if ($_FILES['file']['name']) {
				$files = $_FILES['file']['name'];
				$fileTmpLoc = $_FILES["file"]["tmp_name"];

				foreach ($files as $k => $v) {
					foreach ($v as $kk => $vv) {
						$pathAndName = "upload/" . $vv;
						move_uploaded_file($fileTmpLoc[$k][$kk], $pathAndName);
					}
				}
				$this->xuly_value($iduser, $files);
			}
		}
		$listAttr = $this->getKey();
		$this->view->setVar('listAttr', $listAttr);
		foreach ($listAttr as $key) {
			$a = $m->FindValueExist($iduser, $key->idkey);
			if ($a != null) {
				$arr[] = array($a->keyu => $a->valueu);
			}
		}
		$this->view->setVar('user', $iduser);
		$this->view->setVar('value', $arr);
	}

	public function xuly_value($iduser, $text)
	{
		$stringText = '';
		$m = $this->Attr['modelAttr'];
		foreach ($text as $k => $v) {
			$chuoi = implode(',', $v);
			//de khong duoc insert/update du lieu trống
			$reple = str_replace(',', '', $chuoi);
			if ($reple != '' && $reple != null) {
				if (count($v) > 1) {
					$stringText .= "($iduser,$k,'$chuoi'),";
				} else {
					$stringText .= "($iduser,$k,'$v[0]'),";
				}
				$checkExist = $m->FindValueExist($iduser, $k);
				//co roi thi update, chua co thi insert
				if ($checkExist) {
					$m->updateValue($chuoi, $iduser, $k);
				} else {
					$m->insertValue(substr($stringText, 0, -1));
				}
			}
		}
//		die();
	}

	/*
	 *up trùng rồi xóa là die =))
	 * k check nữa
	 */
	public function xoaAction()
	{
		$m = $this->Attr['modelAttr'];
		$id = $this->request->getPost('id');
		$value = $this->request->getPost('value');
		$user = $this->request->getPost('user');
		$val = $m->deleteValue($id, $user); // lay gia tri delete ra, thay the gia tri xoa = '' de update lai
		echo $val->valueu . '<br/>';
		$x = str_replace($value . ',', '', $val->valueu . ',');
		echo $x . '<br/>';
		$m->updateValueDelete(substr($x, 0, -1), $user, $id);
	}


}
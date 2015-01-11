<?php

/**
 * Class UsersController
 *
 * quan ly cac thong tin cua users, very much!
 */
class UsersController extends PrivateController
{
    public $modelUser;

    public function initialize()
    {
        $this->modelUser = array("modelUsers" => new Users());
        parent::initialize();

    }
    /**
     * show all room in company
     */
    public function indexAction()
    {
        $name = $this->session->get("fullname");
        $this->view->setVar('usr', $name);
        $this->getRoom();
        // hien thi thong tin noi bo moi nhat
        $post = $this->getPostAction();
        foreach ($post as $p) {
            $this->view->setVar('detail', $p->Detail);
            $this->view->setVar('start', $p->Start);
            $this->view->setVar('name', $p->Name);
        }
        // hien thi danh sach phong theo cap
        // cha hieu minh viet cai j lun, toan xxx yyy
        $level = new Level();
        $listRoom = $level->getAllRoom();
        foreach ($listRoom as $list) {
            $a2 = array($list->parent);
            foreach ($a2 as $a3) {
                $zz = $level->getParent($a3);
                $a[$list->idlevel] = $zz->phong;
            }
        }
        foreach ($a as $aa) {
            if ($aa == null) $aa = 'Boss';
            $ar[] = $aa;
        }
        $this->view->setVar('a', $ar);
        $this->view->setVar('roomList', $listRoom);

    }

    public function getPostAction()
    {
        $manager = $this->modelsManager;
        $sql = "SELECT category.idcategory as CateID, post.start_date as Start, category.name as Name, post.detail as Detail FROM post join category on category.idcategory = post.idcategory order by post.idpost desc limit 1";
        return $this->modelsManager->executeQuery($sql);
    }

    /**
     * sua users, khong duoc sua email hay usernam trung vs cai da co
     * ngoai tru cua minh--1 dong trash
     *
     * hien thi thong tin cu the cua tung nguoi
     */
    public function detailAction($iduser)
    {
        $user = $this->modelUser['modelUsers'];
//		_____________________lay group ra________________________
        $groupUser = new GroupUser();
        $listGroup = $groupUser->getUserGroup($iduser);
        $this->view->setVar('listGroup', $listGroup);
//		__________________thong tin ban user______________________
        $listTb1 = $user->getEditUser($iduser);
//		_________________thong tin phong nao______________________
        $r = new Level();
        $this->view->setVar('roomListx', $r->getAllRoom());
//		_________________thong tin chuc vu________________________
        $chucvu = new Chucvu();
        $this->view->setVar('chucvu', $chucvu->listChucVu());
        $this->view->setVar('select', $chucvu->getUserChucvu($iduser));

        $this->view->setVar('user', $listTb1);
        $this->getRoom();
        $this->getGroup();

        $stringLog = '';
        $listTb1Array = json_decode(json_encode($listTb1), true);
        foreach ($listTb1Array as $k => $v) {
            $stringLog .= $k . ':' . $v . "\t";
        }
        $stringLog1 = 'Thông tin cũ: ' . $stringLog . "<br/>";

        if ($this->request->getPost('submit')) {
//			xu ly them hay xoa 1 ng khoi group
            $groupPost = $this->request->getPost('idgroup');
            $this->multiSelect($groupPost, 'group_user', 'iduser', $iduser, 'idgroup');

//**************************************** xu ly chuc vu ***************************************************

            $postChucvu = $this->request->getPost('chucvu');
            $this->multiSelect($postChucvu, 'roomuser', 'iduser', $iduser, 'chucvu');
//			foreach ($postChucvu as $cv) {
//				$data1 = $groupUser->getGroupPost('roomuser', 'iduser', $iduser, 'chucvu', $cv);
//				if (empty($data1)) {
//					$groupUser->insertUserToGroup('roomuser', 'iduser', $iduser, 'chucvu', $cv);
//				}
//			}
//
//			//          _Neu dang nam trong group, ma khong chon nua thi xoa no di_
//			$stringOf1 = '';
//			$groupOfUser = $groupUser->GetToCompate('roomuser', 'iduser', $iduser, 'chucvu');
//			foreach ($groupOfUser as $of) {
//				$stringOf1 .= $of->chucvu . ',';
//			}
//			$arrOf1 = explode(',', substr($stringOf1, 0, -1));
//			// so sanh mang idgroup post len va idgroup co sẵn của user
//			// sự khác nhau giữa 2 mảng chính là cái cần pải xóa
//			$diff1 = array_diff($arrOf1, $postChucvu);
//			if ($diff1 != null) {
//				foreach ($diff1 as $gr1) {
//					$groupUser->deleteUserOfGroup('roomuser', 'iduser', $iduser, 'chucvu', $gr1);
//				}
//			}
//			die();
//_________________________________________________________________________________________________
//			kiem tra khi sua, khong trung email, username, validate nhung j can thiet
            if ($this->request->getPost('name')) {
                $username = $this->request->getPost('name');
            }
            if ($this->request->getPost('email')) {
                $email = $this->request->getPost('email');
            }
            $nameExit = $user->checkUpdate('username', $username, 'idusers', $iduser);
            $emailExit = $user->checkUpdate('email', $email, 'idusers', $iduser);
            if ($nameExit != false) {
                $this->view->setVar('nameExist', 'Username da ton tai');
            }
            if ($emailExit != false) {
                $this->view->setVar('emailExist', 'Email da ton tai');
            }
            $repwd = $this->request->getPost('re-password');
            $pwd = $this->request->getPost('password');
            if ($repwd != $pwd) {
                $this->view->setVar('match', 'Re password not match!');
            }
            if ($this->validate() != false) {
                if ($nameExit == false && $emailExit == false && $pwd == $repwd) {
                    $arr = array(
                        'username' => $username,
                        'address' => $this->request->getPost('address'),
                        'birthday' => $this->convertDate($this->request->getPost('birthday')),
                        'email' => $email,
                        'password' => '123456',
                        'fullname' => $this->request->getPost('fullname'),
                        'phone' => $this->request->getPost('phone'),
                        'start_job' => $this->request->getPost('start_job'),
                        'end_job' => $this->request->getPost('end'),
                        'idroom' => $this->request->getPost('idroom'),
                    );
                    $edit = Users::findFirst("idusers = $iduser");
                    if ($edit->save($arr)) {
                        $newLog = '';
                        foreach ($arr as $kk => $vv) {
                            $newLog .= $kk . ':' . $vv . "\t";
                        }
                        $newLog1 = 'Thông tin mới: ' . $newLog;
                        $arrLog = array('idusers' => $iduser,
                            'detail' => $stringLog1 . $newLog1,
                            'create_time' => date('Y-m-d')
                        );
                        $log = new Log();
                        $log->save($arrLog);
                    }
                    $this->response->redirect(url . 'users/list', true);
                }
            } else {
                $this->validate();
            }
//			die();
        }
        //thong tin bang log
        $log = new Log();
        if ($this->request->getPost('log')) {
            $listLog = $log->listLog();
            $caption = $this->request->getPost('caption');
            $detail = $this->request->getPost('detail');
            foreach ($listLog as $list) {
                $a = array('caption' => $this->request->getPost('caption_' . $list->idlog),
                    'detail' => $this->request->getPost('detail_' . $list->idlog));
                $log->editLog($list->idlog, $a);
            }
        }
        //----------- show avatar--------------------------------------------------------------------
        $atribute = new Useratribute();
        $a = $atribute->getAvatar($iduser);
        $b = $a->valueu;
        $img = strstr($b, ',', true);
        $this->view->setVar('img', $img);
        //-------------------------------------------------------------------------------------------

        $listTbl2 = $log->getLogOfOn($iduser);
        $this->view->setVar('listTbl2', $listTbl2);
    }

    public function multiSelect($groupPost, $table, $field1, $iduser, $field2)
    {
        $groupUser = new GroupUser();
//		$groupPost = $this->request->getPost('idgroup');
        foreach ($groupPost as $post) {
            $data = $groupUser->GetGroupPost($table, $field1, $iduser, $field2, $post);
            // neu chua co thi them vao
            if (empty($data)) {
                $groupUser->insertUserToGroup($table, $field1, $iduser, $field2, $post);
            }
        }

//          _Neu dang nam trong group, ma khong chon nua thi xoa no di_
        $stringOf = '';
//			table, iduser, idgroup,$iduser
        $groupOfUser = $groupUser->GetToCompate($table, $field1, $iduser, $field2);
        foreach ($groupOfUser as $of) {
            $stringOf .= $of->$field2 . ',';
        }
        $arrOf = explode(',', substr($stringOf, 0, -1));
        // so sanh mang idgroup post len va idgroup co sẵn của user
        // sự khác nhau giữa 2 mảng chính là cái cần pải xóa
        $diff = array_diff($arrOf, $groupPost);
        if ($diff != null) {
            foreach ($diff as $gr) {
                $groupUser->deleteUserOfGroup($table, $field1, $iduser, $field2, $gr);
            }
        }
    }

    /**
     * hien thi danh sach toan bo nhan vien,
     * theo phong hoac theo toan bo
     */
    public function listAction($idRoom, $pp)
    {
        $this->view->setVar('roomid', $idRoom);
        $this->listxAction($idRoom, $pp);
    }

    /*
     * xoa user thi pai xoa o bang group_user,roomuser
     */
    public function deleteAction()
    {

        $id = $this->request->getPost('id');
        $this->deleteAdmin('users', 'idusers', $id);
        $this->deleteAdmin('GroupUser', 'iduser', $id);
        $this->deleteAdmin('roomuser', 'iduser', $id);
    }

    /**
     * admin config show/hide fields
     *
     * @return json, update to sql
     */
    public function configAction($group)
    {
        $config = new Group();
        $this->view->setVar('dhs', $group);
        $arrayStatus = $this->getConfig($group);
        $this->view->setVar('status', $arrayStatus);
        $key = $this->request->getPost('id');
        $value = $this->request->getPost('select');
        foreach ($arrayStatus as $k => $v) {
            $arrayStatus[$key] = $value;
        }
        $jsonSql = json_encode($arrayStatus);
        echo $jsonSql;
        $config->updateValue($group, $jsonSql);
    }

    /**
     * create new user
     */
    public function insertAction()
    {
//		$room = $this->session->get("idgroup");

        $level = new Level();
        $this->view->setVar('r', $level->getAllRoom());
        // danh sach cac chuc vu
        $chucvu = new Chucvu();
        $this->view->setVar('chucvu', $chucvu->listChucVu());

        if ($this->request->getPost('submit')) {

            if ($this->validate() != false) {
                $nobita = new Users();
                $start = $this->request->getPost('start');
//				$startFomart = $this->convertDate($start);
//				$birthday = $this->convertDate($this->request->getPost('birthday'));
                $birthday = $this->request->getPost('birthday');
                // them 1 nguoi vao phong

                if (isset($_POST['idroom'])) {
                    $room = $_POST['idroom'];
                } else {
                    $room = 'waiting';
                }
                if (isset($_POST['chucvu'])) {
                    $nameChucvu = $_POST['chucvu'];
                } else $nameChucvu = 0;

                $name = str_replace(' ', '', $this->request->getPost('name'));
                $email = $this->request->getPost('email');

                $existName = $nobita->checkUserName('username', $name);
                $existEmail = $nobita->checkUserName('email', $email);
                if ($existName != false) {
                    $this->view->setVar('existName', 'UserName Da ton tai');
                }
                if ($existEmail != false) {
                    $this->view->setVar('existEmail', 'Email Da ton tai');
                }
                if ($existName == false && $existEmail == false) {
                    $arrayPost = array(
                        'email' => $email,
                        'address' => $this->request->getPost('address'),
                        'birthday' => $birthday,
                        'username' => trim($name),
                        'password' => '123456',
                        'phone' => $this->request->getPost('phone'),
                        'start_job' => '2014-08-08',
                        'fullname' => $this->request->getPost('fullname'),
                    );
                    $nobita->save($arrayPost);
                    $lastID = $nobita->idusers; // get last id insert
                    $idgroup = $this->request->getPost('idgroup');
                    $groupModel = new GroupUser();
                    // chen user va group vao bang group_user
                    foreach ($idgroup as $group) {
                        $groupModel->insertUserToGroup('group_user', 'iduser', $lastID, 'idgroup', $group);
                    }
                    $post = '';
                    foreach ($nameChucvu as $n) {
                        $post .= "($room,$lastID,$n),";
                    }
                    $r = new Roomuser();
                    $r->insertRoomUser(substr($post, 0, -1));
//					echo $startFomart;
                    $this->response->redirect($this->url . 'users/list', true);
                }
            } else {
                $this->validate();
            }
        }
        $this->getRoom();
        $this->getGroup();
    }

    /**
     * logout action
     *
     * destroy session
     */
    public function logoutAction()
    {
        if ($this->session->destroy()) {
            $this->response->redirect(url, true);
        } else {
            die();
        }
    }

    public function downdAction()
    {
        $upload_dir = "upload/";
        $filename = isset($_GET['file']) ? $_GET['file'] : '';
        $fp = fopen($upload_dir . $filename, "rb");
        //gởi header đến cho browser
        header('Content-type: application/octet-stream');
        header('Content-disposition: attachment; filename="' . $filename . '"');
        header('Content-length: ' . filesize($upload_dir . $filename));

        //đọc file và trả dữ liệu về cho browser
        fpassthru($fp);
        fclose($fp);
    }

    public function roomLevelAction()
    {
        $this->view->setVar('roomLevel', $this->recursive());

    }

    // de quy phong ban, khong dung vi qua cham
    function recursive($categories = array(), $parent = 0, $level = 0)
    {
        $levelx = new Level();
        $categories = json_decode(json_encode($levelx->listxx($parent)), true);
        $ret = '<ul class="ul' . $level . '">';
        foreach ($categories as $index => $category) {
            if ($category['parent'] == $parent) {
                $ret .= "<li class='Tier'. $level'>" . "<a href = " . "'$this->url" . "users/listLv/" . $category['idlevel'] . "'" . ">" . $category['chucvu'] . '</a>';
                $ret .= $this->recursive($categories, $category['idlevel'], $level + 1);
                $ret .= '</li>';
            }
        }
        return $ret . '</ul>';
    }

    public function listLvAction($idlevel)
    {
        $level = new Level();
        $list = $level->getListLevel($idlevel);
        $this->view->setVar('list', $list);
    }

    public function cliAction()
    {
        if($this->request->getPost('submit')) {
//            chdir('E:');
//            chdir('xampp\php');
//            $ouput = shell_exec('phpcs E:\xampp\htdocs\php.php');
//            $this->view->setVar('output',$ouput);
//            die();
        }

//        chdir('E:');
//        chdir('xampp\php');
//        $ouput = shell_exec('phpcs E:\xampp\htdocs\php.php');
////        echo '<pre>' . $ouput . '</pre>';
//        die();
    }

}

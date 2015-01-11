<?php
//use Phalcon\Mvc\View;
class IndexController extends Phalcon\Mvc\Controller
{
	public function testAction()
	{
		echo 'd';
	}
	public function indexAction()
	{
		if ($this->session->has("username")) {
			$this->response->redirect("/users/index", true);
		} else {
			$submit = $this->request->getPost('login');
			if (isset($submit)) {
				$idString = '';
				$users = new users();
				$check = $users->login($this->request->getPost('username'));
				if ($check->username == $this->request->getPost('username') && $check->password == $this->request->getPost('password')) {

					$groupUsers = new GroupUser();
					$this->session->set("idusers", $check->idusers);
//					1 ng co the trong nh group, cho moi group vao session (k gui dc ca mang di)
					$idGroup = $groupUsers->getIdGroup($check->idusers);
					foreach ($idGroup as $id) {
						$idString .= "$id->idgroup,";
					}
					if ($idString != null) {
						$this->session->set('idgroup', substr($idString, 0, -1));
					}
					$this->session->set("username", $check->username);
					$this->session->set("fullname", $check->fullname);
					$this->session->set("role", $check->role);
					setcookie('same', $_SERVER['SERVER_NAME'], time() + 3600, '/', 'local.tutorial');
					$this->response->redirect("/users/index", true);
				} else {
//					$this->view->setVar('usr', $check->username);
//					$this->response->redirect("http://tamtay.vn/", true);
                    $this->response->redirect($this->url, true);
				}
			}
		}

	}
}

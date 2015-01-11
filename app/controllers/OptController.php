<?php
/**
 * Created by PhpStorm.
 * User: ilu
 * Date: 09/01/2015
 * Time: 09:58
 */
class OptController extends Phalcon\Mvc\Controller {
    public function indexAction()
    {
        require_once '../vendor/autoload.php';
        $psl = new phpSec\Core();

        $google = $psl['auth/google'];

        $secret = $google->newKey();
        $url = $google->getUrl('test.vn', $secret);
        $this->view->setVar('qrcode',$url['qr']);
        if($this->request->getPost('submit')) {
//			var_dump($_POST['username']);
            var_dump($google->verify($this->request->getPost('username')));
//			die();
            if($google->verify($this->request->getPost('username'), $secret) === true) {
                /* Valid OTP. */
                echo 'success';
                die();
            } else {
                echo 'fail';
                die();
                /* Invalid OTP. */
            }
        }

    }

}
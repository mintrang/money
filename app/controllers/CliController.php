<?php

/**
 * Created by PhpStorm.
 * User: ilu
 * Date: 8/17/14
 * Time: 11:52 PM
 */
class CliController extends Phalcon\Mvc\Controller
{

    public function aAction()
    {
        $a = '
    <script></script>
<form method="post" enctype="multipart/form-data">
                <input type="file" name="files[]" id="files" multiple="" directory="" webkitdirectory="" mozdirectory="">
                <input class="button" type="submit" value="Upload" name="submit"/>
                </form>';
        echo $a;
        echo '<pre>';
        if($this->request->getPost('submit')){
            $files = $_FILES['files'];
            var_dump($files);
            echo 'fu';
        }
//        chdir('E:');
//        chdir('xampp\php');
//        $ouput = shell_exec('phpcs E:\xampp\htdocs\php.php');
//        echo '<pre>' . $ouput . '</pre>';

        die();
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: kholmatov
 * Date: 11/09/2017
 * Time: 13:56
 */

require_once 'models/TasksService.php';
require_once 'assets/ac_image_class.php';
class TasksController {

    public $view = NULL;
    private $tasksService = NULL;
    public function __construct() {

    }

    public function handleRequest() {
        $action = isset($_GET['action'])?$_GET['action']:NULL;
        try {
            if ( !$action || $action == 'list' ) {
               $this->listTasks();
            } elseif($action == 'new') {
                $this->view->title = 'Create new task';
                $this->view->data = Array(
                                    'id' => 0,
                                    'name' => '',
                                    'email'=> '',
                                    'image'=>'no-photo.jpg',
                                    'status' => 0,
                                    'tasks'=>''
                                    );
                $this->view->admin = 0;
                $this->view->action = $this->view->widgetURL().'?controller=tasks&action=save';
                $this->view->render('task-form');
            }elseif($action == 'save'){
                $this->saveTask();
            }elseif($action == 'delete') {
                echo 'delete';
                //$this->deleteContact();
            } elseif ( $action == 'show' ) {
                echo 'showcon';
                //$this->showContact();
            } else {
                $this->showError("Page not found", "Page for operation ".$action." was not found!");
            }
        } catch ( Exception $e ) {
            // some unknown Exception got through here, use application error page to display it
            $this->showError("Application error", $e->getMessage());
        }
    }

    public function listTasks() {
        $sort = isset($_GET['sort'])?$_GET['sort']:NULL;
        $tasks = new TasksService();
        $paginator = new Paginator();
        $paginator->link = $this->view->widgetURL();
        $paginator->total = $tasks->getTotal();
        $paginator->paginate();
        $atribute = Array(
                'limStar' => ($paginator->currentPage-1)*$paginator->itemsPerPage,
                'limEnd' => $paginator->itemsPerPage,
                'sort' => $sort
        );
        $data = $tasks->getAllTasks($atribute);
        $this->view->data = $data;
        $this->view->title = 'Tasks page';
        $this->view->paginator = $paginator;
        $this->view->render('tasks');
    }

    public function saveTask() {
         $errors = array();
         if(isset($_POST)) {
            $name = isset($_POST['name']) ? $_POST['name']:NULL;
            $email = isset($_POST['email'])? $_POST['email']:NULL;
            $image = isset($_FILES)? $_FILES['fileimage']['tmp_name']:NULL;
            $task = isset($_POST['tasks'])? $_POST['tasks']:NULL;
            $id = isset($_POST['id']) ? $_POST['id']:0;
             $status = isset($_POST['status']) ? $_POST['status']:0;
             if($image){
                $image = $this->uploadImage($image);
//                if(!$image)
            }

            try {
                $tasks = new TasksService();
                if(!$id){
                    $lastID = $tasks->insert($name, $email, $task, $image, $status);
                    $this->view->redirect($this->view->widgetURL());
                }else{
                    $tasks->update();
                }

            } catch (ValidationException $e) {
                $errors = $e->getErrors();
            }
        }
    }

    private function uploadImage($image){
        $img = new acResizeImage($image);
        $img->resize(320, 240);
        $imagename = $this->generateRandomString();
        $folderpath = _ROOTPATH_.'/media/';
        $success = true;
        if (!is_dir($folderpath)) {
            $success = mkdir($folderpath, 0777, true);
        }

        if (!$success) {
            $error =  Array("Can't create $imagename directory");
            throw new ValidationException($errors);
        }

        $img->save($folderpath, $imagename, 'jpg', false, 100);
        return $imagename.'.jpg';
    }

    protected function generateRandomString($length = 32)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function deleteContact() {
        $id = isset($_GET['id'])?$_GET['id']:NULL;
        if ( !$id ) {
            throw new Exception('Internal error.');
        }

        $this->contactsService->deleteContact($id);

        $this->redirect('index.php');
    }

    public function showContact() {
        $id = isset($_GET['id'])?$_GET['id']:NULL;
        if ( !$id ) {
            throw new Exception('Internal error.');
        }
        $contact = $this->contactsService->getContact($id);

        include 'view/contact.php';
    }

    public function showError($title, $message) {
        include 'views/error.php';
    }



}
?>

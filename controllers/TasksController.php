<?php
/**
 * Created by PhpStorm.
 * User: kholmatov
 * Date: 11/09/2017
 * Time: 13:56
 */

require_once 'models/TasksService.php';
require_once 'assets/ac_image_class.php';
require_once('assets/paginator.class.php');
class TasksController
{
    public $view = NULL;
    public $folderpath = _ROOTPATH_ . '/media/';

    public function __construct()
    {

    }

    public function handleRequest()
    {
        $action = isset($_GET['action']) ? $_GET['action'] : NULL;
        try {
            if (!$action || $action == 'list') {
                $this->listTasks();
            } elseif ($action == 'new') {
                $this->view->title = 'Create new task';
                $this->view->data = Array(
                    'id' => 0,
                    'name' => '',
                    'email' => '',
                    'image' => 'no-photo.jpg',
                    'status' => 0,
                    'tasks' => ''
                );
                $this->view->sts = isset($_GET['status']) ? $_GET['status'] : 0;
                $this->view->action = $this->view->widgetURL() . '?controller=tasks&action=save';
                $this->view->render('task-form');
            } elseif ($action == 'save') {
                $this->saveTask();
            } elseif ($action == 'edit') {
                $tasks = new TasksService();
                $id = isset($_GET['id']) ? $_GET['id'] : 0;
                $this->view->sts = isset($_GET['status']) ? $_GET['status'] : 0;
                $data = $tasks->getTaskById(intval($id));
                $this->view->title = $data['name'] ? $data['name'] : 'Task edit page';
                $data['image'] = $data['image'] ? $data['image'] : 'no-photo.jpg';
                $this->view->data = $data;
                $this->view->action = $this->view->widgetURL() . '?controller=tasks&action=save';
                $this->view->render('task-form');

            } elseif ($action == 'delete') {
                if ($this->view->is_admin()) {
                    try {
                        $tasks = new TasksService();
                        $id = isset($_GET['id']) ? $_GET['id'] : 0;
                        $data = $tasks->getTaskById(intval($id));
                        if (file_exists($this->folderpath . $data['image'])) unlink($this->folderpath . $data['image']);
                        $tasks->deleteById(intval($id));
                        $this->view->redirect($this->view->widgetUrl());
                    } catch (Exception $e) {
                        throw $e;
                    }
                }
                $this->showError("Page not found", "Page for operation " . $action . " was not found!");
            } elseif ($action == 'detail') {
                $this->detailTask();
            } else {
                $this->showError("Page not found", "Page for operation " . $action . " was not found!");
            }
        } catch (Exception $e) {
            // some unknown Exception got through here, use application error page to display it
            $this->showError("Application error", $e->getMessage());
        }
    }

    public function listTasks()
    {
        $sort = isset($_GET['sort']) ? $_GET['sort'] : NULL;
        $tasks = new TasksService();
        $paginator = new Paginator($tasks->getTotal(),3,$ipp_array=array(3));
        $paginator->link = $this->view->widgetURL();
        $atribute = Array(
            'limStar' =>$paginator->limit_start,
            'limEnd' => $paginator->limit_end,
            'sort' => $sort
        );
        $data = $tasks->getAllTasks($atribute);
        $this->view->data = $data;
        $this->view->title = 'Tasks page';
        $this->view->paginator = $paginator;
        $this->view->render('tasks');
    }

    public function detailTask()
    {
        $tasks = new TasksService();
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $sts = isset($_GET['status']) ? $_GET['status'] : 0;
        $data = $tasks->getTaskById(intval($id));
        $this->view->title = $data['name'] ? $data['name'] : 'Task detail page';
        $data['image'] = $data['image'] ? $data['image'] : 'no-photo.jpg';
        $this->view->data = $data;
        $this->view->sts = $sts;
        $this->view->render('task-detail');
    }

    public function saveTask()
    {
        $errors = array();
        if (isset($_POST)) {
            $name = isset($_POST['name']) ? $_POST['name'] : NULL;
            $email = isset($_POST['email']) ? $_POST['email'] : NULL;
            $image = isset($_FILES) ? $_FILES['fileimage']['tmp_name'] : NULL;
            $task = isset($_POST['tasks']) ? $_POST['tasks'] : NULL;
            $id = isset($_POST['id']) ? $_POST['id'] : 0;
            $status = isset($_POST['status']) ? 1 : 0;
            $upd = 0;
            if ($image) {
                $image = $this->uploadImage($image);
                $upd = 1;
            }

            try {
                $tasks = new TasksService();
                if (!$id) {
                    $lastID = $tasks->insert($name, $email, $task, $image, $status);
                    $this->view->redirect($this->view->widgetURL() . '?contorller=tasks&action=detail&id=' . $lastID . '&status=1');
                } else {
                    $data = $tasks->getTaskById(intval($id));
                    if($upd==1) {
                        if (file_exists($this->folderpath . $data['image'])) unlink($this->folderpath . $data['image']);
                    }else{
                        $image = $data['image'];
                    }
                    $tasks->updateById($name, $email, $task, $image, $status, $id);
                    $this->view->redirect($this->view->widgetUrl() . '?contorller=tasks&action=edit&id=' . $id .'&status=1');

                }

            } catch (ValidationException $e) {
                $errors = $e->getErrors();
            }
        }
    }


    private function uploadImage($image)
    {
        $img = new acResizeImage($image);
        $img->resize(320, 240);
        $imagename = $this->generateRandomString();
        $success = true;
        if (!is_dir($this->folderpath)) {
            $success = mkdir($this->folderpath, 0777, true);
        }

        if (!$success) {
            $error = Array("Can't create $imagename directory");
            throw new ValidationException($errors);
        }

        $img->save($this->folderpath, $imagename, 'jpg', false, 100);
        return $imagename . '.jpg';
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

    public function showError($title, $message)
    {
        $this->view->title = $title;
        $this->view->message = $message;
        $this->view->render('error');
    }
}

?>

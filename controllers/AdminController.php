<?php
/**
 * Created by PhpStorm.
 * User: kholmatov
 * Date: 12/09/2017
 * Time: 18:02
 */
require_once 'models/AdminService.php';

class AdminController{

    public $view = NULL;

    public function __construct() {

    }

    public function handleRequest() {
            $action = isset($_GET['action'])?$_GET['action']:NULL;
            try {
                if (!$action || $action == 'login' ) {
                    $this->login();
                }elseif($action == 'logout'){
                    if(isset($_SESSION['status'])&&$_SESSION['status']==1)  session_destroy();
                    $this->view->redirect($this->view->widgetUrl());
                }

            } catch ( Exception $e ) {
                // some unknown Exception got through here, use application error page to display it
                $this->showError("Application error", $e->getMessage());
            }
     }

     public function login(){
         $this->view->sts = 1;
         if(isset($_POST) &&!empty($_POST) ){
             $login = $_POST['login']?$_POST['login']:0;
             $code = $_POST['password']?$_POST['password']:0;
             $admin = new AdminService();
             if($admin->compare($login, $code))
                 $this->view->redirect($this->view->widgetUrl());
             $this->view->sts = 0;

         }

         $this->view->title = "Admin panel";
         $this->view->render('login');
     }


}
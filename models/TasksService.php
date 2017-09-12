<?php
/**
 * Created by PhpStorm.
 * User: kholmatov
 * Date: 11/09/2017
 * Time: 13:58
 */
require_once 'db.php';

class TasksService {

    private $tasksGateway = NULL;
    private $_db = NULL;

    public function __construct() {
        if(!$this->_db) $this->_db = new Connection();
        //$this->contactsGateway = new ContactsGateway();
    }

    public function getAllTasks($atribute=array()){
        try{
            $advance = " ";
            if(isset($atribute)){
                if($atribute['sort']){
                    if($atribute['sort']{0}=='-'){
                        $advance .= " ORDER BY ".substr($atribute['sort'], 1)." DESC";
                    }else{
                        $advance .= " ORDER BY ".$atribute['sort']." ASC";
                    }
                }

                $advance .= " LIMIT ".$atribute['limStar'].", ".$atribute['limEnd'];
            }
            $sql = 'SELECT * FROM tasks '.$advance;
            return $this->_db->queryAll($sql);
        }catch(Exception $e){
            $this->_db = $this->_db->closePDO();
            throw $e;
        }
    }

    public function getTotal(){
        try{
            $sql = 'SELECT * FROM tasks';
            return $this->_db->queryTotal($sql);
        }catch(Exception $e){
            $this->_db = $this->_db->closePDO();
            throw $e;
        }
    }


    public function getAllContacts() {
        try {
            $this->_db->select();
            //$this->openDb();
            //$res = $this->contactsGateway->selectAll($order);
            //$this->closeDb();
            //return $res;
        } catch (Exception $e) {
            //$this->closeDb();
            throw $e;
        }
    }

//    public function selectAll($order) {
//        if ( !isset($order) ) {
//            $order = "name";
//        }
//        $dbOrder =  mysql_real_escape_string($order);
//        $dbres = mysql_query("SELECT * FROM contacts ORDER BY $dbOrder ASC");
//
//        $contacts = array();
//        while ( ($obj = mysql_fetch_object($dbres)) != NULL ) {
//            $contacts[] = $obj;
//        }
//
//        return $contacts;
//    }


    public function getContact($id) {
        try {
            $this->openDb();
            $res = $this->contactsGateway->selectById($id);
            $this->closeDb();
            return $res;
        } catch (Exception $e) {
            $this->closeDb();
            throw $e;
        }
        return $this->contactsGateway->find($id);
    }

    private function validateTaskParams( $name, $email, $task) {
        $errors = array();
        if ( !isset($name) || empty($name)) {
            $errors[] = 'Name is required';
        }

        if ( !isset($email) || empty($email)) {
            $errors[] = 'Email is required';
        }

        if ( !isset($task) || empty($task)) {
            $errors[] = 'Task is required';
        }
        if (empty($errors) ) {
            return;
        }
        throw new ValidationException($errors);
    }

    public function insert($name, $email, $task, $image, $status = 0) {
        try {
            $this->validateTaskParams($name, $email, $task);
            $ins_array = Array(
                            'name'=>$name,
                            'email'=>$email,
                            'tasks'=>$task,
                            'image'=>$image,
                            'status'=>$status
                        );
            $lastId = $this->_db->insert('tasks', $ins_array);
            return $lastId;
        } catch (Exception $e) {
            $this->closeDb();
            throw $e;
        }
    }

    public function deleteContact( $id ) {
        try {
            $this->openDb();
            $res = $this->contactsGateway->delete($id);
            $this->closeDb();
        } catch (Exception $e) {
            $this->closeDb();
            throw $e;
        }
    }

}

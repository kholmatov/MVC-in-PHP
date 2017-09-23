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

    public function getTaskById($id){
        if($id){
            $sql = "SELECT * FROM tasks WHERE id = '".$id."'";
            return $this->_db->queryRow($sql);
        }
        return 0;
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
        }catch (Exception $e) {
            $this->closeDb();
            throw $e;
        }

    }

    public function deleteById($id){
        try {
            $sql = "DELETE FROM tasks
               WHERE id = '$id'";
            return $this->_db->delete($sql);
        } catch (Exception $e) {
            $this->closeDb();
            throw $e;
        }
    }

    public function updateById($name, $email, $task, $image, $status, $id){
        try {
            $this->validateTaskParams($name, $email, $task);
            $sql = "UPDATE tasks 
                    SET name='$name', email='$email', tasks='$task', image='$image', status='$status'
                    WHERE id = '$id'";
            return $this->_db->update($sql);
        } catch (Exception $e) {
            $this->closeDb();
            throw $e;
        }
     }

}

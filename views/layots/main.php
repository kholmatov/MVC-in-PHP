<?php
/**
 * Created by PhpStorm.
 * User: kholmatov
 * Date: 11/09/2017
 * Time: 17:49
 */
class MainView {
    protected $them_dir = 'views/';
    protected $vars = array();
    public $url = NULL;
    public $_link = NULL;
    public function __construct($them_dir = null) {
        if ($them_dir !== null) {
            $this->$them_dir = $them_dir;
        }
    }

    public function render($them_file) {
        $them_file .= '.php';
        if (file_exists($this->them_dir.$them_file)) {
            include $this->them_dir.'/layots/header.php';
            include $this->them_dir.$them_file;
            include $this->them_dir.'/layots/footer.php';
        } else {
            throw new Exception('no them file ' . $them_file . ' present in directory ' . $this->them_dir);
        }
    }

    public function __set($name, $value) {
        $this->vars[$name] = $value;
    }

    public function __get($name) {
        return $this->vars[$name];
    }

    public function redirect($location) {
        header('Location: '.$location);
    }

   public function base_url($atRoot=FALSE, $atCore=FALSE, $parse=FALSE){
        if (isset($_SERVER['HTTP_HOST'])) {
            $http = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
            $hostname = $_SERVER['HTTP_HOST'];
            $dir =  str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

            $core = preg_split('@/@', str_replace($_SERVER['DOCUMENT_ROOT'], '', realpath(dirname(__FILE__))), NULL, PREG_SPLIT_NO_EMPTY);
            $core = $core[0];

            $tmplt = $atRoot ? ($atCore ? "%s://%s/%s/" : "%s://%s/") : ($atCore ? "%s://%s/%s/" : "%s://%s%s");
            $end = $atRoot ? ($atCore ? $core : $hostname) : ($atCore ? $core : $dir);
            $base_url = sprintf( $tmplt, $http, $hostname, $end );
        }
        else $base_url = 'http://localhost/';

        if ($parse) {
            $base_url = parse_url($base_url);
            if (isset($base_url['path'])) if ($base_url['path'] == '/') $base_url['path'] = '';
        }

        return $base_url;
    }

    public function widgetURL(){
        if(!$this->url) $this->url = $this->base_url(NULL, TRUE);
        return $this->url;
    }

    public function get_sort_link($column_id, $column_name ){
        $active = "";
        if(isset($_GET['sort'])){
            if(substr($_GET['sort'], 1) == $column_id) $active = "class='desc'";
            if(isset($_GET['sort']) && $_GET['sort'] != $column_id) {
                $query = "?sort=$column_id";
            } else {
                $query = '?sort=-'.$column_id;
                $active = "class='asc'";
            }

        }else{
            $query = "?sort=$column_id";
        }

        $href = $this->widgetURL().$query;
        return "<a $active href='$href'>$column_name</a>";
    }

}
?>
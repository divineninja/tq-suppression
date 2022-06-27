<?php

class Database extends PDO
{
    public function __construct()
    {
        try {
            parent::__construct(DB_TYPE.':host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
        } catch (PDOException $e) {
            echo 'Connection failed:' . $e->getMessage();
            echo '<br />';
            echo DB_TYPE.':host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS;
        }
    }
    
    public function set_url($uri = '')
    {
        return URL. 'index.php?url=' .$uri;
    }

    public function set_password($string = '')
    {
        return md5(md5($string));
    }
}

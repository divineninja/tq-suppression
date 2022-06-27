<?php
class dialer_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function uploadDialer()
    {
        // print_r($_FILES);
        // move uploaded file to sever filesystem
        $filename = $_FILES['leads']['tmp_name'];
        $file_destination = date('YmdHIS') . '_' . str_replace(' ', '_', $_FILES['leads']['name']);
        $destination = dirname(dirname(__FILE__)).'/uploads/dialer/'.$file_destination;
        
        move_uploaded_file($filename, $destination);

        // move to second page supression
        $dialerURI = base64_encode($destination);

        header("location: ".URL."?url=dialer/insertDialer/$dialerURI");
    }
    
    public function uploadDialerV2()
    {
        // print_r($_FILES);
        // move uploaded file to sever filesystem
        $filename = $_FILES['leads']['tmp_name'];
        $file_destination = date('Y_m_d_H_i_s') . '_' . str_replace(' ', '_', $_FILES['leads']['name']);
        $destination = dirname(dirname(__FILE__)).'/uploads/dialer/'.$file_destination;
        
        move_uploaded_file($filename, $destination);

        // move to second page supression
        $dialerURI = base64_encode($destination);
        
        header("location: ".URL."?url=dialer/insertDialerV2/$dialerURI");
    }
    
    public function execQuery($statement)
    {
        $sth = $this->prepare($statement);

        if (!$sth) {
            echo "\nPDO::errorInfo():\n";
            return false;
        } else {
            $sth->execute();
            return $sth;
        }
    }

    public function truncate()
    {
        $sth = $this->prepare('TRUNCATE texo_dialer');
        $sth->execute();
    }

    public function count_content()
    {
        $sth = $this->prepare('SELECT count(*) as total FROM texo_dialer');

        $sth->execute();

        return $sth->fetch(PDO::FETCH_OBJ);
    }
}

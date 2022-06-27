<?php
class campaign_Model extends Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function insert_object($data)
    {
        $data['database'] = 'crm_'.strtolower(str_replace(' ', '_', $data['database']));

        $this->insert('campaign', $data);

        $this->create_database($data['database']);
        
        echo json_encode(array(
                'status' => 'ok',
                'code' => 200,
                'message' => 'User Successfully Registered.'
            ));
        return;
    }

    public function create_database($database)
    {
        $sql = "CREATE DATABASE `{$database}`";
        $sth = $this->prepare($sql);
        $sth->execute();
        return true;
    }
    
    public function get_object_detail($id)
    {
        return $this->selectSingle("SELECT * FROM campaign WHERE id = '$id'");
    }
    
    public function update_object($params)
    {
        $this->update('campaign', $params, "id={$params['id']}");
        echo json_encode(array(
            'status' => 'ok',
            'code' => 200,
            'message' => 'Question Successfully Updated.'
        ));
    }

    
    public function get_objects()
    {
        $sql = "SELECT * FROM campaign";
        return $this->select($sql);
    }
    
    public function update_group($params)
    {
        // update user
        $this->update('campaign', $params, "id= {$params['id']}");
        echo json_encode(array(
                'status' => 'ok',
                'code' => 200,
                'message' => 'User Successfully Updated.'
            ));
    }
    
    public function get_groups()
    {
        return $this->select("SELECT * FROM campaign");
    }
    

    public function delete_object($ids = array())
    {
        foreach ($ids as $id) {
            $this->delete('campaign', "id = '$id'");
        }
    }
    
    public function campaignGetAccounts()
    {
        return $this->select('SELECT * FROM campaign');
    }
}

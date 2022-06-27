<?php
class inclusion_Model extends Model {

    function __construct()
    {
        parent::__construct();

    }//end __construct()


    public function execQuery($statement)
    {
        $sth = $this->prepare($statement);
        $sth->execute();
    }
    
    public function deleteSupression($question)
    {
        $this->delete('inclusion', "question_id = $question");
    }

    public function removeSuppressionGroup($group_id)
    {
        $this->delete('inclusion_group', "id = $group_id");
        $this->delete('inclusion', "`group` = '$group_id'", 0);
        $this->delete('question_inclusion', "`group` = '$group_id'", 0);

        return true;
    }

    public function get_uploaded_files()
    {
        $files = $this->select('SELECT * FROM `inclusion_group`');

        return $files;
    }

    public function get_campaign_group($campaign)
    {
        $campaigns = $this->select("SELECT qs.id as qsid, qs.*, sg.* FROM `question_inclusion` as qs 
            LEFT JOIN inclusion_group as sg ON qs.group = sg.id WHERE qs.campaign = '$campaign'");

        return $campaigns;
    }
    public function truncate()
    {
	$sth = $this->prepare('TRUNCATE inclusion');
    	$sth->execute();
    }

    public function find_inclusion($params)
    {

        $campaign = $params->username;
        
        $phone = $params->phone;

        $question = $params->question;

        $stmt = "SELECT `group` as campaign FROM question_inclusion WHERE campaign = '$campaign' AND question = $question GROUP BY `group`";

        /*echo $stmt;*/
        $campaign_ids = $this->select($stmt);

        $ids = $this->prepare_campaign_ids($campaign_ids);

        $comma_ids = implode(',', $ids);
        
        $suppress_phone = "SELECT * FROM inclusion WHERE phone = '$phone' AND `group` IN($comma_ids)";

        $inclusions = $this->select($suppress_phone);

        if(!empty($inclusions)) {
            $result = json_encode(
                    array(
                        'status'  => 'error',
                        'message' => 'We found phone number on the record. This question can be ask.',
                        'code'    => 200,
                        'stmt'    => $stmt,
                        'sup_query' => $suppress_phone,
                     )
                );
        } else {
            $result = json_encode(
                    array(
                        'status'  => 'success',
                        'message' => 'This question cannot be ask.',
                        'code'    => 400,
						'stmt'	  => $stmt,
						'sup_query' => $suppress_phone,
                     )
                );
        }

        echo $result;
    }

    public function prepare_campaign_ids($campaign_ids)
    {
        $ids = array();

        foreach ($campaign_ids as $key => $value) {
            $ids[] = $value->campaign;
        }

        return $ids;
    }
	
	public function files_with_error()
	{
		$get_files_with_quantity = 'SELECT count(*) as phone_number_total, file_name FROM `texo_dialer` WHERE phone_number LIKE \'%"\' GROUP BY file_name ORDER BY `texo_dialer`.`phone_number` ASC';
		
		return $this->select($get_files_with_quantity);
	}
	public function phone_with_error($filename)
	{
		$phone_with_error = "SELECT phone_number FROM `texo_dialer` WHERE phone_number LIKE '%\"' AND file_name = '{$filename}' ORDER BY `texo_dialer`.`phone_number` ASC";
		
		return $this->select($phone_with_error);
	}
	
    public function find_inclusion_old($params)
    {
        $stmt = "SELECT * FROM inclusion 
                    WHERE phone = '{$params->phone}' 
                    AND campaign = '{$params->username}' 
                    AND question_id = {$params->question}";

        $inclusions = $this->select($stmt);

        if($inclusions) {
            $result = json_encode(
                    array(
                        'status'  => 'error',
                        'message' => 'We found phone number on the record.',
                        'code'    => 400
                     )
                );
        } else {
            $result = json_encode(
                    array(
                        'status'  => 'success',
                        'message' => 'This question can be ask.',
                        'code'    => 200,
						'stmt'	  => $stmt
                     )
                );
        }

        echo $result;
    }

    public function inclusionFile()
    {
        return $this->select('SELECT * FROM inclusion_group');
    }
    
    public function get_available_campaign($value='')
    {
        $get_available_campaign_sql = "SELECT campaign FROM inclusion GROUP BY campaign ORDER BY campaign";

        return $this->select($get_available_campaign_sql);
    }

    public function save_inclusion_group($group_data)
    {
        $id = $this->insert('inclusion_group', $group_data);
	
        return $id;
    }

    public function get_suppressed_phones($campaign, $pagenum)
    {

        if (!(isset($pagenum))) 
        { 
            $pagenum = 1; 
        } 

        $data_query = "SELECT COUNT(*) as total FROM  `inclusion` WHERE campaign = '$campaign'";
        //Here we count the number of results 

        //Edit $data to be your query 
        $data = $this->select($data_query); 
        $rows = $data[0]->total; 

        //This is the number of results displayed per page 
        $page_rows = 5000; 

        //This tells us the page number of our last page 
        $last = ceil($rows/$page_rows); 

        //this makes sure the page number isn't below one, or more than our maximum pages 
        if ($pagenum < 1) 
        { 
            $pagenum = 1; 
        } 
        elseif ($pagenum > $last) 
        { 
            $pagenum = $last; 
        } 

         //This sets the range to display in our query 
        $max = 'LIMIT ' .($pagenum - 1) * $page_rows .',' .$page_rows;

        $sql = "SELECT phone, question_id FROM inclusion WHERE campaign = '$campaign' ORDER BY inclusion_id, phone $max";

        return array(
                'total' => $rows,
                'current_page' => $pagenum,
                'pages' => $last,
                'details' => $this->select($sql),
            );

    }

}//end class

?>

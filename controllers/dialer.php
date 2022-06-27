<?php

/**
 * dialer
 */
class dialer extends Controller
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * activate_product_category
     *
     * @return void
     */
    public function activate_product_category()
    {
        $sql = "ALTER TABLE `texo_dialer` ADD `product_category` TEXT NOT NULL AFTER `position`";
        $this->model->execQuery($sql);

        echo "Done updating database";
    }
    
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        $count = $this->model->count_content();
        $this->view->count = $count->total;
        $this->view->render('dialer/index', false, true);
    }
        
    /**
     * indexv2
     *
     * @return void
     */
    public function indexv2()
    {
        $count = $this->model->count_content();
        $this->view->count = $count->total;
        $this->view->summary = $this->get_summary();
        $this->view->render('dialer/indexv2', false, true);
    }
    
    /**
     * upload
     *
     * @return void
     */
    public function upload()
    {
        $this->model->uploadDialer();
    }
    
    /**
     * uploadV2
     *
     * @return void
     */
    public function uploadV2()
    {
        $this->model->uploadDialerV2();
    }
        
    /**
     * view_record
     *
     * @param  mixed $file_name
     * @return void
     */
    public function view_record($file_name)
    {
        $row_per_page = 100;
        $start = 0;
        $query = '1 = 1';

        $file_name = base64_decode($file_name);

        $this->view->file = $file_name;

        if (isset($_GET['page'])) {
            $page = $_GET["page"];
            $start=($page-1) * $row_per_page;
        }

        if (isset($_GET['phone'])) {
            $phone = $_GET['phone'];
            $query = " phone_number LIKE '%$phone%'";
        }

        $limit=" LIMIT " . $start . "," . $row_per_page;
        $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM texo_dialer WHERE file_name = '{$file_name}' AND $query $limit";
        
        $this->view->records = $this->model->select($sql);
        $this->view->total = $this->model->selectSingle('SELECT FOUND_ROWS() as total')->total;
        $this->view->pages = ceil($this->view->total/$row_per_page);
        $this->view->render('dialer/records', false);
    }
    
    /**
     * delete_dialer
     *
     * @return void
     */
    public function delete_dialer()
    {
        $this->model->truncate();

        header('location:'.$this->view->set_url('dialer'));
    }
    
    /**
     * get_summary
     *
     * @return void
     */
    public function get_summary()
    {
        // $sql = 'SELECT DISTINCT(file_name), count(ID) as total, date_added FROM texo_dialer GROUP BY date_added ORDER BY ID DESC';
        $sql = "SELECT 
					DISTINCT (file_name) as file_name, COUNT(*) AS total,
					DATE_FORMAT(date_added, '%Y-%m-%d') as date_added
				FROM
					texo_dialer
				GROUP BY file_name,date_added;";

        return $this->model->select($sql);
    }
    
    /**
     * csv_to_array
     *
     * @param  mixed $filename
     * @param  mixed $delimiter
     * @return void
     */
    public function csv_to_array($filename='', $delimiter=',')
    {
        if (!file_exists($filename) || !is_readable($filename)) {
            return false;
        }

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (!$header) {
                    $header = $row;
                } else {
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }
        
        return $data;
    }

    
    /**
     * insertDialerV2
     *
     * @param  mixed $uri
     * @return void
     */
    public function insertDialerV2($uri)
    {
        $url = base64_decode($uri);

        $delete_query = "DELETE FROM dialer_error WHERE file_location = '$url'";

        $this->model->execQuery($delete_query);

        // open supression file.
        $dialer = file_get_contents($url);

        $csv = $this->csv_to_array($url, ',');
        
        /*$ex_dialer = explode("\n", $dialer);*/
        $ex_dialer = $csv;
        
        //remove header
        unset($csv[0]);

        // pagination code for saving content
        $count = count($csv);

        $this->show_per_page = 1;

        $pages = ceil($count/$this->show_per_page);

        if (!$pages) {
            $pages = 1;
        }
        
        $value_statement = array();
        
        $item_field = (OBJECT)array();

        for ($i=0; $i <= $pages; $i++) {
            $item = $this->paganation($ex_dialer, $i+1);

            $array_details = $item;
            $value_statement = array();

            foreach ($item as $key => $value) {

                // $details = explode(',', $value);
                $details = $value;

                if (count($details) == 17) {
                    $item_field->phone_number= $this->clean_input($details['phone']);
                    $item_field->title       = $this->clean_input($details['title']);
                    $item_field->first_name  = $this->clean_input($details['fname']);
                    $item_field->middle_name = $this->clean_input($details['mname']);
                    $item_field->last_name   = $this->clean_input($details['lname']);
                    $item_field->address1    = $this->clean_input($details['houseno']);
                    $item_field->address2    = $this->clean_input($details['streetno']);
                    $item_field->address3    = $this->clean_input($details['landmarks']);
                    $item_field->city        = $this->clean_input($details['city']);
                    $item_field->state       = $this->clean_input($details['state']);
                    $item_field->province    = $this->clean_input($details['country']);
                    $item_field->postal_code = $this->clean_input($details['zip']);
                    $item_field->company	 = $this->clean_input($details['companyname']);
                    $item_field->email 	 	 = $this->clean_input($details['email']);
                    $item_field->website 	 = $details['website'];
                    $item_field->position 	 = $this->clean_input($details['position']);
                    $item_field->product_category = $this->clean_input($details['product_category']);
                    $item_field->file_name   = $url;
                    
                    $value_statement[] = "(
							'$item_field->phone_number', 
							'$item_field->title',
							'$item_field->first_name', 
							'$item_field->middle_name',
							'$item_field->last_name',
							'$item_field->address1',
							'$item_field->address2',
							'$item_field->address3',							
							'$item_field->city',
							'$item_field->state',
							'$item_field->province',
							'$item_field->postal_code',
							'$item_field->company',
							'$item_field->email',
							'$item_field->website',
							'$item_field->position',
							'$item_field->file_name')";
                } elseif (count($details) == 16) {
                    $item_field->phone_number= $this->clean_input($details['phone']);
                    $item_field->title 		 = $this->clean_input($details['title']);
                    $item_field->first_name  = $this->clean_input($details['fname']);
                    $item_field->middle_name = $this->clean_input($details['mname']);
                    $item_field->last_name   = $this->clean_input($details['lname']);
                    $item_field->address1    = $this->clean_input($details['houseno']);
                    $item_field->address2    = $this->clean_input($details['streetno']);
                    $item_field->address3    = $this->clean_input($details['landmarks']);
                    $item_field->city        = $this->clean_input($details['city']);
                    $item_field->state       = $this->clean_input($details['state']);
                    $item_field->province    = $this->clean_input($details['country']);
                    $item_field->postal_code = $this->clean_input($details['zip']);
                    $item_field->company	 = $this->clean_input($details['companyname']);
                    $item_field->email 	 	 = $this->clean_input($details['email']);
                    $item_field->website 	 = $details['website'];
                    $item_field->position 	 = $this->clean_input($details['position']);
                    $item_field->product_category = (isset($details['product_category'])) ? $this->clean_input($details['product_category']): 'none';
                    $item_field->file_name   = $url;
                    
                    $value_statement[] = "(
							'$item_field->phone_number', 
							'$item_field->title',
							'$item_field->first_name', 
							'$item_field->middle_name',
							'$item_field->last_name',
							'$item_field->address1',
							'$item_field->address2',
							'$item_field->address3',							
							'$item_field->city',
							'$item_field->state',
							'$item_field->province',
							'$item_field->postal_code',
							'$item_field->company',
							'$item_field->email',
							'$item_field->website',
							'$item_field->position',
							'$item_field->file_name')";
                            
                } else {
                    $count = count($details);
                    $message = "field count does not match the requried count. COUNT( {$count} )";
                    $data = $value;
                    $update_query = "INSERT INTO dialer_error (data, message, file_location) VALUES ( `$data`, `$message`, `$url`)";
                    $this->model->execQuery($update_query);
                }
            }

            /*Check if phone already exist*/
            if (isset($item_field->phone_number)) {
                $check_statement = $this->model->selectSingle("SELECT * FROM texo_dialer WHERE phone_number = '{$item_field->phone_number}'");

                if (!$check_statement) {
                    $value_statement_string = implode("`,`", $value_statement);

                    $insert_query = "INSERT INTO 
										texo_dialer(phone_number, title, 
										first_name, middle_name, last_name, 
										address1, address2, address3, 
										city, state, province, postal_code, 
										company, email, website, position, file_name) 
										VALUES 
										$value_statement_string";
                    $result = $this->model->execQuery($insert_query);
                } else {
                    $update_string = '';
                    foreach ($item_field as $key => $value) {
                        $update_string .= "`{$key}` = '{$value}',";
                    }
                    $update_string = rtrim($update_string, ",");
                    $update_query = "UPDATE texo_dialer SET $update_string WHERE id = {$check_statement->id}";
                    $result = $this->model->execQuery($update_query);
                }
            } else {
                $message = "No Phone number found";
                $value = json_encode($item_field);
                $update_query = "INSERT INTO dialer_error (data, message, file_location) VALUES ( `$value`, `$message`, `$url`)";
                $this->model->execQuery($update_query);
            }
        }

        header('location:'.$this->view->set_url('dialer/indexv2'));
    }


        
    /**
     * clean_input
     *
     * @param  mixed $text
     * @return void
     */
    public function clean_input($text)
    {
        $utf8 = array(
            '/[áàâãªä]/u'   =>   'a',
            '/[ÁÀÂÃÄ]/u'    =>   'A',
            '/[ÍÌÎÏ]/u'     =>   'I',
            '/[íìîï]/u'     =>   'i',
            '/[éèêë]/u'     =>   'e',
            '/[ÉÈÊË]/u'     =>   'E',
            '/[óòôõºö]/u'   =>   'o',
            '/[ÓÒÔÕÖ]/u'    =>   'O',
            '/[úùûü]/u'     =>   'u',
            '/[ÚÙÛÜ]/u'     =>   'U',
            '/ç/'           =>   'c',
            '/Ç/'           =>   'C',
            '/ñ/'           =>   'n',
            '/Ñ/'           =>   'N',
            '/–/'           =>   '-', // UTF-8 hyphen to "normal" hyphen
            '/[’‘‹›‚]/u'    =>   ' ', // Literally a single quote
            '/[“”«»„]/u'    =>   ' ', // Double quote
            '/ /'           =>   ' ', // nonbreaking space (equiv. to 0x160)
        );

        $item = preg_replace(array_keys($utf8), array_values($utf8), $text);

        // $item = preg_replace("/[^a-zA-Z0-9\s]/", "", $item);

        return $item;
    }
        

    /**
     * insertDialer
     *
     * @param  mixed $uri
     * @return void
     */
    public function insertDialer($uri)
    {
        $url = base64_decode($uri);

        // open supression file.
        $dialer = file_get_contents($url);

        $ex_dialer = explode("\n", $dialer);
        
        //remove header
        unset($ex_dialer[0]);

        // pagination code for saving content
        $count = count($ex_dialer);

        $this->show_per_page = IMPORT_ITEM_COUNT;

        $pages = ceil($count/$this->show_per_page);

        if (!$pages) {
            $pages = 1;
        }
        
        $value_statement = array();

        for ($i=1; $i <= $pages; $i++) {
            $item = $this->paganation($ex_dialer, $i);

            $value_statement = array();

            foreach ($item as $key => $value) {
                $details = explode(',', $value);

                if (count($details) == 16) {
                    $title 		 = $this->clean_input($details[1]);
                    $first_name  = $this->clean_input($details[2]);
                    $middle_name = $this->clean_input($details[3]);
                    $last_name   = $this->clean_input($details[4]);
                    $address1    = $this->clean_input($details[5]);
                    $address2    = $this->clean_input($details[6]);
                    $address3    = $this->clean_input($details[7]);
                    $city        = $this->clean_input($details[8]);
                    $state       = $this->clean_input($details[9]);
                    $country     = $this->clean_input($details[10]);
                    $zip         = $this->clean_input($details[11]);
                    $file_name   = $this->clean_input($url);

                    $value_statement[] = "('{$details[0]}', 
							'$title',
							'$first_name', 
							'$middle_name',
							'$last_name',
							'$address1',
							'$address2',
							'$address3',							
							'$city',
							'$state',
							'$country',
							'$zip',
							'$file_name')";
                }
            }

            $value_statement = implode(',', $value_statement);

            $insert_query = "INSERT INTO 
				texo_dialer(phone_number, title, 
					first_name, middle_name, last_name, 
					address1, address2, address3, 
					city, state, province, postal_code, file_name) 
				VALUES $value_statement";

            $this->model->execQuery($insert_query);
        }

        header('location:'.$this->view->set_url('dialer'));
    }


        
    /**
     * paganation
     *
     * @param  mixed $display_array
     * @param  mixed $page
     * @return void
     */
    public function paganation($display_array, $page)
    {
        $show_per_page = $this->show_per_page;
       
        $page = $page < 1 ? 1 : $page;

        // start position in the $display_array
        // +1 is to account for total values.
        $start = ($page - 1) * ($show_per_page);
        $offset = $show_per_page;

        $outArray = array_slice($display_array, $start, $offset);
       
        return $outArray;
    }
}

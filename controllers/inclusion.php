
<?php
class Inclusion extends Controller{
    
    public function __construct(){
        parent::__construct();        
    }

	public function index()
	{	
		$this->view->campaigns = $this->get_campaigns();
		$this->view->files = $this->model->get_uploaded_files();
		$this->view->render('inclusion/inclusion', false, true);
	}

	public function get_inclusion($params)
	{
		$param = json_decode(base64_decode($params));

		$this->model->find_inclusion($param);
	}

	public function deleteUploadFile($id)
	{
		$this->model->removeSuppressionGroup($id);	
	}

	public function questions_api()
	{
		$url = CRM.'questions_api.php?username='.base64_encode($_POST['username']);
		
		$content = $this->get_data($url);
		
		echo $content;
	}
	
	public function get_campaigns()
	{	
		$url = CRM.'api.php';
		
		$content = $this->get_data($url);

		$content = json_decode($content);

		$campaign = array();

		if($content) {
			foreach ($content as $key => $value) {
				$campaign[] = array(
						'database' => $value->database,
						'id'       => $value->id,
						'name'     => $value->name
					);
			}

			return (object)$campaign;
		}
		
	}


	public function delete_qs($id)
	{
		$this->model->delete('question_inclusion', "id = '{$id}'");
	}

	public function get_inclusion_list($campaign)
	{
		$campaigns = $this->model->get_campaign_group($campaign);
		$url = CRM.'/questions_api.php?username='.base64_encode($campaign);

		$question_data = json_decode($this->get_data($url));
		$this->view->questions = $this->prepare_question_display($question_data);
		$this->view->campaigns = $campaigns;

		$this->view->render('inclusion/ajax/list', true);
	}

	public function prepare_question_display($questions)
	{
		$questions_display = array();
		foreach ($questions as $key => $value) {

			$questions_display[$value->id] = $value;
		}

		return $questions_display;
	}
/*
	public function get_data($url) {
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}*/
	
	public function get_data($url)
	{
		$ch = curl_init();
		// Disable SSL verification
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		// Will return the response, if false it print the response
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// Set the url
		curl_setopt($ch, CURLOPT_URL,$url);
		// Execute
		$result=curl_exec($ch);
		// Closing
		curl_close($ch);

		if ( $result ) {
			return $result;
		} else {
			return file_get_contents($url);
		}
	}

	public function manage_inclusion()
	{
		$this->view->q_inclusion = $this->model->select('SELECT * FROM `question_inclusion`');
		$this->view->render('inclusion/manage', false, true);
	}

	public function saveSupression()
	{
		// print_r($_FILES);
		// move uploaded file to sever filesystem
		$filename = $_FILES['inclusion_file']['tmp_name'];
		$file_destination = str_replace(' ', '_', $_FILES['inclusion_file']['name']);
		$destination = dirname(dirname(__FILE__)).'/uploads/inclusion/'.$file_destination;
		
		$campaign = isset($_POST['campaign']) ?$_POST['campaign']: 0;
		$question_id =  isset($_POST['question']) ?$_POST['question']: 0;


		//save group in database
		$group_data = array(
				'file_name' => $file_destination,
				'location' => $destination
			);

		//execute save group
		$group_id = $this->model->save_inclusion_group($group_data);
		
		// move file
		move_uploaded_file($filename, $destination);

		// move to second page inclusion
		$inclusionURI = base64_encode($destination);

		// process upload file
		$url = $this->view->set_url("inclusion/insertSupression/$inclusionURI&id=$question_id&campaign=$campaign&group_id=$group_id");

		// execute using the url
		header("location: $url");
	}

	public function question_inclusion()
	{
		foreach ($_POST['inclusion'] as $key => $value) {
			$q_suppresion = array(
					'campaign' => $_POST['campaign'],
					'question' => $_POST['question'],
					'group'    => $value
				);
			$this->model->insert('question_inclusion', $q_suppresion);
		}

		$url = $this->view->set_url("inclusion/assign");

		header("location: $url");
	}

	public function deleteInclusion($id)
	{
		$this->model->deleteSupression($id);
		Session::set('notice','true');
		Session::set('message',"All inclusion records are successfully removed.");
		header("location: ".$this->view->set_url('questions'));		
	}

	public function assign()
	{	
		$this->view->inclusion_file = $this->model->inclusionFile();
		$this->view->campaigns = $this->get_campaigns();
		$this->view->render('inclusion/assign', false, true);
	}

	public function truncate($id)
	{
		$this->model->truncate();
		Session::set('notice','true');
		Session::set('message',"All content removed.");
		header("location: ".$this->view->set_url('inclusion'));		
	}

	public function insertSupression($inclusionDetails)
	{
		$inclusionURI = base64_decode($inclusionDetails);

		// open inclusion file.
		$inclusion = file_get_contents($inclusionURI);

		// convert string to array
		$ex_inclusion = explode("\n", $inclusion);
	
		// pagination code for saving content
		$count = count($ex_inclusion);

		//set upload per page
		$this->show_per_page = 10000;

		// set total chunks per upload
		$pages = ceil($count/$this->show_per_page);

		// end process if phone number exceeds limit
		if($count >= 1000000) {
			Session::set('notice','true');
			Session::set('message',"<h3>Error! File Upload Limit</h3> Your uploaded file exceeded the limit of 1 million (1000000) phone numbers per upload.");
			header("location: ".$this->view->set_url('questions'));
			exit();
		}


		// before saving new content we will remove all stored data in bind in the question id.
		$question = $_GET['id'];

		// campaign ID
		$campaign = $_GET['campaign'];

		// group ID
		$group_id = $_GET['group_id'];

		$count_sum = array('count' => $count);
		// update group record count
		$count_stat = $this->model->update('inclusion_group', $count_sum, "id = $group_id");
		
		//condition if only one page
		if(!$pages) $pages = 1;

		for ($i=1; $i <= $pages; $i++) { 
			
			$item = $this->paganation($ex_inclusion, $i);


			$value_statement = array();

			foreach ($item as $phone) {
				$value_statement[] = "({$this->clean($phone)}, $group_id)";
			}

			$value_statement = implode(',', $value_statement);

			$insert_query = "INSERT INTO inclusion(phone, `group`)VALUES $value_statement";

			$this->model->execQuery($insert_query);
		}

		Session::set('notice','true');
		Session::set('message',"<strong>$count</strong> phone numbers successfully inserted to database.");

		header("location: ".$this->view->set_url('inclusion'));
	}

	public function clean($string) {
	   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

	   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
	}

	public function paganation($display_array, $page) {
       $show_per_page = $this->show_per_page;
       
       $page = $page < 1 ? 1 : $page;

       // start position in the $display_array
       // +1 is to account for total values.
       $start = ($page - 1) * ($show_per_page);
       $offset = $show_per_page;

       $outArray = array_slice($display_array, $start, $offset);
       
       return $outArray;
    }

    public function find()
    {
    	$this->view->campaign = $this->model->get_available_campaign();
    	$this->view->render('inclusion/find', false, true);
    }

    public function fetch($campaign)
    {
    	$page = (isset($_GET['page'])) ? $_GET['page']: 1;
    	$suppressed = $this->model->get_suppressed_phones($campaign, $page);

    	echo json_encode($suppressed);
    }
	
	public function files_with_error()
	{
		$this->view->items_with_error = $this->model->files_with_error();
	
		$this->view->render('inclusion/files_with_error', false, true);
	}
	
	public function errorFiles($fileName)
	{
		$filename = base64_decode($fileName);
		$this->view->file_name = $filename;
		$this->view->items_with_error = $this->model->files_with_error();
		$this->view->phone_with_error = $this->model->phone_with_error($filename);	
		$this->view->render('inclusion/files_with_error', false, true);
	}
}

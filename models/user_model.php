<?php
class user_Model extends Model {

    function __construct()
    {
        parent::__construct();

    }//end __construct()


    function login($params)
    {

        $params['password'] = $this->set_password($params['password']);
        $login = $this->login_user($params);

        if (empty($login) === false) {
            $_SESSION['logged_in'] = true;
            $_SESSION['role']      = $login->role;
            $_SESSION['user_data'] = $login;
            if (isset($_POST['campaign']) === true) {

                $campaign = $this->get_campaign_detail($_POST['campaign']);

                $_SESSION['campaign']   = $campaign;
                $_SESSION['login_stat'] = 1;

                echo json_encode(
                    array(
                     'status'   => 'ok',
                     'code'     => 200,
                     'message'  => 'successfully Logged In.',
                     'redirect' => $_POST['version'],
                     'campaign' => $campaign,
                     'details'  => $login,
                    )
                );

            } else {
                echo json_encode(
                    array(
                     'status'   => 'ok',
                     'code'     => 200,
                     'message'  => 'successfully Logged In.',
                     'redirect' => $this->set_url(),
                     'details'  => $login,
                    )
                );
            }//end if

            return;
        } else {
            echo json_encode(
                array(
                 'status'  => 'error',
                 'code'    => 600,
                 'message' => 'Username and Password is not Found.',
                )
            );
            return;
        }//end if

    }//end login()


    public function get_campaign_detail($id)
    {
        return $this->selectSingle("SELECT * FROM campaign WHERE id = '$id'");

    }//end get_campaign_detail()


    public function insert_object($data)
    {
        if ($data['password'] !== $data['vpassword']) {
            echo json_encode(
                array(
                 'status'  => 'error',
                 'code'    => 400,
                 'message' => 'Password did not matched.',
                )
            );
            return;
        } else {
            if ($data['password'] !== null) {
                unset($data['vpassword']);
                $data['password'] = $this->set_password($data['password']);
                $this->insert('users', $data);
                echo json_encode(
                    array(
                     'status'  => 'ok',
                     'code'    => 200,
                     'message' => 'User Successfully Registered.',
                    )
                );
            }//end if

        }//end if

    }//end insert_object()


    public function get_object_detail($id)
    {
        return $this->selectSingle("SELECT * FROM users WHERE id = '$id'");

    }//end get_object_detail()


    public function update_object($params)
    {
        // Update user.
        if ($params['password'] !== $params['vpassword']) {
            echo json_encode(
                array(
                 'status'  => 'error',
                 'code'    => 400,
                 'message' => 'Password did not matched.',
                )
            );
            return;
        } else {
            if ($params['password'] !== null) {
                $params['password'] = $this->set_password($params['password']);
            } else {
                unset($params['password']);
            }

            unset($params['vpassword']);
            $this->update('users', $params, "id={$params['id']}");

            echo json_encode(
                array(
                 'status'  => 'ok',
                 'code'    => 200,
                 'message' => 'User Successfully Updated.',
                )
            );
        }//end if

    }//end update_object()


    public function get_objects()
    {
        return $this->select('SELECT * FROM users');

    }//end get_objects()


    public function get_campaigns()
    {
        return $this->select('SELECT * FROM campaign');

    }//end get_campaigns()


    public function delete_object($ids = array())
    {
        foreach ($ids as $id) {
            $this->delete('users', "id = $id");
        }

    }//end delete_object()


}//end class

?>
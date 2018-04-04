
<?php
    class Logins extends CI_Controller{

      
   function login(){

        $data['title'] = 'Login CodeIgniter';
        
        $this->load->view('logins/login',$data);
        
    }

    function login_validation(){

        $this->form_validation->set_rules('username','Username','required');

       // $this->form_validation->set_rules('password','Password','required');

        if($this->form_validation->run()){

            //true
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            //model
            $this->load->model('login_model');
            if($this->login_model->can_login($username, $password)){
                $session_data = array(
                    'username'=> $username,

                );
                $this->session->set_userdata($session_data);
                redirect(base_url().'nodes/show');
            }else{

                $this->session->set_flashdata('error', 'Invalid Username and Password');
                redirect(base_url().'logins/login');
            }

        }else{

            //false
            $this->login();

        }

    }


    function register(){

        $data['title'] = 'register user';

        $this->load->model('login_model');

        $this->form_validation->set_rules('username','Username','required');

        $this->form_validation->set_rules('password','Password','required');

        if($this->form_validation->run()===FALSE){

            
            $this->load->view('logins/register',$data);
            

            }else{

            $this->login_model->register();
            redirect('logins/login');
        }

    }

    function enter(){
        if($this->session->userdata('username') !=''){

            echo'<h2>Welcome - '.$this->session->userdata('username'). '</h2>';
            echo'<a href="'.base_url().'logins/logout">Logout</a>';

        }else{

            redirect(base_url().'logins/login');
        }
    }

    function logout(){

        $this->session->unset_userdata('username');
        redirect(base_url().'logins/login');
    }

}
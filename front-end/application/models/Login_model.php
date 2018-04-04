<?php 

    class login_model extends CI_Model{

        function can_login($username, $password){

            $this->db->where('username',$username);
            $query = $this->db->get('users');  

            if($query->num_rows() >0)
            {
                $row = $query->row();
                $pass = $row->password;

                if (password_verify($password, $pass))
                    { 
                            return true;
                    }else{   

                        return false;
                    }
            }else{
                return false;
            }
        }
        public function register($data){

            {
                $password = $this->input->post('password');
                $options = ['cost' => 12];
                $hashed_pasw =  password_hash($password, PASSWORD_DEFAULT, $options);

                $data = array(

                    'username'=>$this->input->post('username'),
                    'password'=>($hashed_pasw)

                );
                
                $this->db->insert('users',$data);
                
            }
        }


    }
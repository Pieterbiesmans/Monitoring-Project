<?php 

    class crud_model extends CI_Model{

        public function getNodes(){

            $query = $this->db->get('nodes');
            
            return $query->result_array();
        }

        public function getNode($id){

            $query = $this->db->get_where('nodes', array('id'=>$id));
            
            return $query->row_array();
        }


        public function create_node($data){

            {
                $data = array(

                    'name'=>$this->input->post('name'),
                    'address'=>$this->input->post('address')

                );
                
                $this->db->insert('nodes',$data);
                
            }
        }

        public function deleteNode($id){

            $this->db->where('id',$id);
            $this->db->delete('nodes');
            return true;

           

        }

        public function deleteExperiment($id){

            $this->db->where('id',$id);
            $this->db->delete('experiments');
            return true;

        }

        public function update_node(){

            $data = array(

                'name'=>$this->input->post('name'),
                'address'=>$this->input->post('address'),
                'online'=>$this->input->post('online')


            );
            $this->db->where('id',$this->input->post('id'));
            $this->db->update('nodes',$data);
        }


        public function getExperiments(){

            $query = $this->db->get('experiments');
            
            return $query->result_array();
        }

        public function create_experiment($data){

            {
                $data = array(

                    'server'=>$this->input->post('server'),
                    'client'=>$this->input->post('client'),
                    'done'=>$this->input->post('config'),
                    'config'=>$this->input->post('config'),
                    'rep'=>$this->input->post('repeat')

                );
                
                $this->db->insert('experiments',$data);
                
            }
        }

        public function getExperiment($id){

            $query = $this->db->get_where('experiments', array('id'=>$id));
            
            return $query->row_array();
        }

        public function update_experiment(){

            $data = array(

                'server'=>$this->input->post('server'),
                'client'=>$this->input->post('client'),
                'done'=>$this->input->post('done'),
                'config'=>$this->input->post('config'),
                'rep'=>$this->input->post('repeat')


            );
            $this->db->where('id',$this->input->post('id'));
            $this->db->update('experiments',$data);
        }

        public function getTests(){

            $query = $this->db->get('tests');
            
            return $query->result_array();
        }


        public function create_test($data){

            {
                $data = array(

                    'test'=>$this->input->post('test')

                );
                
                $this->db->insert('tests',$data);
                
            }
        }


        public function deleteTest($id){

            $this->db->where('id',$id);
            $this->db->delete('tests');
            return true;

        }

        public function getTest($id){

            $query = $this->db->get_where('tests', array('id'=>$id));
            
            return $query->row_array();
        }

        public function update_test(){

            $data = array(

                'test'=>$this->input->post('test')


            );
            $this->db->where('id',$this->input->post('id'));
            $this->db->update('tests',$data);
        }

        



    }
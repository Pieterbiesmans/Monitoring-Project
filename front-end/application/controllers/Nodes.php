<?php
    class Nodes extends CI_Controller{

      
        public function create(){
           
            $data['title'] = 'create nodes';


            $this->form_validation->set_rules('name','Name','required');

            $this->form_validation->set_rules('address','Address','required');

              if($this->form_validation->run()===FALSE){

                $this->load->view('templates/header');
                $this->load->view('nodes/create',$data);
                $this->load->view('templates/footer');

                }else{

                $this->crud_model->create_node();
                redirect('nodes/show');
            }
            
        }

        public function show(){

            

            $data['nodes_data']  = $this->crud_model->getNodes();
            $this->load->view('templates/header');
            $this->load->view('nodes/show',$data);
            $this->load->view('templates/footer');

        }

        public function delete($id){

            $this->crud_model->deleteNode($id);
            redirect('nodes/show');
        }

        public function edit($id){

           $data['node'] = $this->crud_model->getNode($id);

           if(empty($data['node'])){
               show_404();
           }
            
            $this->load->view('templates/header');
            $this->load->view('nodes/edit',$data);
            $this->load->view('templates/footer');

     }

     public function update(){

        $this->crud_model->update_node();
        redirect('nodes/show');
     }

}

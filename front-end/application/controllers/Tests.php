<?php
    class Tests extends CI_Controller{

      
        public function create(){
           
            $data['title'] = 'create tests';


            $this->form_validation->set_rules('test','Test','required');


              if($this->form_validation->run()===FALSE){

                $this->load->view('templates/header');
                $this->load->view('tests/create',$data);
                $this->load->view('templates/footer');

                }else{

                $this->crud_model->create_test();
                redirect('tests/show');
            }
            
        }

        public function show(){

            $data['tests_data']  = $this->crud_model->getTests();
            $this->load->view('templates/header');
            $this->load->view('tests/show',$data);
            $this->load->view('templates/footer');

        }

        public function delete($id){

            $this->crud_model->deleteTest($id);
            redirect('tests/show');
        }

        public function edit($id){

           $data['test'] = $this->crud_model->getTest($id);

           if(empty($data['test'])){
               show_404();
           }
            
            $this->load->view('templates/header');
            $this->load->view('tests/edit',$data);
            $this->load->view('templates/footer');

     }

     public function update(){

        $this->crud_model->update_test();
        redirect('tests/show');
     }

}
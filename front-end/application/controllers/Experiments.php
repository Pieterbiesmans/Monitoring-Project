<?php
    class Experiments extends CI_Controller{

      

        public function show(){


            $data['experiments_data']  = $this->crud_model->getExperiments();
            $this->load->view('templates/header');
            $this->load->view('experiments/showexp',$data);
            $this->load->view('templates/footer');

        }

        public function create(){
           
            $data['title'] = 'create experiments';


            $this->form_validation->set_rules('server','Server','required');

            $this->form_validation->set_rules('client','Client','required');

            $this->form_validation->set_rules('config','Config','required');

            $this->form_validation->set_rules('repeat','Repeat','required');

              if($this->form_validation->run()===FALSE){

                $this->load->view('templates/header');
                $this->load->view('experiments/create',$data);
                $this->load->view('templates/footer');

                }else{

                $this->crud_model->create_experiment();
                redirect('experiments/show');
            }
            
        }

        public function delete($id){

            $this->crud_model->deleteExperiment($id);
            redirect('experiments/show');
        }

        public function edit($id){

            $data['experiment'] = $this->crud_model->getExperiment($id);
 
            if(empty($data['experiment'])){
                show_404();
            }
             
             $this->load->view('templates/header');
             $this->load->view('experiments/edit',$data);
             $this->load->view('templates/footer');
 
      }

      public function update(){

        $this->crud_model->update_experiment();
        redirect('experiments/show');
     }




     
    }

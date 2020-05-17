<?php
class Admin extends CI_Controller {
public function __construct()
 {
  parent::__construct();
  if($this->session->userdata('id'))
  {
   redirect('private_area');
  }
   $this->load->model('vendor_model');
        
        $this->load->model('user');
  $this->load->library('form_validation');
  $this->load->library('encrypt');

 }



public function view($page ='home'){

        if(!file_exists(APPPATH.'views/admin/admin side/production/'.$page.'.php')){

            show_404();
        }
if($page='home'){
     $data = array();

    if($this->session->userdata('isUserLoggedIn')){
       $data['vendor'] = $this->vendor_model->get_item();
  $this->load->view('admin/admin side/production/addvendor2',$data);

    }

    else{ $this->load->view('admin/admin side/production/home');}
}

if($page!='home'){
        $this->load->view('admin/admin side/production/'.$page); }

    }





public function additem(){




$username=$this->input->post('uname');




        $this->load->helper('form');
        $this->load->library('form_validation');
 
        $data['title'] = 'Create a news item';
 
        $this->form_validation->set_rules('name', 'Title', 'required');
    
        if ($this->form_validation->run() === FALSE)
        {
           
              $this->load->view('admin/admin side/production/additem'); 
         
 
        }
        else
        {
            $this->vendor_model->set_item();
           
       
            $this->load->view('admin/admin side/production/additem'); 
               $this->load->view('admin/admin side/production/success');
        }
        
    
}











 public function account(){
        $data = array();
        if($this->session->userdata('isUserLoggedIn')){
            $data['user'] = $this->user->getRows(array('id'=>$this->session->userdata('userId')));
            //load the view
            $this->load->view('admin/admin side/production/account', $data);
        }else{
            redirect('admin/admin side/production/home');
        }
    }

 public function addproductlist(){
        $data = array();
        if($this->session->userdata('isUserLoggedIn')){
            $data['user'] = $this->user->getRows(array('id'=>$this->session->userdata('userId')));
            //load the view
            $this->load->view('admin/admin side/production/addproductlist', $data);
        }else{
            redirect('admin/admin side/production/home');
        }
    }

    
public function registerproductlist(){

 $data = array();



if($this->session->userdata('isUserLoggedIn')){
            $data['user'] = $this->user->getRows(array('id'=>$this->session->userdata('userId')));


$username=$this->input->post('uname');


    


        $this->load->helper('form');
        $this->load->library('form_validation');
 
        $data['title'] = 'Create a news item';
 
        $this->form_validation->set_rules('name', 'Title', 'required');
   
 
        if ($this->form_validation->run() === FALSE)
        {
             
              $this->load->view('admin/admin side/production/addproductlist',$data); 
         
 
       }
        else
        {

        
        $this->load->library('upload',$config);





    $this->vendor_model->set_product_list();

           

       
            $this->load->view('admin/admin side/production/addproductlist',$data); 
               $this->load->view('admin/admin side/production/success');

   
 
     }


        } else{
            redirect('admin/admin side/production/home');
        }



        

}






public function login(){
        $data = array();
        $ihave=0;
        if($this->session->userdata('success_msg')){
            $data['success_msg'] = $this->session->userdata('success_msg');
            $this->session->unset_userdata('success_msg');
        }
        if($this->session->userdata('error_msg')){
            $data['error_msg'] = $this->session->userdata('error_msg');
            $this->session->unset_userdata('error_msg');

        }
        if($this->input->post('loginSubmit')){
          
        
                $con['returnType'] = 'single';
                $con['conditions'] = array(
                    'username'=>$this->input->post('username'),
                    'password' => md5($this->input->post('password'))
                   
                );
                $checkLogin = $this->user->getRows($con);
                if($checkLogin){
                    $ihave=1;
                    $this->session->set_userdata('isUserLoggedIn',TRUE);
                    $this->session->set_userdata('userId',$checkLogin['id']);
                     $data['user'] = $this->user->getRows(array('id'=>$this->session->userdata('userId')));
            //load the view
              $data['product'] = $this->vendor_model->get_item();
                    $this->load->view('admin/admin side/production/addproduct', $data);
                }else{
                    $data['error_msg'] = 'Wrong user or password, please try again.';
                 $this->load->view('admin/admin side/production/home', $data);}
            
        }
        else {

           $this->load->view('admin/admin side/production/home');   
        }
        //load the view
  
}
    



    public function registration(){
        $data = array();
        $userData = array();
        if($this->input->post('regisSubmit')){
            $this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check');
            $this->form_validation->set_rules('password', 'password', 'required');
            $this->form_validation->set_rules('conf_password', 'confirm password', 'required|matches[password]');

            $userData = array(
                'name' => strip_tags($this->input->post('name')),
                'email' => strip_tags($this->input->post('email')),
                'password' => md5($this->input->post('password')),
                'gender' => $this->input->post('gender'),
                'phone' => strip_tags($this->input->post('phone'))
            );

            if($this->form_validation->run() == true){
                $insert = $this->user->insert($userData);
                if($insert){
                    $this->session->set_userdata('success_msg', 'Your registration was successfully. Please login to your account.');
                    redirect('users/login');
                }else{
                    $data['error_msg'] = 'Some problems occured, please try again.';
                }
            }
        }
        $data['user'] = $userData;
        //load the view
        $this->load->view('users/registration', $data);
    }
    








public function logout(){
        $this->session->unset_userdata('isUserLoggedIn');
        $this->session->unset_userdata('userId');
        $this->session->sess_destroy();
              $this->load->view('admin/admin side/production/home');
    }

       public function email_check($str){
        $con['returnType'] = 'count';
        $con['conditions'] = array('email'=>$str);
        $checkEmail = $this->user->getRows($con);
        if($checkEmail > 0){
            $this->form_validation->set_message('email_check', 'The given email already exists.');
            return FALSE;
        } else {
            return TRUE;
        }
    }


 public function edit()
    {
        $id = $this->uri->segment(3);
        
        if (empty($id))
        {
            show_404();
        }
        
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        $data['title'] = 'Edit a news item';        
        $data['vendor_item'] = $this->vendor_model->get_vendor_by_id($id);
        
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('text', 'Text', 'required');
 
        if ($this->form_validation->run() === FALSE)
        {
            
            $this->load->view('admin/admin side/production/edit', $data);
          
 
        }
        else
        {
            $this->vendor_model->set_vendor($id);
            //$this->load->view('news/success');
            redirect( base_url() . 'index.php/vendor');
        }
    }
     public function delete()
    {
        $id = $this->uri->segment(3);
        
        if (empty($id))
        {
            show_404();
        }
                
        $news_item = $this->vendor_model->get_vendor_by_id($id);
        
        $this->vendor_model->delete_news($id);        
        redirect( base_url() . 'index.php/vendor');        
    }


    
	



}
?>
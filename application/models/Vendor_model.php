<?php
class Vendor_model extends CI_Model {
 
    public function __construct()
    {
        $this->load->database();
    }
    
    public function get_vendor($slug = FALSE)
    {
        if ($slug === FALSE)
        {
            $query = $this->db->get('vendor');
            return $query->result_array();
        }
 
        $query = $this->db->get_where('vendor', array('slug' => $slug));
        return $query->row_array();
    }
    


      public function get_product($slug = FALSE)
    {
        if ($slug === FALSE)
        {  if ( isset($_POST['pname'])=="" )
        { 
            $query = $this->db->get('product');
            return $query->result_array();
        }

else{
$value=$this->input->post('pname');
 $this->db->where('item_name', $value);
$query = $this->db->get('product');
            return $query->result_array();

}

    }
 
        $query = $this->db->get_where('vendor', array('slug' => $slug));
        return $query->row_array();
    }









  














     public function get_item($slug = FALSE)
    {
        if ($slug === FALSE)
        {
            $query = $this->db->get('product_list');
            return $query->result_array();
        }
 
        $query = $this->db->get_where('product_list', array('slug' => $slug));
        return $query->row_array();
    }




  public function get_product_item($slug = FALSE)
    {
       return true;

}

    



    public function get_vendor_by_id($id = 0)
    {
        if ($id === 0)
        {
            $query = $this->db->get('vendor');
            return $query->result_array();
        }
 
        $query = $this->db->get_where('vendor', array('id' => $id));
        return $query->row_array();
    }
    




 public function get_vendor_list_by_id($id = 0)
    {
        if ($id === 0)
        {
            $query = $this->db->get('vendor');
            return $query->result_array();
        }
  
        $query = $this->db->get_where('vendor', array('id >' => $id));
       

     // $query =   $this->db->where(array('vendor.id >'=>$id));
      return $query->result_array();
    }










   public function get_product_by_id($id = 0)
    {
        if ($id === 0)
        {
            $query = $this->db->get('product');
            return $query->result_array();
        }
 
        $query = $this->db->get_where('product', array('id' => $id));
        return $query->row_array();
    }






  public function set_product($id = 0)
    {
        $this->load->helper('url');
 
 
  $this->load->library('encrypt');
  
$file_name=$_FILES['photo1']['name'];
$newfile_name=str_replace(' ','_', $file_name);
$file_name2=$_FILES['photo2']['name'];
$newfile_name2=str_replace(' ','_', $file_name2);
$file_name3=$_FILES['photo3']['name'];
$newfile_name3=str_replace(' ','_', $file_name3);
  
        $slug = url_title($this->input->post('title'), 'dash', TRUE);
 
        $data = array(
            'item_name' => $this->input->post('pname'),
            'name' => $this->input->post('name'),
             'vendor_id' =>$this->session->userdata('userId'),
            'price' => $this->input->post('price'),

           
              'top_photo' => $newfile_name,
                'left_photo' => $newfile_name2,
                  'front_photo' => $newfile_name3,
                    'quantity' => $this->input->post('quantity'),
                    'discription'=> $this->input->post('discription'),
                      'product_id_no' => $this->input->post('idno')
             
        );
        
        if ($id == 0) {
            return $this->db->insert('product', $data);
        } else {
            $this->db->where('id', $id);
            return $this->db->update('product', $data);
        }

         $this->load->view('admin/admin side/production/success');
         return true;
    



     
    }




















public function set_product_list($id = 0)
    {
        $this->load->helper('url');
 


  
        $slug = url_title($this->input->post('name'), 'dash', TRUE);
 
        $data = array(
            
                      'name' => $this->input->post('name')
             
        );
        
        if ($id == 0) {
            return $this->db->insert('product_list', $data);
        } else {
            $this->db->where('id', $id);
            return $this->db->update('product_list', $data);
        }

         $this->load->view('admin/admin side/production/success');
         return true;
    



     
    }









    public function set_vendor($id = 0)
    {
        $this->load->helper('url');
 
 
$file_name=$_FILES['logo']['name'];
$newfile_name=str_replace(' ','_', $file_name);

  $this->load->library('encrypt');

 if(!empty($_POST['lang'])) {    
        foreach($_POST['lang'] as $value){
            $var[]=$value.',';
        }
    }
  $values= $this->input->post('value');
  
        $slug = url_title($this->input->post('title'), 'dash', TRUE);
 
        $data = array(
            'name' => $this->input->post('name'),
            
            'adress' => $this->input->post('adress'),

            'phone' => $this->input->post('phone'),

            'email' => $this->input->post('email'),
              'username' => $this->input->post('uname'),
                'password' =>md5( $this->input->post('password')),
                'can_sell' =>implode(  $var ),
               'logos'=>  $newfile_name
        );
        
        if ($id == 0) {
            return $this->db->insert('vendor', $data);
        } else {
            $this->db->where('id', $id);
            return $this->db->update('vendor', $data);
        }

         $this->load->view('admin/admin side/production/success');
         return true;
    



     
    }











    public function set_item($id = 0)
    {
        $this->load->helper('url');
  $num =$this->input->post('number');
 
  $this->load->library('encrypt');
  $this->load->dbforge();



    
  
  $fields = array();
 if(isset($_POST['var'])) $var=$_POST['var'];
    for($i=1;$i<=$var;$i++){
  $values=$this->input->post('value'.$i.'');
  $result=$this->input->post('res'.$i.'');

  if($result=='DOUBLE'){
$fields[''.$values.'']=array(
                'type' => ''.$result.'',
                
                
       
);

  }

  else{
$fields[''.$values.'']=array(
                'type' => ''.$result.'',
                'constraint' => '250',
                
       
);
}}

        

$fields['id']=array(
                'type' => 'INT',
                'constraint' => '250',
                
       
);
 
$idval=1;
$query = $this->db->get('product_list');
foreach ($query->result() as $row)
{
    $idval=$row->id;
}

$idval+=1;

$this->dbforge->add_key('id', TRUE);
$this->dbforge->add_field($fields);
$this->dbforge->create_table('product'.$idval.'');

        $slug = url_title($this->input->post('title'), 'dash', TRUE);
 



        $data = array(
            'name' => $this->input->post('name'),
            
            
        );
        
        if ($id == 0) {
            return $this->db->insert('product_list', $data);
        } else {
            $this->db->where('id', $id);
            return $this->db->update('product_list', $data);
        }

         $this->load->view('admin/admin side/production/success');
         return true;
    



     
    }








    
    public function delete_news($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('vendor');
    }
    public function delete_product($id,$photo1,$photo2,$photo3)
    {


   unlink("uploads/".$photo1);

 unlink("uploads/".$photo2);
  unlink("uploads/".$photo3);
        $this->db->where('id', $id);
        return $this->db->delete('product');


    }
}
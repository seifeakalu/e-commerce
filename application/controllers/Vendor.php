<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Vendor extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('user');
        $this->load->model('vendor_model');
        $this->load->helper(array(
            'form',
            'url'
        ));
        
        $this->load->helper('url_helper');
        
    }
    
    public function index()
    {
        
        $data['vendor'] = $this->vendor_model->get_vendor();
        $data['title']  = 'News archive';
        $this->load->view('admin/admin side/production/managevendors', $data);
    }
    
    public function getitem()
    {
        
        $data['vendor'] = $this->vendor_model->get_item();
        $data['title']  = 'News archive';
        $this->load->view('admin/admin side/production/addproduct', $data);
    }
    
    public function delete_product()
    {
        $id = $this->uri->segment(3);
        
        $photo1 = $this->uri->segment(4);
        $photo2 = $this->uri->segment(5);
        $photo3 = $this->uri->segment(6);
        
        if (empty($id)) {
            show_404();
        }
        
        $data['product'] = $this->vendor_model->get_product_by_id($id);
        
        $this->vendor_model->delete_product($id, $photo1, $photo2, $photo3);
        redirect(base_url() . 'vendor/myproduct');
        
    }
    
    public function myproduct()
    {
        
        $data['product'] = $this->vendor_model->get_product();
        $data['title']   = 'News archive';
        $this->load->view('admin/admin side/production/manageproduct', $data);
    }
    
    public function viewproduct()
    {
        
        $data['product'] = $this->vendor_model->get_product();
        $data['item']    = $this->vendor_model->get_item();
        $data['title']   = 'News archive';
        $this->load->view('admin/admin side/production/viewproduct', $data);
    }
    
    public function productbyshop()
    {
        
        $data['product'] = $this->vendor_model->get_vendor();
        
        $data['title'] = 'News archive';
        $this->load->view('admin/admin side/production/productbyshop', $data);
    }
    
    public function productform()
    {
        
        $data['product'] = $this->vendor_model->get_item();
        
        if (isset($_POST["itemname"])) {
            $this->load->view('admin/admin side/production/success');
            $count = $_POST["itemname"];
            
            $data['fields'] = $this->db->field_data('product' . $count . '');
            
        } else {
            $query = $this->db->get('product');
        }
        
        if ($this->session->userdata('isUserLoggedIn')) {
            $data['user'] = $this->user->getRows(array(
                'id' => $this->session->userdata('userId')
            ));
        } else {
            redirect('admin/admin side/production/home');
        }
        $this->load->view('admin/admin side/production/addproduct', $data);
    }
    
    public function file_view()
    {
        $this->load->view('admin/admin side/production/addproduct', array(
            'error' => ''
        ));
    }
    
    public function productdetail()
    {
        $id = $this->uri->segment(3);
        
        if (empty($id)) {
            show_404();
        }
        
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        $data['title']        = 'Edit a news item';
        $data['product_item'] = $this->vendor_model->get_product_by_id($id);
        
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('text', 'Text', 'required');
        
        if ($this->form_validation->run() === false) {
            
            if ($this->session->userdata('isUserLoggedIn')) {
                $data['user'] = $this->user->getRows(array(
                    'id' => $this->session->userdata('userId')
                ));
            } else {
                redirect('admin/admin side/production/home');
            }
            $this->load->view('admin/admin side/production/productdetail', $data);
            
        } else {
            $this->vendor_model->set_vendor($id);
            //$this->load->view('news/success');
            redirect(base_url() . 'index.php/vendor');
            
        }
    }
    
    public function productbyid()
    {
        $id = $this->uri->segment(3);
        
        if (empty($id)) {
            show_404();
        }
        
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        $data['title']   = 'Edit a news item';
        $data['product'] = $this->vendor_model->get_vendor_list_by_id($id);
        
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('text', 'Text', 'required');
        
        if ($this->session->userdata('isUserLoggedIn')) {
            $data['user'] = $this->user->getRows(array(
                'id' => $this->session->userdata('userId')
            ));
        } else {
            redirect('admin/admin side/production/home');
        }
        $this->load->view('admin/admin side/production/productbyshop', $data);
        
    }
    
    public function edit()
    {
        $id = $this->uri->segment(3);
        
        if (empty($id)) {
            show_404();
        }
        
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        $data['title']        = 'Edit a news item';
        $data['product_item'] = $this->vendor_model->get_product_by_id($id);
        
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('text', 'Text', 'required');
        
        if ($this->form_validation->run() === false) {
            
            if ($this->session->userdata('isUserLoggedIn')) {
                $data['user'] = $this->user->getRows(array(
                    'id' => $this->session->userdata('userId')
                ));
            } else {
                redirect('admin/admin side/production/home');
            }
            $this->load->view('admin/admin side/production/v_edit', $data);
            
        } else {
            $this->vendor_model->set_vendor($id);
            //$this->load->view('news/success');
            redirect(base_url() . 'index.php/vendor');
            
        }
    }
    
    public function do_update()
    {
        
        $data = array();
        
        if ($this->session->userdata('isUserLoggedIn')) {
            $data['user'] = $this->user->getRows(array(
                'id' => $this->session->userdata('userId')
            ));
        } else {
            redirect('admin/admin side/production/home');
        }
        
        $username = $this->input->post('uname');
        
        $this->load->helper('form');
        $this->load->library('form_validation');
        
        $data['title'] = 'Create a news item';
        
        $this->form_validation->set_rules('name', 'Title', 'required');
        
        if ($this->form_validation->run() === false) {
            
            $this->load->view('admin/admin side/production/addproduct', $data);
            
        } else {
            
            $config = array(
                'upload_path' => "./uploads/",
                'allowed_types' => "gif|jpg|png|jpeg|pdf",
                'overwrite' => true,
                'max_size' => "2048000",
                'remove_spaces' => true
                
            );
            
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('photo1') && $this->upload->do_upload('photo2') && $this->upload->do_upload('photo3')) {
                
                $data = array(
                    'upload_data' => $this->upload->data()
                );
                
                $this->vendor_model->set_product();
                
                if ($this->session->userdata('isUserLoggedIn')) {
                    $data['user'] = $this->user->getRows(array(
                        'id' => $this->session->userdata('userId')
                    ));
                } else {
                    redirect('admin/admin side/production/home');
                }
                
                $this->load->view('admin/admin side/production/addproduct', $data);
                $this->load->view('admin/admin side/production/success');
                
            } else {
                if ($this->session->userdata('isUserLoggedIn')) {
                    $data['user'] = $this->user->getRows(array(
                        'id' => $this->session->userdata('userId')
                    ));
                } else {
                    redirect('admin/admin side/production/home');
                }
                $error = array(
                    'error' => $this->upload->display_errors()
                );
                
                $data['product'] = $this->vendor_model->get_product();
                
                $this->load->view('admin/admin side/production/manageproduct', $data);
                $this->load->view('admin/admin side/production/error', $error);
            }
        }
        
    }
    
    public function do_upload()
    {
        
        $data = array();
        
        if ($this->session->userdata('isUserLoggedIn')) {
            $data['user'] = $this->user->getRows(array(
                'id' => $this->session->userdata('userId')
            ));
        } else {
            redirect('admin/admin side/production/home');
        }
        
        $username = $this->input->post('uname');
        
        $this->db->select('*');
        $this->db->from('product');
        $this->db->where('product_id_no', $this->input->post('idno'));
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            
            $this->load->helper('form');
            $this->load->library('form_validation');
            
            $data['title'] = 'Create a news item';
            
            $this->form_validation->set_rules('name', 'Title', 'required');
            
            if ($this->form_validation->run() === false) {
                
                $this->load->view('admin/admin side/production/addproduct', $data);
                
            } else {
                
                $config = array(
                    'upload_path' => "./uploads/",
                    'allowed_types' => "gif|jpg|png|jpeg|pdf",
                    'overwrite' => true,
                    'max_size' => "2048000",
                    'remove_spaces' => true
                    
                );
                
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('photo1') && $this->upload->do_upload('photo2') && $this->upload->do_upload('photo3')) {
                    
                    $data = array(
                        'upload_data' => $this->upload->data()
                    );
                    
                    $this->vendor_model->set_product();
                    
                    if ($this->session->userdata('isUserLoggedIn')) {
                        $data['user'] = $this->user->getRows(array(
                            'id' => $this->session->userdata('userId')
                        ));
                    } else {
                        redirect('admin/admin side/production/home');
                    }
                    $data['product'] = $this->vendor_model->get_item();
                    $this->load->view('admin/admin side/production/addproduct', $data);
                    $this->load->view('admin/admin side/production/success');
                    
                } else {
                    if ($this->session->userdata('isUserLoggedIn')) {
                        $data['user'] = $this->user->getRows(array(
                            'id' => $this->session->userdata('userId')
                        ));
                    } else {
                        redirect('admin/admin side/production/home');
                    }
                    $error           = array(
                        'error' => $this->upload->display_errors()
                    );
                    $data['product'] = $this->vendor_model->get_item();
                    
                    $this->load->view('admin/admin side/production/addproduct', $data);
                    $this->load->view('admin/admin side/production/error', $error);
                }
            }
            
        }
        
        else {
            
            $error           = array(
                'error' => 'this product allready exist, please use another product or product id '
            );
            $data['product'] = $this->vendor_model->get_item();
            $this->load->view('admin/admin side/production/addproduct', $data);
            $this->load->view('admin/admin side/production/error', $error);
        }
    }
    
    public function addvendor()
    {
        
        $config = array(
            'upload_path' => "./logos/",
            'allowed_types' => "gif|jpg|png|jpeg|pdf",
            'overwrite' => true,
            'max_size' => "2048000",
            'remove_spaces' => true
            
        );
        
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('logo')) {
            
            $data = array(
                'upload_data' => $this->upload->data()
            );
            
        }
        
        $username = $this->input->post('uname');
        
        $this->db->select('*');
        $this->db->from('vendor');
        $this->db->where('username', $username);
        $query = $this->db->get();
        
        if ($query->num_rows() == 0) {
            
            $this->load->helper('form');
            $this->load->library('form_validation');
            
            $data['title'] = 'Create a news item';
            
            $this->form_validation->set_rules('name', 'Title', 'required');
            $this->form_validation->set_rules('email', 'Text', 'required');
            
            if ($this->form_validation->run() === false) {
                $data['product'] = $this->vendor_model->get_item();
                $this->load->view('admin/admin side/production/addvendor2', $data);
                
            } else {
                $this->vendor_model->set_vendor();
                
                $data['product'] = $this->vendor_model->get_item();
                $this->load->view('admin/admin side/production/addvendor2', $data);
                $this->load->view('admin/admin side/production/success');
            }
            
        }
        
        else {
            $this->load->view('admin/admin side/production/addvendor2');
            $this->load->view('admin/admin side/production/error');
        }
    }
    
}
?>

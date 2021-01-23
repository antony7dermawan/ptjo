<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->authenticated(); // Panggil fungsi authenticated
        $this->userdata = $this->session->userdata('userdata');
        $this->session->set_flashdata('segment', explode('/', $this->uri->uri_string()));
    }

    public function authenticated()
    { // Fungsi ini berguna untuk mengecek apakah user sudah login atau belum
        // Pertama kita cek dulu apakah controller saat ini yang sedang diakses user adalah controller Auth apa bukan
        // Karena fungsi cek login hanya kita berlakukan untuk controller selain controller Auth
        if ($this->uri->segment(1) != 'auth' && $this->uri->segment(1) != '') {
            // Cek apakah terdapat session dengan nama authenticated
            if (!$this->session->userdata('authenticated')) // Jika tidak ada / artinya belum login
                redirect('auth'); // Redirect ke halaman login
        }
    }

    public function render_login($content, $data = NULL)
    {
        /*
        * $data['contentnya']
        * variabel diatas ^ nantinya akan dikirim ke file views/template/login/index.php
        * */
        $data['contentnya'] = $this->load->view($content, $data, TRUE);

        $this->load->view('template/login/index', $data);
    }

    public function render_backend($page, $content = null)
    {
        $data['navbar'] = $this->load->view("template/backend/layout/NavbarLayout", $content, TRUE);
        $data['sidebar'] = $this->load->view('template/backend/layout/SidebarLayout', '', TRUE);
        $data['header_content'] = $this->load->view('template/backend/layout/HeaderContentLayout', '', TRUE);
        $data['head_library'] = $this->load->view('template/backend/layout/head_library', '', TRUE);
        $data['content'] = $this->load->view($page, '', true);
        $this->load->view('template/backend/AdminTemplate', $data);
    }

}

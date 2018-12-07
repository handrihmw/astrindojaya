<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH."/third_party/PHPExcel/PHPExcel/IOFactory.php";
class Admin extends CI_Controller {
    private $filename = "import_data"; 
    function __construct() {
        parent::__construct();
        $this->load->model(array('md_user','md_excel','md_master','md_departemen','md_divisi',
                                 'md_jabatan','md_pangkat','md_percobaan',
                                 'md_karyawan','md_permohonan','md_kode', 'md_resign',
                                 'md_penilaian','md_training','md_get','md_penilai',
                                 'md_pemohon','md_mpp'));
        $this->load->library(array('form_validation','session','Pdf'));
        $this->load->helper(array('url','html','form','text','nominal','tanggal'));
        //$this->load->library('Excel');
        if($this->session->userdata('username')=="") {
            redirect('login');
        }
    }

    public function contoh()
        {
            $this->load->view('admin/contoh', $data);
        }

    public function logout() {
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('level');
        session_destroy();
        redirect('login');
    }

	public function index()
	{
        $data['jml']      = $this->md_karyawan->get_total_karyawan(); 
        $data['jmlb']     = $this->md_karyawan->get_total_baru();
        $data['mpp']      = $this->md_mpp->tampil();
        $data['bdy']      = $this->md_karyawan->birthday();
        $data['karyawan'] = $this->md_karyawan->tampil();
        $data['perdep']   = $this->md_master->per_dep();
        $data['perarea']  = $this->md_master->per_area();
        $data['perjns']   = $this->md_master->per_jenis();
        
        $this->load->view('admin/index',$data);
    }

    // ===================================CRUD MASTER DATA START=================================== //
    
    public function departemen()
    {
        $data['departemen'] = $this->md_departemen->tampil();
        $data['judul']      = "Master Data Departemen";

        $this->load->view('admin/data_departemen', $data);
    }

    public function add_departemen()
    {
        $data['judul']   = 'Tambah Data Departemen';
        $data['kode']    = $this->md_kode->kode_departemen();
        $data['name']    = $this->session->userdata('name');

        $this->load->view('admin/add_departemen',$data);
    }

    public function save_departemen()
    {
        $this->form_validation->set_message('is_unique', '{field} sudah terpakai');
        $this->form_validation->set_rules('id', 'Kode Departemen', ['required', 'is_unique[tb_departemen.id]']);

        $this->md_departemen->val_departemen();

        if($this->form_validation->run() === FALSE)
        {
            $this->add_departemen();
        }
        else
        {
            $this->md_departemen->simpan();
            $this->session->set_flashdata('input_sukses','Data Departemen berhasil di input');
            redirect('admin/departemen');
        }
    }

    public function delete_departemen($id)
    {
        $this->md_departemen->hapus($id);
        $this->session->set_flashdata('hapus_sukses','Data Departemen berhasil di hapus');
        redirect('admin/departemen');
    }

    public function edit_departemen($id)
    {
        $data['judul']  = 'Edit Data Departemen';
        $data['kode']   = $this->md_kode->kode_departemen();
        $data['name']   = $this->session->userdata('name');
        $data['dep_']   = $this->md_departemen->edit($id);

        $this->load->view('admin/edit_departemen', $data);
    }

    public function update_departemen($id)
    {
        $this->md_departemen->val_departemen();

        if($this->form_validation->run() === FALSE)
        {
            $this->edit_departemen($id);
        }
        else
        {
            $this->md_departemen->update();
            $this->session->set_flashdata('update_sukses', 'Data Departemen berhasil diperbaharui');
            redirect('admin/departemen');
        }
    }

    public function divisi()
    {
        $data['divisi'] = $this->md_divisi->tampil();
        $data['judul']  = "Master Data Divisi";

        $this->load->view('admin/data_divisi', $data);
    }

    public function add_divisi()
    {
        $data['judul']   = 'Tambah Data Divisi';
        $data['kode']    = $this->md_kode->kode_divisi();
        $data['name']    = $this->session->userdata('name');

        $this->load->view('admin/add_divisi',$data);
    }

    public function save_divisi()
    {
        $this->form_validation->set_message('is_unique', '{field} sudah terpakai');
        $this->form_validation->set_rules('id', 'Kode divisi', ['required', 'is_unique[tb_divisi.id]']);

        $this->md_divisi->val_divisi();

        if($this->form_validation->run() === FALSE)
        {
            $this->add_divisi();
        }
        else
        {
            $this->md_divisi->simpan();
            $this->session->set_flashdata('input_sukses','Data Divisi berhasil di input');
            redirect('admin/divisi');
        }
    }

    public function delete_divisi($id)
    {
        $this->md_divisi->hapus($id);
        $this->session->set_flashdata('hapus_sukses','Data Divisi berhasil di hapus');
        redirect('admin/divisi');
    }

    public function edit_divisi($id)
    {
        $data['judul']  = 'Edit Data divisi';
        $data['kode']   = $this->md_kode->kode_divisi();
        $data['name']   = $this->session->userdata('name');
        $data['dvs_']   = $this->md_divisi->edit($id);

        $this->load->view('admin/edit_divisi', $data);
    }

    public function update_divisi($id)
    {
        $this->md_divisi->val_divisi();

        if($this->form_validation->run() === FALSE)
        {
            $this->edit_divisi($id);
        }
        else
        {
            $this->md_divisi->update();
            $this->session->set_flashdata('update_sukses', 'Data Divisi berhasil diperbaharui');
            redirect('admin/divisi');
        }
    }

    public function jabatan()
    {
        $data['jabatan'] = $this->md_jabatan->tampil();
        $data['judul']  = "Master Data jabatan";

        $this->load->view('admin/data_jabatan', $data);
    }

    public function add_jabatan()
    {
        $data['judul']   = 'Tambah Data jabatan';
        $data['kode']    = $this->md_kode->kode_jabatan();
        $data['name']    = $this->session->userdata('name');

        $this->load->view('admin/add_jabatan',$data);
    }

    public function save_jabatan()
    {
        $this->form_validation->set_message('is_unique', '{field} sudah terpakai');
        $this->form_validation->set_rules('id', 'Kode jabatan', ['required', 'is_unique[tb_jabatan.id]']);

        $this->md_jabatan->val_jabatan();

        if($this->form_validation->run() === FALSE)
        {
            $this->add_jabatan();
        }
        else
        {
            $this->md_jabatan->simpan();
            $this->session->set_flashdata('input_sukses','Data jabatan berhasil di input');
            redirect('admin/jabatan');
        }
    }

    public function delete_jabatan($id)
    {
        $this->md_jabatan->hapus($id);
        $this->session->set_flashdata('hapus_sukses','Data jabatan berhasil di hapus');
        redirect('admin/jabatan');
    }

    public function edit_jabatan($id)
    {
        $data['judul']  = 'Edit Data jabatan';
        $data['kode']   = $this->md_kode->kode_jabatan();
        $data['name']   = $this->session->userdata('name');
        $data['jbt_']   = $this->md_jabatan->edit($id);

        $this->load->view('admin/edit_jabatan', $data);
    }

    public function update_jabatan($id)
    {
        $this->md_jabatan->val_jabatan();

        if($this->form_validation->run() === FALSE)
        {
            $this->edit_jabatan($id);
        }
        else
        {
            $this->md_jabatan->update();
            $this->session->set_flashdata('update_sukses', 'Data jabatan berhasil diperbaharui');
            redirect('admin/jabatan');
        }
    }

    public function pangkat()
    {
        $data['pangkat'] = $this->md_pangkat->tampil();
        $data['judul']  = "Master Data pangkat";

        $this->load->view('admin/data_pangkat', $data);
    }

    public function add_pangkat()
    {
        $data['judul']   = 'Tambah Data pangkat';
        $data['kode']    = $this->md_kode->kode_pangkat();
        $data['name']    = $this->session->userdata('name');

        $this->load->view('admin/add_pangkat',$data);
    }

    public function save_pangkat()
    {
        $this->form_validation->set_message('is_unique', '{field} sudah terpakai');
        $this->form_validation->set_rules('id', 'Kode pangkat', ['required', 'is_unique[tb_pangkat.id]']);

        $this->md_pangkat->val_pangkat();

        if($this->form_validation->run() === FALSE)
        {
            $this->add_pangkat();
        }
        else
        {
            $this->md_pangkat->simpan();
            $this->session->set_flashdata('input_sukses','Data pangkat berhasil di input');
            redirect('admin/pangkat');
        }
    }

    public function delete_pangkat($id)
    {
        $this->md_pangkat->hapus($id);
        $this->session->set_flashdata('hapus_sukses','Data pangkat berhasil di hapus');
        redirect('admin/pangkat');
    }

    public function edit_pangkat($id)
    {
        $data['judul']  = 'Edit Data pangkat';
        $data['kode']   = $this->md_kode->kode_pangkat();
        $data['name']   = $this->session->userdata('name');
        $data['pgk_']   = $this->md_pangkat->edit($id);

        $this->load->view('admin/edit_pangkat', $data);
    }

    public function update_pangkat($id)
    {
        $this->md_pangkat->val_pangkat();

        if($this->form_validation->run() === FALSE)
        {
            $this->edit_pangkat($id);
        }
        else
        {
            $this->md_pangkat->update();
            $this->session->set_flashdata('update_sukses', 'Data pangkat berhasil diperbaharui');
            redirect('admin/pangkat');
        }
    }

    public function penilai()
    {
        $data['karyawan'] = $this->md_penilai->tampil();
        $data['judul']    = "Data Penilai";

        $this->load->view('admin/data_penilai', $data);
    }

    function get_penilai()
	{
		$id_penilai  = $this->input->post('id_penilai');
		$data 		 = $this->md_master->get_penilai_bykode($id_penilai);
		echo json_encode($data);
    }

    public function add_penilai()
    {
        $data['judul']   = 'Tambah Data Penilai';
        $data['idk']     = $this->md_master->get_idk_penilai();
        $data['kode']    = $this->md_kode->kode_penilai();
        $data['name']    = $this->session->userdata('name');

        $this->load->view('admin/add_penilai',$data);
    }

    public function save_penilai()
    {
        $this->form_validation->set_message('is_unique', '{field} sudah terpakai');
        $this->form_validation->set_rules('id_penilai', 'Kode Karyawan', ['required', 'is_unique[tb_penilai.id_penilai]']);

        $this->md_penilai->val_penilai();

        if($this->form_validation->run() === FALSE)
        {
            $this->add_penilai();
        }
        else
        {
            $this->md_penilai->simpan();
            $this->session->set_flashdata('input_sukses','Data Penilai berhasil di input');
            redirect('admin/penilai');
        }
    }

    public function delete_penilai($id)
    {
        $this->md_penilai->hapus($id);
        $this->session->set_flashdata('hapus_sukses','Data Penilai berhasil di hapus');
        redirect('admin/penilai');
    }

    public function edit_penilai($id)
    {
        $data['judul']      = 'Edit Data Penilai';
        $data['idp']        = $this->md_master->get_idp();
        $data['jbt']        = $this->md_master->get_jabatan();
        $data['kode']       = $this->md_kode->kode_penilai();
        $data['name']       = $this->session->userdata('name');
        $data['kry']        = $this->md_penilai->edit($id);

        $this->load->view('admin/edit_penilai', $data);
    }

    public function update_penilai($id)
    {
        $this->md_penilai->val_penilai();

        if($this->form_validation->run() === FALSE)
        {
            $this->edit_penilai($id);
        }
        else
        {
            $this->md_penilai->update();
            $this->session->set_flashdata('update_sukses', 'Data Penilai berhasil diperbaharui');
            redirect('admin/penilai');
        }
    }

    public function pemohon()
    {
        $data['karyawan'] = $this->md_pemohon->tampil();
        $data['judul']    = "Data Pemohon";

        $this->load->view('admin/data_pemohon', $data);
    }

    function get_pemohon()
	{
		$id_pemohon  = $this->input->post('id_pemohon');
		$data 		 = $this->md_master->get_pemohon_bykode($id_pemohon);
		echo json_encode($data);
    }

    public function add_pemohon()
    {
        $data['judul']   = 'Tambah Data Pemohon';
        $data['idk']     = $this->md_master->get_idk_pemohon();
        $data['kode']    = $this->md_kode->kode_pemohon();
        $data['name']    = $this->session->userdata('name');

        $this->load->view('admin/add_pemohon',$data);
    }

    public function save_pemohon()
    {
        $this->form_validation->set_message('is_unique', '{field} sudah terpakai');
        $this->form_validation->set_rules('id_pemohon', 'Kode Karyawan', ['required', 'is_unique[tb_pemohon.id_pemohon]']);

        $this->md_pemohon->val_pemohon();

        if($this->form_validation->run() === FALSE)
        {
            $this->add_pemohon();
        }
        else
        {
            $this->md_pemohon->simpan();
            $this->session->set_flashdata('input_sukses','Data Pemohon berhasil di simpan');
            redirect('admin/pemohon');
        }
    }

    public function delete_pemohon($id)
    {
        $this->md_pemohon->hapus($id);
        $this->session->set_flashdata('hapus_sukses','Data Peohon berhasil di hapus');
        redirect('admin/pemohon');
    }

    public function edit_pemohon($id)
    {
        $data['judul']   = 'Edit Data Pemohon';
        $data['idp']     = $this->md_master->get_idp();
        $data['jbt']     = $this->md_master->get_jabatan();
        $data['kode']    = $this->md_kode->kode_pemohon();
        $data['name']    = $this->session->userdata('name');
        $data['kry']     = $this->md_pemohon->edit($id);

        $this->load->view('admin/edit_pemohon', $data);
    }

    public function update_pemohon($id)
    {
        $this->md_pemohon->val_pemohon();

        if($this->form_validation->run() === FALSE)
        {
            $this->edit_pemohon($id);
        }
        else
        {
            $this->md_pemohon->update();
            $this->session->set_flashdata('update_sukses', 'Data Pemohon berhasil diperbaharui');
            redirect('admin/pemohon');
        }
    }

    // ===================================CRUD MASTER DATA END==================================== //

    // ===================================CRUD USER START======================================== //

    public function pengguna()
	{
        $data['judul']     = 'Data Pengguna';
		$data['users']     = $this->md_user->tampil_user()->result();
        $data['user']      = $this->session->userdata('name');

		$this->load->view('admin/data_user', $data);
    }
    
    public function add_user()
    {
        $data['judul']     = 'Tambah Data Pengguna';
        $data['name']      = $this->session->userdata('name');
        $data['kode']      = $this->md_kode->kode_user();
        
        $this->load->view('admin/add_user',$data);
    }

	public function edit_user($id)
	{
        $data['judul']     = 'Edit Data Pengguna';
        $data['warning']   = '';
        $data['name']      = $this->session->userdata('name');
		$data['user']      = $this->md_user->edit_user($id);
        $data['kode']      = $this->md_kode->kode_user();
        
		$this->load->view('admin/edit_user', $data);
    }
    
    public function save_user()
    {
        $this->form_validation->set_rules('username','Username','required|min_length[2]|max_length[10]|callback_dup_username');
        $this->form_validation->set_rules('name','Nama Lengkap','required|min_length[2]');
        $this->form_validation->set_rules('email','Email','required|valid_email'); 
        $this->form_validation->set_rules('password','Password','required|min_length[5]');
        $this->form_validation->set_rules('level','Level','required');

        $this->form_validation->set_message('dup_username', 'Username sudah digunakan, silahkan gunakan username lain.');
   
      if($this->form_validation->run() == FALSE) {
        $this->add_user();
      } else {

        $data = array(
                    'id'           => $this->input->post('id'),
                    'username'     => $this->input->post('username'),
                    'name'         => $this->input->post('name'),
                    'email'        => $this->input->post('email'),
                    'password'     => md5($this->input->post('password')),
                    'level'        => $this->input->post('level')
                );

        $this->md_user->save_user($data);
        redirect('admin/pengguna');
      }
    }
    //Mengecek Duplikasi Data Username
    public function dup_username($post_username) {
        return $this->md_user->dup_username($post_username);
    }
    
	public function update_user($id)
	{
		$data = array(
            'id'           => $this->input->post('id'),
            'username'     => $this->input->post('username'),
            'name'         => $this->input->post('name'),
            'email'        => $this->input->post('email'),
            'password'     => md5($this->input->post('password')),
            'level'        => $this->input->post('level')
            );
            
        $this->md_user->update_user($id, $data);
        $this->session->set_flashdata('update','information');
		redirect('admin/pengguna');
    }

	public function delete_user($id)
	{
		$this->md_user->delete_user($id);
		$this->session->set_flashdata('delete','information');
		redirect('admin/pengguna');
    }

    public function print_user()
    {
        $data['data'] = $this->md_user->get_user();

        $this->load->view('admin/print_user', $data);
    }

    // ===================================CRUD USER END ======================================== //

    // ===================================CRUD KARYAWAN START======================================== //

    public function dup_nik($post_nik) 
    {
        return $this->md_user->dup_nik($post_nik);
    }

    public function karyawan()
    {
        $data['karyawan'] = $this->md_karyawan->tampil();
        $data['judul']    = "Data Karayawan";

        $msg    = $this->uri->segment(3);
        $alert  = '';
        if($msg == 'success'){
            $alert  = 'Success!!';
        }
        $data['_alert'] = $alert;

        $this->load->view('admin/data_karyawan', $data);
    }

    public function add_karyawan()
    {
        $data['judul']      = "Tambah Data Karayawan";
        $data['dep']        = $this->md_master->get_dept();
        $data['ag']         = $this->md_master->get_agama();
        $data['jbt']        = $this->md_master->get_jabatan();
        $data['dvs']        = $this->md_master->get_divisi();
        $data['pgk']        = $this->md_master->get_pangkat();
        $data['unt']        = $this->md_master->get_unit();
        $data['jkl']        = $this->md_master->get_jk();
        $data['krj']        = $this->md_master->get_kerja();
        $data['nkh']        = $this->md_master->get_nikah();
        $data['name']       = $this->session->userdata('name');
        $data['kode']       = $this->md_kode->kode_karyawan();

        $this->load->view('admin/add_karyawan',$data);
    }

    public function save_karyawan()
    {
        $this->form_validation->set_message('is_unique', '{field} sudah terpakai');
        $this->form_validation->set_rules('id_kry', 'ID Karyawan', ['required', 'is_unique[tb_karyawan.id_kry]']);

        $this->md_karyawan->val_karyawan();

        if($this->form_validation->run() === FALSE)
        {
            $this->add_karyawan();
        }
        else
        {
            $this->md_karyawan->simpan();
            $this->session->set_flashdata('input_sukses','Data Karyawan berhasil di simpan');
            redirect('admin/karyawan');
        }
    }

    public function delete_karyawan($id_kry)
    {
        $this->md_karyawan->hapus($id_kry);
        $this->session->set_flashdata('hapus_sukses','Data Karyawan berhasil di hapus');
        redirect('admin/karyawan');
    }

    public function edit_karyawan($id_kry)
    {
        $data['judul']      = 'Edit Data Karayawan';
        $data['dep']        = $this->md_master->get_dept();
        $data['ag']         = $this->md_master->get_agama();
        $data['jbt']        = $this->md_master->get_jabatan();
        $data['dvs']        = $this->md_master->get_divisi();
        $data['pgk']        = $this->md_master->get_pangkat();
        $data['unt']        = $this->md_master->get_unit();
        $data['jkl']        = $this->md_master->get_jk();
        $data['krj']        = $this->md_master->get_kerja();
        $data['nkh']        = $this->md_master->get_nikah();
        $data['name']       = $this->session->userdata('name');
        $data['kode']       = $this->md_kode->kode_karyawan();
        $data['kry']        = $this->md_karyawan->edit($id_kry);

        $this->load->view('admin/edit_karyawan', $data);
    }

    public function update_karyawan($id_kry)
    {
        $this->md_karyawan->val_karyawan();

        if($this->form_validation->run() === FALSE)
        {
            $this->edit_karyawan($id_kry);
        }
        else
        {
            $this->md_karyawan->update();
            $this->session->set_flashdata('update_sukses', 'Data karyawan berhasil diperbaharui');
            redirect('admin/karyawan');
        }
    }

    function detail_karyawan($id_kry)
    {
        $data['judul']      = 'Detail Data Karayawan';
        $data['karyawan']   = $this->md_karyawan->detail($id_kry);
        $where = array('id_kry' => $id_kry);

        $this->load->view('admin/detail_karyawan',$data);
    }

    public function print_karyawan()
    {
        $data['karyawan'] = $this->md_karyawan->print();

        $this->load->view('admin/print_karyawan', $data);
    }

    // ===================================CRUD KARYAWAN END======================================== //

    // ===================================CRUD KARYAWAN BARU START================================== //
    
    public function permohonan()
    {
        $data['karyawan'] = $this->md_permohonan->tampil();
        $data['judul']    = "Data Permohonan Karayawan";

        $this->load->view('admin/data_permohonan', $data);
    }

    public function add_permohonan()
    {
        $data['judul']   = 'Tambah Permohonan Karayawan';
        $data['idk']     = $this->md_master->get_idk_pemohon();
        $data['dep']     = $this->md_master->get_dept();
        $data['unt']     = $this->md_master->get_unit();
        $data['jbt']     = $this->md_master->get_jabatan();
        $data['jkl']     = $this->md_master->get_jk();
        $data['krj']     = $this->md_master->get_kerja();
        $data['pmh']     = $this->md_master->get_permohonan();
        $data['rek']     = $this->md_master->get_rekrutmen();
        $data['pdd']     = $this->md_master->get_pendidikan();
        $data['name']    = $this->session->userdata('name');
        $data['kode']    = $this->md_kode->kode_permohonan();

        $this->load->view('admin/add_permohonan',$data);
    }

    public function save_permohonan()
    {
        $this->form_validation->set_message('is_unique', '{field} sudah terpakai');
        $this->form_validation->set_rules('id_pmhn', 'Kode Karyawan', ['required', 'is_unique[tb_karyawan_baru.id_pmhn]']);

        $this->md_permohonan->val_permohonan();

        if($this->form_validation->run() === FALSE)
        {
            $this->add_permohonan();
        }
        else
        {
            $this->md_permohonan->simpan();
            $this->session->set_flashdata('input_sukses','Data Karyawan berhasil di input');
            redirect('admin/permohonan');
        }

    }

    public function delete_permohonan($id_pmhn)
    {
        $this->md_permohonan->hapus($id_pmhn);
        $this->session->set_flashdata('hapus_sukses','Data Karyawan berhasil di hapus');
        redirect('admin/permohonan');
    }

    public function edit_permohonan($id_pmhn)
    {
        $data['judul']      = 'Edit Permohonan Karayawan';
        $data['dep']        = $this->md_master->get_dept();
        $data['ag']         = $this->md_master->get_agama();
        $data['unt']        = $this->md_master->get_unit();
        $data['jbt']        = $this->md_master->get_jabatan();
        $data['jbt2']       = $this->md_master->get_jabatan();
        $data['jkl']        = $this->md_master->get_jk();
        $data['krj']        = $this->md_master->get_kerja();
        $data['pmh']        = $this->md_master->get_permohonan();
        $data['rek']        = $this->md_master->get_rekrutmen();
        $data['pdd']        = $this->md_master->get_pendidikan();
        $data['name']       = $this->session->userdata('name');
        $data['kry_']       = $this->md_permohonan->edit($id_pmhn);

        $this->load->view('admin/edit_permohonan', $data);
    }

    public function update_permohonan($id_pmhn)
    {
        $this->md_permohonan->val_permohonan();

        if($this->form_validation->run() === FALSE)
        {
            $this->edit_permohonan($id_pmhn);
        }
        else
        {
            $this->md_permohonan->update();
            $this->session->set_flashdata('update_sukses', 'Data karyawan berhasil diperbaharui');
            redirect('admin/permohonan');
        }
    }

    function detail_permohonan($id_pmhn)
    {
        $data['judul']      = 'Detail Permohonan Karayawan';
        $data['karyawan']   = $this->md_permohonan->detail($id_pmhn);
        $where = array('id_pmhn' => $id_pmhn);

        $this->load->view('admin/detail_permohonan',$data);
    }

    public function print_permohonan()
    {
        $data['karyawan'] = $this->md_permohonan->print();

        $this->load->view('admin/print_permohonan', $data);
        
    }

    // ===================================CRUD KARYAWAN BARU END================================== //

    // ===================================CRUD PERCOBAAN START=================================== //
    
     public function percobaan()
     {
         $data['karyawan'] = $this->md_percobaan->tampil();
         $data['judul']    = "Data Karyawan Percobaan";
 
         $this->load->view('admin/data_percobaan', $data);
     }
 
     function detail_percobaan($id_cb)
     {
         $data['judul']      = 'DETAIL DATA KARYAWAN';
         $data['karyawan']   = $this->md_percobaan->detail($id_cb);
         $where = array('id_cb' => $id_cb);
 
         $this->load->view('admin/detail_percobaan',$data);
     }
 
     public function add_percobaan()
     {
         $data['judul']   = 'Tambah Karyawan Percobaan';
         $data['idk']     = $this->md_master->get_idk();
         $data['dep']     = $this->md_master->get_dept();
         $data['jbt']     = $this->md_master->get_jabatan();
         $data['krj']     = $this->md_master->get_kerja();
         $data['name']    = $this->session->userdata('name');
         $data['kode']    = $this->md_kode->kode_percobaan();
 
         $this->load->view('admin/add_percobaan',$data);
     }
 
     public function save_percobaan()
     {
         $this->form_validation->set_message('is_unique', '{field} sudah terpakai');
         $this->form_validation->set_rules('id_cb', 'Kode Karyawan', ['required', 'is_unique[tb_percobaan.id_cb]']);
 
         $this->md_percobaan->val_percobaan();
 
         if($this->form_validation->run() === FALSE)
         {
             $this->add_percobaan();
         }
         else
         {
             $this->md_percobaan->simpan();
             $this->session->set_flashdata('input_sukses','Data Karyawan berhasil di input');
             redirect('admin/percobaan');
         }
     }
 
     public function delete_percobaan($id_cb)
     {
         $this->md_percobaan->hapus($id_cb);
         $this->session->set_flashdata('hapus_sukses','Data Karyawan berhasil di hapus');
         redirect('admin/percobaan');
     }
 
     public function edit_percobaan($id_cb)
     {
         $data['judul']     = 'Edit Karyawan Percobaan';
         $data['dep']       = $this->md_master->get_dept();
         $data['jbt']       = $this->md_master->get_jabatan();
         $data['krj']       = $this->md_master->get_kerja();
         $data['name']      = $this->session->userdata('name');;
         $data['karyawan']  = $this->md_percobaan->edit($id_cb);
 
         $this->load->view('admin/edit_percobaan', $data);
     }
 
    public function update_percobaan($id_cb)
    {
         $this->md_percobaan->val_percobaan();
 
         if($this->form_validation->run() === FALSE)
         {
             $this->edit_percobaan($id_cb);
         }
         else
         {
             $this->md_percobaan->update();
             $this->session->set_flashdata('update_sukses', 'Data karyawan berhasil diperbaharui');
             redirect('admin/percobaan');
         }
    }
    
    public function print_percobaan()
    {
        $data['karyawan'] = $this->md_percobaan->print();

        $this->load->view('admin/print_percobaan', $data);
        
    }
 
    // ===================================CRUD PERCOBAAN END=================================== //

    // ==================================CRUD PENILAIAN START================================= //
    
    function get_karyawan()
	{
		$id   = $this->input->post('id_kry');
		$data = $this->md_master->get_karyawan_bykode($id);
		echo json_encode($data);
	}
    
    public function penilaian()
    {
        $data['karyawan'] = $this->md_penilaian->tampil();
        $data['judul']    = "Data Penilaian Karyawan";

        $this->load->view('admin/data_penilaian', $data);
    }

    function detail_penilaian($id)
    {
        $data['judul']      = 'Detail Penilaian Karyawan';
        $data['karyawan']   = $this->md_penilaian->detail($id);
        $where = array('id_nl' => $id);

        $this->load->view('admin/detail_penilaian',$data);
    }

    public function add_penilaian()
    {
        $data['judul']   = 'Tambah Penilaian Karyawan';
        $data['idk']     = $this->md_master->get_idk();
        $data['idp']     = $this->md_master->get_idp();
        $data['kode']    = $this->md_kode->kode_penilaian();
        $data['name']    = $this->session->userdata('name');

        $this->load->view('admin/add_penilaian',$data);
    }

    public function save_penilaian()
    {
        $this->form_validation->set_message('is_unique', '{field} sudah terpakai');
        $this->form_validation->set_rules('id_nl', 'Kode Karyawan', ['required', 'is_unique[tb_penilaian.id_nl]']);

        $this->md_penilaian->val_penilaian();

        if($this->form_validation->run() === FALSE)
        {
            $this->add_penilaian();
        }
        else
        {
            $this->md_penilaian->simpan();
            $this->session->set_flashdata('input_sukses','Data Karyawan berhasil di input');
            redirect('admin/penilaian');
        }
    }

    public function delete_penilaian($id)
    {
        $this->md_penilaian->hapus($id);
        $this->session->set_flashdata('hapus_sukses','Data Karyawan berhasil di hapus');
        redirect('admin/penilaian');
    }

    public function edit_penilaian($id)
    {
        $data['judul']      = 'Edit Penilaian Karyawan';
        $data['dep']        = $this->md_master->get_dept();
        $data['jbt']        = $this->md_master->get_jabatan();
        $data['jbt2']       = $this->md_master->get_jabatan();
        $data['kode']       = $this->md_kode->kode_penilaian();
        $data['name']       = $this->session->userdata('name');
        $data['karyawan']   = $this->md_penilaian->edit($id);

        $this->load->view('admin/edit_penilaian', $data);
    }

    public function update_penilaian($id)
    {
        $this->md_penilaian->val_penilaian();

        if($this->form_validation->run() === FALSE)
        {
            $this->edit_penilaian($id);
        }
        else
        {
            $this->md_penilaian->update();
            $this->session->set_flashdata('update_sukses', 'Data karyawan berhasil diperbaharui');
            redirect('admin/penilaian');
        }
    }

    public function print_penilaian()
    {
        $data['karyawan'] = $this->md_penilaian->print();

        $this->load->view('admin/print_penilaian', $data);
        
    }

    // ===================================CRUD PENILAI END================================== //

    // ==================================CRUD TRAINING START================================= //
    
     public function training()
     {
         $data['karyawan'] = $this->md_training->tampil();
         $data['judul']    = "Data Training Karyawan";
 
         $this->load->view('admin/data_training', $data);
     }
 
     function detail_training($id)
     {
        $this->load->helper('nominal');
         $data['judul']      = 'Detail Training Karyawan';
         $data['karyawan']   = $this->md_training->detail($id);
         $where = array('id_tr' => $id);
 
         $this->load->view('admin/detail_training',$data);
     }
 
     public function add_training()
     {
         $data['judul']   = 'Tambah Training Karyawan';
         $data['idk']     = $this->md_master->get_idk();
         $data['kode']    = $this->md_kode->kode_training();
         $data['name']    = $this->session->userdata('name');
 
         $this->load->view('admin/add_training',$data);
     }
 
     public function save_training()
     {
         $this->form_validation->set_message('is_unique', '{field} sudah terpakai');
         $this->form_validation->set_rules('id_tr', 'Kode Karyawan', ['required', 'is_unique[tb_training.id_tr]']);
 
         $this->md_training->val_training();
 
         if($this->form_validation->run() === FALSE)
         {
             $this->add_training();
         }
         else
         {
             $this->md_training->simpan();
             $this->session->set_flashdata('input_sukses','Data Karyawan berhasil di input');
             redirect('admin/training');
         }
     }
 
     public function delete_training($id)
     {
         $this->md_training->hapus($id);
         $this->session->set_flashdata('hapus_sukses','Data Karyawan berhasil di hapus');
         redirect('admin/training');
     }
 
     public function edit_training($id)
     {
         $data['judul']     = 'Edit Training Karyawan';
         $data['dep']       = $this->md_master->get_dept();
         $data['jbt']       = $this->md_master->get_jabatan();
         $data['kode']      = $this->md_kode->kode_training();
         $data['name']      = $this->session->userdata('name');
         $data['kry']       = $this->md_training->edit($id);
 
         $this->load->view('admin/edit_training', $data);
     }
 
     public function update_training($id)
     {
         $this->md_training->val_training();
 
         if($this->form_validation->run() === FALSE)
         {
             $this->edit_training($id);
         }
         else
         {
             $this->md_training->update();
             $this->session->set_flashdata('update_sukses', 'Data karyawan berhasil diperbaharui');
             redirect('admin/training');
         }
     }

    public function print_training()
    {
        $data['karyawan'] = $this->md_training->print();

        $this->load->view('admin/print_training', $data);
        
    }
 
     // ===================================CRUD TRAINING END================================== //

     // ==================================CRUD RESIGN START================================= //
    
     public function resign()
     {
         $data['karyawan'] = $this->md_resign->tampil();
         $data['judul']    = "Data Karyawan Resign";
 
         $this->load->view('admin/data_resign', $data);
     }
 
     function detail_resign($id)
     {
         $data['judul']      = 'Detail Karyawan Resign';
         $data['karyawan']   = $this->md_resign->detail($id);
         $where = array('id_rs' => $id);
 
         $this->load->view('admin/detail_resign',$data);
     }
 
     public function add_resign()
     {
         $data['judul']   = 'Tambah Karyawan Resign';
         $data['dep']     = $this->md_master->get_dept();
         $data['jbt']     = $this->md_master->get_jabatan();
         $data['pgk']     = $this->md_master->get_pangkat();
         $data['kode']    = $this->md_kode->kode_resign();
         $data['name']    = $this->session->userdata('name');
 
         $this->load->view('admin/add_resign',$data);
     }
 
     public function save_resign()
     {
         $this->form_validation->set_message('is_unique', '{field} sudah terpakai');
         $this->form_validation->set_rules('id_rs', 'Kode Karyawan', ['required', 'is_unique[tb_resign.id_rs]']);
 
         $this->md_resign->val_resign();
 
         if($this->form_validation->run() === FALSE)
         {
             $this->add_resign();
         }
         else
         {
             $this->md_resign->simpan();
             $this->session->set_flashdata('input_sukses','Data Karyawan berhasil di input');
             redirect('admin/resign');
         }
     }
 
     public function delete_resign($id)
     {
         $this->md_resign->hapus($id);
         $this->session->set_flashdata('hapus_sukses','Data Karyawan berhasil di hapus');
         redirect('admin/resign');
     }
 
     public function edit_resign($id)
     {
         $data['judul']     = 'Edit Karyawan Resign';
         $data['dep']       = $this->md_master->get_dept();
         $data['jbt']       = $this->md_master->get_jabatan();
         $data['pgk']       = $this->md_master->get_pangkat();
         $data['kode']      = $this->md_kode->kode_resign();
         $data['name']      = $this->session->userdata('name');
         $data['kry']       = $this->md_resign->edit($id);
 
         $this->load->view('admin/edit_resign', $data);
     }
 
     public function update_resign($id)
     {
         $this->md_resign->val_resign();
 
         if($this->form_validation->run() === FALSE)
         {
             $this->edit_resign($id);
         }
         else
         {
             $this->md_resign->update();
             $this->session->set_flashdata('update_sukses', 'Data karyawan berhasil diperbaharui');
             redirect('admin/resign');
         }
     }

    public function print_resign()
    {
        $data['karyawan'] = $this->md_resign->print();

        $this->load->view('admin/print_resign', $data);
        
    }
 
     // ===================================CRUD RESIGN END================================== //
     // ===================================CRUD MAN POWER PLANNING START======================================== //

    public function mpp()
    {
        $data['kry']   = $this->md_mpp->tampil();
        $data['judul'] = "Data Man Power Planning";

        $msg    = $this->uri->segment(3);
        $alert  = '';
        if($msg == 'success'){
            $alert  = 'Success!!';
        }
        $data['_alert'] = $alert;

        $this->load->view('admin/data_mpp', $data);
    }

    public function add_mpp()
    {
        $data['judul']   = "Tambah Data Man Power Planning";
        $data['idk']     = $this->md_master->get_idk_pemohon();
        $data['dep']     = $this->md_master->get_dept();
        $data['area']    = $this->md_master->get_unit();
        $data['jbt']     = $this->md_master->get_jabatan();
        $data['jbt2']    = $this->md_master->get_jabatan();
        $data['rek']     = $this->md_master->get_rekrutmen();
        $data['name']    = $this->session->userdata('name');
        $data['kode']    = $this->md_kode->kode_mpp();

        $this->load->view('admin/add_mpp',$data);
    }

    public function save_mpp()
    {
        $this->form_validation->set_message('is_unique', '{field} sudah terpakai');
        $this->form_validation->set_rules('id_pp', 'Kode MPP', ['required', 'is_unique[tb_mpp.id_pp]']);

        $this->md_mpp->val_mpp();

        if($this->form_validation->run() === FALSE)
        {
            $this->add_mpp();
        }
        else
        {
            $this->md_mpp->simpan();
            $this->session->set_flashdata('input_sukses','Data MPP berhasil di simpan');
            redirect('admin/mpp');
        }
    }

    public function delete_mpp($id_pp)
    {
        $this->md_mpp->hapus($id_pp);
        $this->session->set_flashdata('hapus_sukses','Data MPP berhasil di hapus');
        redirect('admin/mpp');
    }

    public function edit_mpp($id_pp)
    {
        $data['judul']   = 'Edit Data Man Power Planning';
        $data['idk']     = $this->md_master->get_idk_pemohon();
        $data['dep']     = $this->md_master->get_dept();
        $data['area']    = $this->md_master->get_unit();
        $data['jbt']     = $this->md_master->get_jabatan();
        $data['jbt2']    = $this->md_master->get_jabatan();
        $data['rek']     = $this->md_master->get_rekrutmen();
        $data['pie_data']= $this->md_master->get_pie();
        $data['name']    = $this->session->userdata('name');
        $data['kode']    = $this->md_kode->kode_mpp();
        $data['kry']     = $this->md_mpp->edit($id_pp);

        $this->load->view('admin/edit_mpp', $data);
    }

    public function update_mpp($id_pp)
    {
        $this->md_mpp->val_mpp();

        if($this->form_validation->run() === FALSE)
        {
            $this->edit_mpp($id_pp);
        }
        else
        {
            $this->md_mpp->update();
            $this->session->set_flashdata('update_sukses', 'Data MPP berhasil diperbaharui');
            redirect('admin/mpp');
        }
    }

    function detail_mpp($id_pp)
    {
        $data['judul']  = 'Detail Data Man Power Planning';
        $data['kry']    = $this->md_mpp->detail($id_pp);
        $where = array('id_pp' => $id_pp);

        $this->load->view('admin/detail_mpp',$data);
    }

    public function print_mpp()
    {
        $data['kry'] = $this->md_mpp->print();

        $this->load->view('admin/print_mpp', $data);
    }

    // ===================================CRUD MAN POWER PLANNING END======================================== //


	public function struktur_pusat()
	{
        $data['judul']     = 'Struktur Organisasi Pusat';
		$this->load->view('admin/struktur_pusat',$data);
	}

	public function struktur_cabang()
	{
        $data['judul']     = 'Struktur Organisasi Cabang';
		$this->load->view('admin/struktur_cabang',$data);
    }

    public function import(){
       
        include APPPATH.'third_party/PHPExcel/PHPExcel.php';
        
        $excelreader = new PHPExcel_Reader_Excel2007();
        $loadexcel = $excelreader->load('excel/'.$this->filename.'.xlsx');
        $sheet = $loadexcel->getActiveSheet()->toArray(null,true,true,true);
       
        $data = array();
        $numrow = 1;
        foreach($sheet as $row){
          if($numrow > 1){
            array_push($data, array(
                        'id'                => $row['A'],
                        'nama'              => $row['B'],
                        'nik'               => $row['C'],
                        'jabatan'           => $row['D'],
                        'pangkat'           => $row['E'],
                        'divisi'            => $row['F'],
                        'departemen'        => $row['G'],
                        'unit'              => $row['H'],
                        'nama_panggilan'    => $row['I'],
                        'identitas'         => $row['J'],
                        'jk'                => $row['K'],
                        'tempat_lahir'      => $row['L'],
                        'tgl_lahir'         => $row['M'],
                        'negara'            => $row['N'],
                        'agama'             => $row['O'],
                        'npwp'              => $row['P'],
                        'alamat'            => $row['Q'],
                        'tlp_rumah'         => $row['R'],
                        'no_hp'             => $row['S'],
                        'tgl_masuk'         => $row['T'],
                        'status_kerja'      => $row['U'],
                        'status_nikah'      => $row['V'],
                        'email'             => $row['W']
            ));
          }
          
          $numrow++; 
        }
        
        $this->md_excel->insert_multiple($data);
        redirect("admin/karyawan"); 
    }

    public function rupiah($angka){
	
        $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
        return $hasil_rupiah;
     
    }

    public function grafik_month() {  
   
        $data['judul']     = 'Grafik Permintaan per Month';
        foreach($this->md_master->statistik_pengunjung()->result_array() as $gf)
        {
         $data['grafik'][]=(float)$gf['Januari'];
         $data['grafik'][]=(float)$gf['Februari'];
         $data['grafik'][]=(float)$gf['Maret'];
         $data['grafik'][]=(float)$gf['April'];
         $data['grafik'][]=(float)$gf['Mei'];
         $data['grafik'][]=(float)$gf['Juni'];
         $data['grafik'][]=(float)$gf['Juli'];
         $data['grafik'][]=(float)$gf['Agustus'];
         $data['grafik'][]=(float)$gf['September'];
         $data['grafik'][]=(float)$gf['Oktober'];
         $data['grafik'][]=(float)$gf['November'];
         $data['grafik'][]=(float)$gf['Desember'];
        }
         
        $this->load->view('admin/grafik_month', $data); 
    }

    public function grafik_karyawan()
	{
        $data['judul']     = 'Pie Chart Karyawan';
		$data['graph']     = $this->md_master->get_pie();
		$this->load->view('admin/grafik_karyawan', $data);
    }
    
    public function grafik_dep()
	{
        $data['judul']     = 'Grafik Permintaan per Departemen';
		$data['graph']     = $this->md_master->get_column();
		$this->load->view('admin/grafik_dep', $data);
	}
   
}

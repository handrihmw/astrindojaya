<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Author : Ismo Broto : git @ismo1106
 */
class Import extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('PHPExcel');
    }
    function index() {
        $msg    = $this->uri->segment(3);
        $alert  = '';
        if($msg == 'success'){
            $alert  = 'Success!!';
        }
        $data['_alert'] = $alert;
        $this->load->view('admin/karyawan',$data);
    }
    public function upload(){
        $fileName = $this->input->post('file', TRUE);
      
        $config['upload_path'] = './uploads/'; 
        $config['file_name'] = $fileName;
        $config['allowed_types'] = 'xls|xlsx|csv|ods|ots';
        $config['max_size'] = 10000;
      
        $this->load->library('upload', $config);
        $this->upload->initialize($config); 
        
        if (!$this->upload->do_upload('file')) {
         $error = array('error' => $this->upload->display_errors());
         $this->session->set_flashdata('msg','Ada kesalah dalam upload'); 
         redirect('admin/karyawan'); 
        } else {
         $media = $this->upload->data();
         $inputFileName = 'uploads/'.$media['file_name'];
         
         try {
          $inputFileType = IOFactory::identify($inputFileName);
          $objReader = IOFactory::createReader($inputFileType);
          $objPHPExcel = $objReader->load($inputFileName);
         } catch(Exception $e) {
          die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
         }
      
         $sheet = $objPHPExcel->getSheet(0);
         $highestRow = $sheet->getHighestRow();
         $highestColumn = $sheet->getHighestColumn();
      
         for ($row = 2; $row <= $highestRow; $row++){  
           $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
             NULL,
             TRUE,
             FALSE);
           $data = array(
            "nama"              => $rowData[0][0],
            "nik"               => $rowData[0][1],
            "jabatan"           => $rowData[0][2],
            "pangkat"           => $rowData[0][3],
            "divisi"            => $rowData[0][4],
            "departemen"        => $rowData[0][5],
            "unit"              => $rowData[0][6],
            "nama_panggilan"    => $rowData[0][7],
            "identitas"         => $rowData[0][8],
            "jk"                => $rowData[0][9],
            "tempat_lahir"      => $rowData[0][10],
            "tgl_lahir"         => $rowData[0][11],
            "negara"            => $rowData[0][12],
            "agama"             => $rowData[0][13],
            "npwp"              => $rowData[0][14],
            "alamat"            => $rowData[0][15],
            "tlp_rumah"         => $rowData[0][16],
            "no_hp"             => $rowData[0][17],
            "tgl_masuk"         => $rowData[0][18],
            "status_kerja"      => $rowData[0][19],
            "status_nikah"      => $rowData[0][20],
            "email"             => $rowData[0][21]
          );
          $this->db->insert("tb_karyawan",$data);
         } 
         $this->session->set_flashdata('msg','Berhasil upload ...!!'); 
         redirect('admin/karyawan');
        }  
       } 
}
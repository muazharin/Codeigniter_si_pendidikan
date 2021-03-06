<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tk extends CI_Controller {

	public function __construct(){

        parent::__construct();
        if($this->session->userdata('logged_in_admin') !== TRUE){
            redirect('login');
        }
        
        $this->load->model('M_tk');
        $this->load->model('M_paud');
    }

    public function index(){
        $data['sidebar']='#menu2';
        $data['sidebar1']='#menu2-3';
        $data['sort'] = '2019';
        $data['tingkatan'] = ['tk','sd','sma'];
        $data['tahun'] = $this->M_paud->getAllTahun();
        $data['kecamatan'] = $this->M_paud->getAllKecamatan();
        
        // jumlah
        $data['jml_siswa'] = $this->M_tk->getTk();
        $data['jml_bg_baik'] = $this->M_tk->getBgBaik();
        $data['jml_bg_tdk_baik'] = $this->M_tk->getBgTdkBaik();
        $data['jml_pgl_negeri'] = $this->M_tk->getPglNegeri();
        $data['jml_pgl_swasta'] = $this->M_tk->getPglSwasta();
        $data['jml_rg_kelas'] = $this->M_tk->getRgKelas();
        $data['jml_pd_bersertifikat'] = $this->M_tk->getPdBersertifikat();
        $data['jml_pd_tdk_bersertifikat'] = $this->M_tk->getPdTdkBersertifikat();
        $data['jml_rasio'] = $this->M_tk->getJmlRasio();
        
        // load data
        $data['peserta_siswa'] = $this->M_tk->getPesertaSiswa();
        $data['bg_baik'] = $this->M_tk->getDataBgBaik();
        $data['bg_tdk_baik'] = $this->M_tk->getDataBgTdkBaik();
        $data['pgl_negeri'] = $this->M_tk->getDataPglNegeri();
        $data['pgl_swasta'] = $this->M_tk->getDataPglSwasta();
        $data['rg_kelas'] = $this->M_tk->getDataRgKelas();
        $data['pd_bersertifikat'] = $this->M_tk->getDataPdBersertifikat();
        $data['pd_tdk_bersertifikat'] = $this->M_tk->getDataPdTdkBersertifikat();
        $data['rasio'] = $this->M_tk->getDataRasio();

        if($this->input->post('keyword')){
            $data['sort'] = $this->input->post('keyword');
             // jumlah
            $data['jml_siswa'] = $this->M_tk->getTkCari();
            $data['jml_bg_baik'] = $this->M_tk->getBgBaikCari();
            $data['jml_bg_tdk_baik'] = $this->M_tk->getBgTdkBaikCari();
            $data['jml_pgl_negeri'] = $this->M_tk->getPglNegeriCari();
            $data['jml_pgl_swasta'] = $this->M_tk->getPglSwastaCari();
            $data['jml_rg_kelas'] = $this->M_tk->getRgKelasCari();
            $data['jml_pd_bersertifikat'] = $this->M_tk->getPdBersertifikatCari();
            $data['jml_pd_tdk_bersertifikat'] = $this->M_tk->getPdTdkBersertifikatCari();
            $data['jml_rasio'] = $this->M_tk->getJmlRasioCari();
            
            // load data
            $data['peserta_siswa'] = $this->M_tk->getPesertaSiswaCari();
            $data['bg_baik'] = $this->M_tk->getDataBgBaikCari();
            $data['bg_tdk_baik'] = $this->M_tk->getDataBgTdkBaikCari();
            $data['pgl_negeri'] = $this->M_tk->getDataPglNegeriCari();
            $data['pgl_swasta'] = $this->M_tk->getDataPglSwastaCari();
            $data['rg_kelas'] = $this->M_tk->getDataRgKelasCari();
            $data['pd_bersertifikat'] = $this->M_tk->getDataPdBersertifikatCari();
            $data['pd_tdk_bersertifikat'] = $this->M_tk->getDataPdTdkBersertifikatCari();
            $data['rasio'] = $this->M_tk->getDataRasioCari();
        }

        $this->load->view('template/header',$data);
        $this->load->view('pages/tk',$data); 
        $this->load->view('template/footer');
    }

    public function edit_peserta_siswa(){
        $this->form_validation->set_rules('tahun', 'Tahun', 'required|xss_clean|trim');
        $this->form_validation->set_rules('id_tb_jml_siswa', 'Id', 'required|xss_clean|trim');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|xss_clean|trim');
        $this->form_validation->set_rules('kecamatan', 'Kecamatan', 'required|xss_clean|trim');
        if($this->form_validation->run()==FALSE){
            $this->index();
        }else{
            $this->M_tk->editDataPesertaSiswa();
            $this->session->set_flashdata('pbu', 'Diupdate');
			redirect('tk');
        }
    }
    
    public function edit_bg_baik(){
        $this->form_validation->set_rules('tahun', 'Tahun', 'required|xss_clean|trim');
        $this->form_validation->set_rules('id_tb_bangunan_baik', 'Id', 'required|xss_clean|trim');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|xss_clean|trim');
        $this->form_validation->set_rules('kecamatan', 'Kecamatan', 'required|xss_clean|trim');
        if($this->form_validation->run()==FALSE){
            $this->index();
        }else{
            $this->M_tk->editDataBgBaik();
            $this->session->set_flashdata('pbu', 'Diupdate');
			redirect('tk');
        }
    }
    
    public function edit_bg_tdk_baik(){
        $this->form_validation->set_rules('tahun', 'Tahun', 'required|xss_clean|trim');
        $this->form_validation->set_rules('id_tb_bangunan_tdk_baik', 'Id', 'required|xss_clean|trim');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|xss_clean|trim');
        $this->form_validation->set_rules('kecamatan', 'Kecamatan', 'required|xss_clean|trim');
        if($this->form_validation->run()==FALSE){
            $this->index();
        }else{
            $this->M_tk->editDataBgTdkBaik();
            $this->session->set_flashdata('pbu', 'Diupdate');
			redirect('tk');
        }
    }
    
    public function edit_pgl_negeri(){
        $this->form_validation->set_rules('tahun', 'Tahun', 'required|xss_clean|trim');
        $this->form_validation->set_rules('id_tb_pengelola_negeri', 'Id', 'required|xss_clean|trim');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|xss_clean|trim');
        if($this->form_validation->run()==FALSE){
            $this->index();
        }else{
            $this->M_tk->editDataPglNegeri();
            $this->session->set_flashdata('pbu', 'Diupdate');
			redirect('tk');
        }
    }
    
    public function edit_pgl_swasta(){
        $this->form_validation->set_rules('tahun', 'Tahun', 'required|xss_clean|trim');
        $this->form_validation->set_rules('id_tb_pengelola_swasta', 'Id', 'required|xss_clean|trim');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|xss_clean|trim');
        if($this->form_validation->run()==FALSE){
            $this->index();
        }else{
            $this->M_tk->editDataPglSwasta();
            $this->session->set_flashdata('pbu', 'Diupdate');
			redirect('tk');
        }
    }
    
    public function edit_rg_kelas(){
        $this->form_validation->set_rules('tahun', 'Tahun', 'required|xss_clean|trim');
        $this->form_validation->set_rules('id_tb_ruang_kelas', 'Id', 'required|xss_clean|trim');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|xss_clean|trim');
        if($this->form_validation->run()==FALSE){
            $this->index();
        }else{
            $this->M_tk->editDataRgKelas();
            $this->session->set_flashdata('pbu', 'Diupdate');
			redirect('tk');
        }
    }
    
    public function edit_pd_bersertifikat(){
        $this->form_validation->set_rules('tahun', 'Tahun', 'required|xss_clean|trim');
        $this->form_validation->set_rules('id_tb_pendidik_bersertifikat', 'Id', 'required|xss_clean|trim');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|xss_clean|trim');
        if($this->form_validation->run()==FALSE){
            $this->index();
        }else{
            $this->M_tk->editDataPdBersertifikat();
            $this->session->set_flashdata('pbu', 'Diupdate');
			redirect('tk');
        }
    }
    
    public function edit_pd_tdk_bersertifikat(){
        $this->form_validation->set_rules('tahun', 'Tahun', 'required|xss_clean|trim');
        $this->form_validation->set_rules('id_tb_pendidik_tdk_bersertifikat', 'Id', 'required|xss_clean|trim');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required|xss_clean|trim');
        if($this->form_validation->run()==FALSE){
            $this->index();
        }else{
            $this->M_tk->editDataPdTdkBersertifikat();
            $this->session->set_flashdata('pbu', 'Diupdate');
			redirect('tk');
        }
    }
    
    public function edit_rasio(){
        $this->form_validation->set_rules('tahun', 'Tahun', 'required|xss_clean|trim');
        $this->form_validation->set_rules('id_tb_rasio', 'Id', 'required|xss_clean|trim');
        $this->form_validation->set_rules('nilai', 'Jumlah', 'required|xss_clean|trim');
        if($this->form_validation->run()==FALSE){
            $this->index();
        }else{
            $this->M_tk->editDataRasio();
            $this->session->set_flashdata('pbu', 'Diupdate');
			redirect('tk');
        }
    }

    public function tambahDataTk(){
        $this->form_validation->set_rules('nama_kecamatan', 'Kecamatan', 'required|trim|xss_clean');
        $this->form_validation->set_rules('jumlah_siswa', 'Jumlah Siswa', 'required|trim|xss_clean|numeric');
        $this->form_validation->set_rules('jumlah_bangunan_baik', 'Jumlah Bangunan Baik', 'required|trim|xss_clean|numeric');
        $this->form_validation->set_rules('jumlah_bangunan_tdk_baik', 'Jumlah Bangunan Tidak Baik', 'required|trim|xss_clean|numeric');
        $this->form_validation->set_rules('tahun', 'Tahun', 'required|trim|xss_clean');
        if($this->form_validation->run()==FALSE){
            $this->index();
        }else{
            $nama_kecamatan = $this->input->post('nama_kecamatan', true);
            $tingkatan = 'tk';
            $jumlah = $this->input->post('jumlah', true);
            $tahun = $this->input->post('tahun', true);

            $this->db->where('kecamatan', $nama_kecamatan);
            $this->db->where('tingkatan', $tingkatan);
            $this->db->where('tahun', $tahun);
            $hasil=$this->db->get('tb_jml_siswa');
            $this->db->where('kecamatan', $nama_kecamatan);
            $this->db->where('tingkatan', $tingkatan);
            $this->db->where('tahun', $tahun);
            $hasil1=$this->db->get('tb_bangunan_baik');
            $this->db->where('kecamatan', $nama_kecamatan);
            $this->db->where('tingkatan', $tingkatan);
            $this->db->where('tahun', $tahun);
            $hasil2=$this->db->get('tb_bangunan_tdk_baik');
            $this->db->where('tingkatan', $tingkatan);
            $this->db->where('tahun', $tahun);
            
            if($hasil->num_rows()!=0){
                $this->session->set_flashdata('pbu1', 'Data siswa pada tahun tersebut sudah ada');
                redirect('tk');
            }else if($hasil1->num_rows()!=0){
                $this->session->set_flashdata('pbu1', 'Data bangunan baik pada tahun tersebut sudah ada');
                redirect('tk');
            }else if($hasil2->num_rows()!=0){
                $this->session->set_flashdata('pbu1', 'Data bangunan tidak baik pada tahun tersebut sudah ada');
                redirect('tk');
            }else{
                $this->M_tk->tambahDataTkBaru();
                $this->session->set_flashdata('pbu', 'Ditambahkan');
                redirect('tk');
                // echo 'ok';
            }
        }
    }

    public function tambahDataTkUmum(){
        $this->form_validation->set_rules('jumlah_pengelola_sekolah_negeri', 'Jumlah Pengelola Sekolah Negeri', 'required|trim|xss_clean|numeric');
        $this->form_validation->set_rules('jumlah_pengelola_sekolah_swasta', 'Jumlah Pengelola Sekolah Swasta', 'required|trim|xss_clean|numeric');
        $this->form_validation->set_rules('jumlah_ruang_kelas', 'Jumlah Ruang Kelas', 'required|trim|xss_clean|numeric');
        $this->form_validation->set_rules('jumlah_pendidik_bersertifikat', 'Jumlah Pendidik Bersertifikat', 'required|trim|xss_clean|numeric');
        $this->form_validation->set_rules('jumlah_pendidik_tdk_bersertifikat', 'Jumlah Pendidik Tidak Bersertifikat', 'required|trim|xss_clean|numeric');
        $this->form_validation->set_rules('rasio', 'Rasio', 'required|trim|xss_clean');
        $this->form_validation->set_rules('tahun1', 'Tahun', 'required|trim|xss_clean');
        if($this->form_validation->run()==FALSE){
            $this->index();
        }else{
            $nama_kecamatan = $this->input->post('nama_kecamatan', true);
            $tingkatan = 'tk';
            $jumlah = $this->input->post('jumlah', true);
            $tahun = $this->input->post('tahun1', true);

            $this->db->where('tingkatan', $tingkatan);
            $this->db->where('tahun', $tahun);
            $hasil3=$this->db->get('tb_pengelola_negeri');
            $this->db->where('tingkatan', $tingkatan);
            $this->db->where('tahun', $tahun);
            $hasil4=$this->db->get('tb_pengelola_swasta');
            $this->db->where('tingkatan', $tingkatan);
            $this->db->where('tahun', $tahun);
            $hasil5=$this->db->get('tb_ruang_kelas');
            $this->db->where('tingkatan', $tingkatan);
            $this->db->where('tahun', $tahun);
            $hasil6=$this->db->get('tb_pendidik_bersertifikat');
            $this->db->where('tingkatan', $tingkatan);
            $this->db->where('tahun', $tahun);
            $hasil7=$this->db->get('tb_pendidik_tdk_bersertifikat');
            $this->db->where('tingkatan', $tingkatan);
            $this->db->where('tahun', $tahun);
            $hasil8=$this->db->get('tb_rasio');
            
            
            if($hasil3->num_rows()!=0){
                $this->session->set_flashdata('pbu1', 'Data pengelola sekolah negeri pada tahun tersebut sudah ada');
                redirect('tk');
            }else if($hasil4->num_rows()!=0){
                $this->session->set_flashdata('pbu1', 'Data pengelola sekolah swasta pada tahun tersebut sudah ada');
                redirect('tk');
            }else if($hasil5->num_rows()!=0){
                $this->session->set_flashdata('pbu1', 'Data ruang kelas pada tahun tersebut sudah ada');
                redirect('tk');
            }else if($hasil6->num_rows()!=0){
                $this->session->set_flashdata('pbu1', 'Data tenaga pendidik bersertifikat pada tahun tersebut sudah ada');
                redirect('tk');
            }else if($hasil7->num_rows()!=0){
                $this->session->set_flashdata('pbu1', 'Data tenaga pendidik tidak bersertifikat pada tahun tersebut sudah ada');
                redirect('tk');
            }else if($hasil8->num_rows()!=0){
                $this->session->set_flashdata('pbu1', 'Data rasio pada tahun tersebut sudah ada');
                redirect('tk');
            }else{
                $this->M_tk->tambahDataTkUmumBaru();
                $this->session->set_flashdata('pbu', 'Ditambahkan');
                redirect('tk');
            }
        }
    }

    public function hapus_siswa(){
        $this->M_tk->hapusDataSiswa();
		$this->session->set_flashdata('pbu', 'Dihapus');
        redirect('tk');
        // echo $this->uri->segment(4);
    }
    
    public function hapus_bg_baik(){
        $this->M_tk->hapusBgBaik();
		$this->session->set_flashdata('pbu', 'Dihapus');
        redirect('tk');
        // echo $this->uri->segment(4);
    }
    
    public function hapus_bg_tdk_baik(){
        $this->M_tk->hapusBgTdkBaik();
		$this->session->set_flashdata('pbu', 'Dihapus');
        redirect('tk');
        // echo $this->uri->segment(4);
    }
    
    public function hapus_pgl_negeri(){
        $this->M_tk->hapusPglNegeri();
		$this->session->set_flashdata('pbu', 'Dihapus');
        redirect('tk');
        // echo $this->uri->segment(4);
    }
    
    public function hapus_pgl_swasta(){
        $this->M_tk->hapusPglSwasta();
		$this->session->set_flashdata('pbu', 'Dihapus');
        redirect('tk');
        // echo $this->uri->segment(4);
    }
    
    public function hapus_rg_kelas(){
        $this->M_tk->hapusRgKelas();
		$this->session->set_flashdata('pbu', 'Dihapus');
        redirect('tk');
        // echo $this->uri->segment(4);
    }
    
    public function hapus_pd_bersertifikat(){
        $this->M_tk->hapusPdBersertifikat();
		$this->session->set_flashdata('pbu', 'Dihapus');
        redirect('tk');
        // echo $this->uri->segment(4);
    }
    
    public function hapus_pd_tdk_bersertifikat(){
        $this->M_tk->hapusPdTdkBersertifikat();
		$this->session->set_flashdata('pbu', 'Dihapus');
        redirect('tk');
        // echo $this->uri->segment(4);
    }
    
    public function hapus_rasio(){
        $this->M_tk->hapusRasio();
		$this->session->set_flashdata('pbu', 'Dihapus');
        redirect('tk');
        // echo $this->uri->segment(4);
    }
}
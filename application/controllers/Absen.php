<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Absen extends CI_Controller {

	public function __construct(){

        parent::__construct();
        if($this->session->userdata('logged_in_admin') !== TRUE){
            redirect('login');
        }
        $this->load->library('upload');
        $this->load->model('M_absen');
    }

    public function index(){
        $data['sidebar']='#menu6';
        $data['sidebar1']='';
        $data['kecamatan']=$this->M_absen->getAllKecamatan();
        $data['dataabsen'] = $this->M_absen->getDataAbsen();
        $data['bulan'] = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        $data['tahun']=$this->M_absen->getAllTahun();

        $this->load->view('template/header', $data);
        $this->load->view('absen', $data);
        $this->load->view('template/footer');
    }

    public function insert_absen(){
        
        // get foto
        $config['upload_path'] = './assets/images/absen';
        $config['allowed_types'] = 'jpg|png|jpeg|gif';
        $config['max_size'] = '2048';  //2MB max
        // $config['max_width'] = '4480'; // pixel
        // $config['max_height'] = '4480'; // pixel
        $config['file_name'] = $_FILES['fotopost']['name'];
        $this->upload->initialize($config);
            if (!empty($_FILES['fotopost']['name'])) {
                if ( $this->upload->do_upload('fotopost') ) {
                    $foto = $this->upload->data();
                    $data = [
                        'kecamatan' => $this->input->post('kecamatan',true),
                        'bulan' => $this->input->post('bulan',true),
                        'tahun' => $this->input->post('tahun',true),
                        'gambar' => $foto['file_name'],
                        
                    ];
                    $this->M_absen->insert($data);
                    $this->session->set_flashdata('absen', 'Ditambahkan');
                    redirect('absen');
                }else {
                    die("gagal upload");
                }
            }else {
                echo "tidak masuk";
            }
    }

    public function updatedata()
    {
        $id   = $this->input->post('id_absen');
        $kecamatan = $this->input->post('kecamatan1');
        $bulan = $this->input->post('bulan1');
        $tahun = $this->input->post('tahun1');
        $path = './assets/picture/';
        $kondisi = array('id_absen' => $id );
        // get foto
        $config['upload_path'] = './assets/images/absen';
        $config['allowed_types'] = 'jpg|png|jpeg|gif';
        $config['max_size'] = '2048';  //2MB max
        $config['file_name'] = $_FILES['fotopost1']['name'];
        $this->upload->initialize($config);
        if (!empty($_FILES['fotopost1']['name'])) {
            if ( $this->upload->do_upload('fotopost1') ) {
                $foto = $this->upload->data();
                $data = [
                    'kecamatan' => $this->input->post('kecamatan1',true),
                    'bulan' => $this->input->post('bulan1',true),
                    'tahun' => $this->input->post('tahun1',true),
                    'gambar' => $foto['file_name'],
                ];
                // hapus foto pada direktori
                @unlink($path.$this->input->post('filelama'));
                $this->M_absen->update($data,$kondisi);
                $this->session->set_flashdata('absen', 'Diupdate');
                redirect('absen');
            }else {
                die("gagal update");
            }
        }else {
            $data = [
                'kecamatan' => $this->input->post('kecamatan1',true),
                'bulan' => $this->input->post('bulan1',true),
                'tahun' => $this->input->post('tahun1',true)
            ];
            $this->M_absen->update($data,$kondisi);
            $this->session->set_flashdata('absen', 'Diupdate');
            redirect('absen');
        }
    }

    public function hapus($id,$foto){
        $path = './assets/images/absen';
        @unlink($path.$foto);
        $where = array('id_absen' => $id );
        $this->M_absen->delete($where);
        $this->session->set_flashdata('absen', 'Dihapus');
        return redirect('absen');
    }

    // public function getSekolahKecamatan(){
    //     $nama_kecamatan = $this->input->post('kecamatan');
    //     // $nama_kecamatan = $this->uri->segment(3);
    //     $data = $this->M_absen->getSubSekolahKecamatan($nama_kecamatan);
    //     echo json_encode($data);
    // }
}
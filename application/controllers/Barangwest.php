<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barangwest extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_login();

        $this->load->model('Admin_model', 'admin');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['title'] = "Barang West";
        $data['barangwest'] = $this->admin->getBarangwest();
        $this->template->load('templates/dashboard', 'barang_west/data', $data);
    }    

    private function _validasi2()
    {
        $this->form_validation->set_rules('tanggal_west', 'Tanggal West', 'required|trim');
        $this->form_validation->set_rules('barang_id', 'Barang', 'required');
        $this->form_validation->set_rules('harga', 'Harga', 'required|trim|numeric');
        $this->form_validation->set_rules('jumlah_west', 'Jumlah West', 'required|trim|numeric');

        // $dat = $this->admin->get('barang', ['satuan_id' => 3]);
        // $id = json_decode(json_encode($dat['id_barang']));
        // $stok = $this->admin->get('barang', ['id_barang' => $id])['stok'];
        // $stok_valid = $stok + 1;

        // $this->form_validation->set_rules(
        //     'jumlah_pcs',
        //     'Jumlah Pcs',
        //     "required|trim|numeric|greater_than[0]|less_than_equal_to[{$stok}]",
        //     [
        //         'less_than_equal_to' => "Jumlah West tidak boleh lebih dari {$stok}"
        //     ]
        // );
    }

    public function add2()
    {
        $this->_validasi2();
        if ($this->form_validation->run() == false) {
            $data['title'] = "Barang Sisa";
            $data['barang'] = $this->admin->get('barang', ['satuan_id' => 2]);

            // Mendapatkan dan men-generate kode transaksi barang west
            $kode = 'T-BW-' . date('ymd');
            $kode_terakhir = $this->admin->getMax('barang_west', 'id_barang_west', $kode);
            $kode_tambah = substr($kode_terakhir, -5, 5);
            $kode_tambah++;
            $number = str_pad($kode_tambah, 5, '0', STR_PAD_LEFT);
            $data['id_barang_west'] = $kode . $number;

            $this->template->load('templates/dashboard', 'barang_west/add2', $data);
        } else {
            $dat = $this->admin->get('barang', ['satuan_id' => 3]);
            $id = json_decode(json_encode($dat['id_barang']));
            $stoklama = json_decode(json_encode($dat['stok']));
            $qty = $this->input->post('jumlah_pcs');
            $data = array('stok' => $stoklama - $qty);

            // $update = $this->admin->update('barang', 'id_barang', $id, $data);

            $input = $this->input->post(null, true);
            $insert = $this->admin->insert('barang_west', $input);

            if ($insert) {
                set_pesan('data berhasil disimpan.');
                redirect('barangwest');
            } else {
                set_pesan('Opps ada kesalahan!');
                redirect('barangwest/add2');
            }
        }
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        if ($this->admin->delete('barang_west', 'id_barang_west', $id)) {
            set_pesan('data berhasil dihapus.');
        } else {
            set_pesan('data gagal dihapus.', false);
        }
        redirect('barangwest');
    }
}

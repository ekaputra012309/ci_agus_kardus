<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        cek_login();

        $this->load->model('Admin_model', 'admin');
    }

    public function index()
    {
        $data['title'] = "Dashboard";
        $data['barang'] = $this->admin->count('barang');
        $data['barang_masuk'] = $this->admin->count('barang_masuk');
        $data['barang_keluar'] = $this->admin->count('barang_keluar');
        $data['supplier'] = $this->admin->count('supplier');
        $data['user'] = $this->admin->count('user');
        $data['stok'] = $this->admin->sum1('barang', 'stok');
        $data['stok2'] = $this->admin->sum2('barang', 'stok');
        $data['barang_min'] = $this->admin->getBarang();
        $data['transaksi'] = [
            'barang_masuk' => $this->admin->getBarangMasuk(30),
            'barang_keluar' => $this->admin->getBarangKeluar(30),
            'barang_west' => $this->admin->getBarangWest(30)
        ];

        // Line Chart
        $bln = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
        $data['cbm'] = [];
        $data['cbk'] = [];
        $data['cbw'] = [];

        foreach ($bln as $b) {
            $data['cbm'][] = $this->admin->chartBarangMasuk($b);
            $data['cbk'][] = $this->admin->chartBarangKeluar($b);
            $data['cbw'][] = $this->admin->chartBarangWest($b);
        }

        $this->template->load('templates/dashboard', 'dashboard', $data);
    }
}

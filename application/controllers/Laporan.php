<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
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
        $this->form_validation->set_rules('transaksi', 'Transaksi', 'required|in_list[barang_masuk,barang_keluar,barang_kardus]');
        $this->form_validation->set_rules('tanggal', 'Periode Tanggal', 'required');

        if ($this->form_validation->run() == false) {
            $data['title'] = "Laporan Transaksi";
            $this->template->load('templates/dashboard', 'laporan/form', $data);
        } else {
            $input = $this->input->post(null, true);
            $table = $input['transaksi'];
            $tanggal = $input['tanggal'];
            $pecah = explode(' - ', $tanggal);
            $mulai = date('Y-m-d', strtotime($pecah[0]));
            $akhir = date('Y-m-d', strtotime(end($pecah)));

            $query = '';
            if ($table == 'barang_masuk') {
                $query = $this->admin->getBarangMasuk(null, null, ['mulai' => $mulai, 'akhir' => $akhir]);
            } else if ($table == 'barang_keluar'){
                $query = $this->admin->getBarangKeluar(null, null, ['mulai' => $mulai, 'akhir' => $akhir]);
            } else {
                $query = $this->admin->getBarangWest(null, null, ['mulai' => $mulai, 'akhir' => $akhir]);
            }

            $this->_cetak($query, $table, $tanggal);
        }
    }

    private function _cetak($data, $table_, $tanggal)
    {
        $this->load->library('CustomPDF');

        if($table_ == 'barang_masuk'):
          $table = 'Barang Masuk';
        elseif($table_ == 'barang_keluar'):
          $table = 'Barang Keluar';
        else:
          $table = 'Barang West';
        endif;

        // $table = $table_ == 'barang_masuk' ? 'Barang Masuk' : 'Barang Keluar';

        $pdf = new FPDF();
        $pdf->AddPage('L', 'A4');
        $pdf->SetFont('Times', 'B', 16);
        $pdf->Cell(280, 7, 'Laporan ' . $table, 0, 1, 'C');
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(280, 4, 'Tanggal : ' . $tanggal, 0, 1, 'C');
        $pdf->Ln(10);

        $pdf->SetFont('Arial', 'B', 10);

        if($table_ == 'barang_masuk'):
          $pdf->Cell(10, 7, 'No.', 1, 0, 'C');
          $pdf->Cell(25, 7, 'Tgl Masuk', 1, 0, 'C');
          $pdf->Cell(35, 7, 'ID Transaksi', 1, 0, 'C');
          $pdf->Cell(55, 7, 'Nama Barang', 1, 0, 'C');
          $pdf->Cell(50, 7, 'Supplier', 1, 0, 'C');
          $pdf->Cell(30, 7, 'Qty', 1, 0, 'C');
          $pdf->Cell(35, 7, 'Harga', 1, 0, 'C');
          $pdf->Cell(35, 7, 'Jumlah', 1, 0, 'C');
          $pdf->Ln();

          $no = 1;
          $sum = 0;
          foreach ($data as $d) {
            $jml = $d['jumlah_masuk']*$d['harga_masuk'];
            //cek satuan
            if ($d['satuan_m']==1) {
              $sat = "Ton";
              $jmlm = $d['jumlah_masuk'];
            } else if ($d['satuan_m']==2) {
              $sat = "Kg";
              $jmlm = $d['jumlah_masuk'];
            } else {
              $sat = "Pcs";
              $jmlm = $d['jumlah_masuk'];
            }
            //cek harga
            if ($d['harga_masuk']>0) {
              $hrg = "Rp " . number_format($d['harga_masuk'],0,',','.') . " / " . $sat;
            } else {
              $hrg = "Rp - / " . $sat;
            }

            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(10, 7, $no++ . '.', 1, 0, 'C');
            $pdf->Cell(25, 7, $d['tanggal_masuk'], 1, 0, 'C');
            $pdf->Cell(35, 7, $d['id_barang_masuk'], 1, 0, 'C');
            $pdf->Cell(55, 7, $d['nama_barang'], 1, 0, 'L');
            $pdf->Cell(50, 7, $d['nama_supplier'], 1, 0, 'L');
            $pdf->Cell(30, 7, $jmlm . ' ' . $sat, 1, 0, 'C');
            $pdf->Cell(35, 7, $hrg, 1, 0, 'L');
            $pdf->Cell(35, 7, "Rp " . number_format($jml,0,',','.'), 1, 0, 'L');
            $pdf->Ln();
            $sum+= $jml;
        }
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(240, 7, 'Total :', 0, 0, 'R');
        $pdf->Cell(35, 7, "Rp " . number_format($sum,0,',','.'), 0, 0, 'C');
        
        elseif($table_ == 'barang_keluar'):
          $pdf->Cell(10, 7, 'No.', 1, 0, 'C');
          $pdf->Cell(35, 7, 'Tanggal', 1, 0, 'C');
          $pdf->Cell(45, 7, 'ID Transaksi', 1, 0, 'C');
          $pdf->Cell(75, 7, 'Nama Barang', 1, 0, 'C');
          $pdf->Cell(35, 7, 'Qty', 1, 0, 'C');
          $pdf->Cell(35, 7, 'Harga', 1, 0, 'C');
          $pdf->Cell(35, 7, 'Jumlah', 1, 0, 'C');
          $pdf->Ln();

          $no = 1;
          $sum = 0;
          foreach ($data as $d) {
            $jml = $d['jumlah_keluar']*$d['harga'];
            //cek harga
            if ($d['harga']>0) {
              $hrg = "Rp " . number_format($d['harga'],0,',','.') . " / " . $d['nama_satuan'];
            } else {
              $hrg = "Rp - / " . $d['nama_satuan'];
            }
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(10, 7, $no++ . '.', 1, 0, 'C');
            $pdf->Cell(35, 7, $d['tanggal_keluar'], 1, 0, 'C');
            $pdf->Cell(45, 7, $d['id_barang_keluar'], 1, 0, 'C');
            $pdf->Cell(75, 7, $d['nama_barang'], 1, 0, 'L');
            $pdf->Cell(35, 7, $d['jumlah_keluar'] . ' ' . $d['nama_satuan'], 1, 0, 'C');
            $pdf->Cell(35, 7, $hrg, 1, 0, 'L');
            $pdf->Cell(35, 7, "Rp " . number_format($jml,0,',','.'), 1, 0, 'L');
            $pdf->Ln();
            $sum+= $jml;
        }
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(235, 7, 'Total :', 0, 0, 'R');
        $pdf->Cell(35, 7, "Rp " . number_format($sum,0,',','.'), 0, 0, 'L');
        else:
          $pdf->Cell(10, 7, 'No.', 1, 0, 'C');
          $pdf->Cell(35, 7, 'Tanggal', 1, 0, 'C');
          $pdf->Cell(45, 7, 'ID Transaksi', 1, 0, 'C');
          $pdf->Cell(75, 7, 'Nama Barang', 1, 0, 'C');
          $pdf->Cell(35, 7, 'Qty', 1, 0, 'C');
          $pdf->Cell(35, 7, 'Harga', 1, 0, 'C');
          $pdf->Cell(35, 7, 'Jumlah', 1, 0, 'C');
          $pdf->Ln();

          $no = 1;
          $sum = 0;
          foreach ($data as $d) {
            $jml = $d['jumlah_west']*$d['harga'];
            //cek harga
            if ($d['harga']>0) {
              $hrg = "Rp " . number_format($d['harga'],0,',','.') . " / " . $d['nama_satuan'];
            } else {
              $hrg = "Rp - / " . $d['nama_satuan'];
            }
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(10, 7, $no++ . '.', 1, 0, 'C');
            $pdf->Cell(35, 7, $d['tanggal_west'], 1, 0, 'C');
            $pdf->Cell(45, 7, $d['id_barang_west'], 1, 0, 'C');
            $pdf->Cell(75, 7, $d['nama_barang'], 1, 0, 'L');
            $pdf->Cell(35, 7, $d['jumlah_west'] . ' ' . $d['nama_satuan'], 1, 0, 'C');
            $pdf->Cell(35, 7, $hrg, 1, 0, 'L');
            $pdf->Cell(35, 7, "Rp " . number_format($jml,0,',','.'), 1, 0, 'L');
            $pdf->Ln();
            $sum+= $jml;
        }
        $pdf->Ln();
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(235, 7, 'Total :', 0, 0, 'R');
        $pdf->Cell(35, 7, "Rp " . number_format($sum,0,',','.'), 0, 0, 'L');
        endif;

        $file_name = $table . ' ' . $tanggal;
        $pdf->Output('I', $file_name);
    }
}

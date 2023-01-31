<?= $this->session->flashdata('pesan'); ?>
<div class="card shadow-sm border-bottom-primary">
    <div class="card-header bg-white py-3">
        <div class="row">
            <div class="col">
                <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                    Riwayat Data Barang Masuk
                </h4>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('barangmasuk/add') ?>" class="btn btn-sm btn-primary btn-icon-split">
                    <span class="icon">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">
                        Input Barang Masuk
                    </span>
                </a>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped w-100 dt-responsive nowrap" id="dataTable">
            <thead>
                <tr>
                    <th>No. </th>
                    <th>No Transaksi</th>
                    <th>Tanggal Masuk</th>
                    <th>Supplier</th>
                    <th>Nama Barang | Qty</th>
                    <!-- <th>Jumlah Masuk</th> -->
                    <th>Harga</th>
                    <th>Dimensi | Berat</th>
                    <?php if (is_admin() || is_gudang()) : ?><th>Hapus</th><?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                if ($barangmasuk) :
                    foreach ($barangmasuk as $bm) :
                        //cek satuan
                        if ($bm['satuan_m']==1) {
                            $sat = "Ton";
                            $jmlm = $bm['jumlah_masuk'];
                        } else if ($bm['satuan_m']==2) {
                            $sat = "Kg";
                            $jmlm = $bm['jumlah_masuk'];
                        } else {
                            $sat = "Pcs";
                            $jmlm = $bm['jumlah_masuk'];
                        }
                        //cek harga
                        if ($bm['harga_masuk']>0) {
                            $hrg = "Rp " . number_format($bm['harga_masuk'],0,',','.') . " / " . $sat;
                        } else {
                            $hrg = "Rp - / " . $sat;
                        }
                        
                        $uk = explode(':', $bm['ukuran']);
                        
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $bm['id_barang_masuk']; ?></td>
                            <td><?= $bm['tanggal_masuk']; ?></td>
                            <td><?= $bm['nama_supplier']; ?></td>
                            <td><?= $bm['nama_barang'] ." | ". $jmlm . ' ' . $sat ?></td>
                            <!-- <td><?= $jmlm . ' ' . $sat ; ?></td> -->
                            <td><?= $hrg ?></td>
                            <td><?= $uk[0] ."m x ".$uk[1] ."m | ".$uk[2]." kg" ?></td>
                            <!-- <td><?= $bm['nama']; ?></td> -->
                            <?php if (is_admin() || is_gudang()) : ?>
                            <td>
                                <a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('barangmasuk/delete/') . $bm['id_barang_masuk'] ?>" class="btn btn-danger btn-circle btn-sm"><i class="fa fa-trash"></i></a>
                            </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="8" class="text-center">
                            Data Kosong
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
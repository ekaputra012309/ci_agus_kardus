<?= $this->session->flashdata('pesan'); ?>
<div class="card shadow-sm border-bottom-primary">
    <div class="card-header bg-white py-3">
        <div class="row">
            <div class="col">
                <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                    Riwayat Data Barang West
                </h4>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('barangwest/add2') ?>" class="btn btn-sm btn-primary btn-icon-split">
                    <span class="icon">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">
                        Input Barang west
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
                    <th>Tanggal</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <!-- <th>User</th> -->
                    <?php if (is_admin() || is_gudang()) : ?><th>Hapus</th><?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                if ($barangwest) :
                    foreach ($barangwest as $bk) :
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $bk['id_barang_west']; ?></td>
                            <td><?= $bk['tanggal_west']; ?></td>
                            <td><?= $bk['nama_barang']; ?></td>
                            <td><?= $bk['jumlah_west'] . ' ' . $bk['nama_satuan']; ?></td>
                            <td><?= "Rp " . number_format($bk['harga'],0,',','.') . "/" . $bk['nama_satuan']; ?></td>
                            <!-- <td><?= $bk['nama']; ?></td> -->
                            <?php if (is_admin() || is_gudang()) : ?>
                            <td>
                                <a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('barangwest/delete/') . $bk['id_barang_west'] ?>" class="btn btn-danger btn-circle btn-sm"><i class="fa fa-trash"></i></a>
                            </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7" class="text-center">
                            Data Kosong
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
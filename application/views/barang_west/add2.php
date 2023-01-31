<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-bottom-primary">
            <div class="card-header bg-white py-3">
                <div class="row">
                    <div class="col">
                        <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                            Form Input Barang Sisa
                        </h4>
                    </div>
                    <div class="col-auto">
                        <a href="<?= base_url('barangwest') ?>" class="btn btn-sm btn-secondary btn-icon-split">
                            <span class="icon">
                                <i class="fa fa-arrow-left"></i>
                            </span>
                            <span class="text">
                                Kembali
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?= $this->session->flashdata('pesan'); ?>
                <?= form_open('', [], ['id_barang_west' => $id_barang_west, 'user_id' => $this->session->userdata('login_session')['user']]); ?>
                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="id_barang_west">ID Transaksi Barang West</label>
                    <div class="col-md-4">
                        <input value="<?= $id_barang_west; ?>" type="text" readonly="readonly" class="form-control">
                        <?= form_error('id_barang_west', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="tanggal_west">Tanggal</label>
                    <div class="col-md-4">
                        <input value="<?= set_value('tanggal_west', date('Y-m-d')); ?>" name="tanggal_west" id="tanggal_west" type="text" class="form-control date" placeholder="Tanggal Masuk...">
                        <?= form_error('tanggal_west', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="barang_id">Nama Barang</label>
                    <div class="col-md-5">
                        <div class="input-group">
                            <input value="<?= set_value('barang_id', $barang['id_barang']); ?>" name="barang_id" id="barang_id" type="text" class="form-control d-none" placeholder="Nama Barang...">
                            <input value="<?= set_value('nama_barang', $barang['nama_barang']); ?>" id="nama_barang" type="text" class="form-control" placeholder="Nama Barang..." readonly="">
                        </div>
                        <?= form_error('id_barang', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <!-- <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="stok">Stok</label>
                    <div class="col-md-5">
                        <input readonly="readonly" id="stok" type="number" class="form-control">
                    </div>
                </div> -->
                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="jumlah_west">Jumlah (Kg)</label>
                    <div class="col-md-5">
                        <div class="input-group">
                            <input autofocus="" value="<?= set_value('jumlah_west'); ?>" name="jumlah_west" id="jumlah_west" type="number" class="form-control" placeholder="Jumlah West...">
                            <div class="input-group-append">
                                <span class="input-group-text" id="satuan">Kg</span>
                            </div>
                        </div>
                        <?= form_error('jumlah_west', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <!-- <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="jumlah_pcs">Jumlah (Pcs)</label>
                    <div class="col-md-5">
                        <div class="input-group">
                            <input autofocus="" value="<?= set_value('jumlah_pcs'); ?>" name="jumlah_pcs" id="jumlah_pcs" type="number" class="form-control" placeholder="Jumlah PCS...">
                            <div class="input-group-append">
                                <span class="input-group-text" id="satuan">Pcs</span>
                            </div>
                        </div>
                        <?= form_error('jumlah_pcs', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div> -->
                <!-- <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="total_stok">Total Stok</label>
                    <div class="col-md-5">
                        <input readonly="readonly" id="total_stok" type="number" class="form-control">
                    </div>
                </div> -->
                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="harga">Harga Satuan</label>
                    <div class="col-md-5">
                        <input name="harga" id="harga" type="number" class="form-control">
                        <?= form_error('harga', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col offset-md-4">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>
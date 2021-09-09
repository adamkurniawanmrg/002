<div class="content-wrapper">
    <div class="card">
        <div class="card-header">
            <h3><?=$title;?></h3> 
        </div>

        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                 <a href="<?=base_url('akseswebsites?token='.$_GET['token']);?>" class="btn btn-sm btn-danger"><em class="ti-arrow-left"></em> Kembali</a>
                <a href="<?=base_url('akseswebsites/tambahrole/'.$website->id.'?token='.$_GET['token']);?>" class="btn btn-sm btn-success"><em class="ti-plus"></em> Tambah</a>
            </li>
            <li class="list-group-item">
               <div class="row">
                <div class="col-12">
                    <?= $this->session->flashdata('pesan'); ?>
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                        
                      <thead>
                        <tr>
                            <th width="40">#</th>
                            <th>Nama Role</th>
                            <th>Jumlah Akses Menu</th>
                            <th width="30%"></th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php $no = 1;
                        foreach ($roles as $r) : ?>
                            <tr>
                                <th scope="row"><?= $no;$no++; ?>.</th>
                                <td><?= $r->role_name; ?></td>
                                <td><?=$this->db->where('role_id', $r->role_id)->get('tb_role_access')->num_rows();?></td>
                                <td align="right">
                                    <a href="<?= base_url('akseswebsites/konfigurasiaksesrole/') . $r->role_id . '?token=' . $_GET['token'] ?>" class="btn btn-info" style="padding: 8px 15px">
                                        <em class="ti-exchange-vertical"></em> Konfigurasi Akses Role
                                    </a>
                                    <a href="<?= base_url('akseswebsites/ubahrole/') . $r->role_id . '?token=' . $_GET['token'] ?>" class="btn btn-warning" style="padding: 8px 15px">
                                        <em class="ti-pencil"></em> Ubah
                                    </a>
                                    <a href="<?= base_url('akseswebsites/hapusrole/') . $r->role_id . '?token=' . $_GET['token'] ?>" onclick="if(!confirm('Apakah anda yakin untuk menghapus?')) return false;" class="btn btn-danger" style="padding: 8px 15px">
                                        <em class="ti-trash"></em> Hapus
                                    </a>
                                </td>
                            </tr>

                        <?php endforeach;
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </li>
        </ul>
    </div>
</div>

<?php $this->view('template/javascript'); ?>


<div class="content-wrapper">
    <div class="card">
        <div class="card-header">
            <h3>Data Website</h3> 
        </div>
        <div class="col-3 mt-3">
            
        <a href="<?= base_url("websites/add?token=".$_GET['token']) ?>" class="btn btn-sm btn-primary"><em class="ti-plus"></em> 
           Tambah Website
        </a>
    
        </div>
        <hr>
        
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
               <div class="row">
                <div class="col-12">
         <?= $this->session->flashdata('pesan'); ?>
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                        
                      <thead>
                        <tr>
                            <th>#</th>
                            <th></th>
                            <th>Nama Website</th>
                            <th>Domain</th>
                            <th width="100">Opsi</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php $no = 1;
                        foreach ($website as $bk) : ?>
                            <tr>
                                <th scope="row"><?= $no++ ?>.</th>
                                <td><img src="<?= base_url("assets/images/logo_website/") . $bk['logo'] ?>" alt="" width="200px"></td>
                                <td><?= $bk['nama_website']; ?></td>
                                <td><?= $bk['domain']; ?></td>
                               
                                <td align="right">
                                    <?php if($bk['api_id']) : ?>
                                    <a href="<?= base_url('websites/role/') . $bk['id'] . '?token=' . $_GET['token'] ?>" class="btn btn-info btn-sm" style="padding: 8px 15px"><em class="ti-exchange-vertical"></em> Role</a>
                                    <?php endif;?>
                                    <a href="<?= base_url('websites/api/') . $bk['id'] . '?token=' . $_GET['token'] ?>" class="btn btn-warning btn-sm" style="padding: 8px 15px"><em class="ti-rocket"></em> API</a>
                                    <a href="<?= base_url('websites/edit/') . $bk['id'] . '?token=' . $_GET['token'] ?>" class="btn btn-success btn-sm" style="padding: 8px 15px"><em class="ti-pencil"></em> Ubah</a>
                                    <a href="<?= base_url('websites/delete/') . $bk['id'] . '?token=' . $_GET['token'] ?>" class="btn btn-danger"  style="padding: 8px 15px" title="Delete" onclick="javascript: return confirm('Anda yakin hapus ?')"> <em class="ti-trash"></em> Hapus</a>
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


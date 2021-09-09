<div class="content-wrapper">
    <div class="card">
        <div class="card-header">
            <h3><?=$title;?></h3> 
        </div>
        <div class="col-3 mt-3">
            
        <a href="<?= base_url("opd/addopd?token=".$_GET['token']) ?>" class="btn btn-sm btn-primary"><em class="ti-plus"></em> 
           Tambah OPD
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
                            <th>Nama Opd</th>
                            <th>Kepala</th>
                            <th>Jlh PNS</th>
                            <th align="right">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php $no = 1;
                        foreach ($dataopd as $op) : ?>
                            <tr>
                                <th scope="row"><?= $no++ ?>.</th>
                                <td><div class="mb-1"><?= $op[0]['nama_opd']; ?></div><?= $op[0]['singkatan'] ? '<span class="label btn-outline-warning">'.$op[0]['singkatan'].'</span>' : null;?></td>
                                <td><?= $op[0]['nama_kepala']; ?></td>
                                <td><?= $op[0]['jumlah_pegawai']; ?></td>
                               
                                <td align="right">
                                    <a href="<?= base_url('opd/editopd/') . $op[0]['id'] . '?token=' . $_GET['token'] ?>" class="btn btn-success btn-sm" style="padding: 8px 15px">Ubah</a>
                                    <a href="<?= base_url('opd/deleteopd/') . $op[0]['id']. '?token=' . $_GET['token'] ?>" class="btn btn-danger"  style="padding: 8px 15px" title="Delete" onclick="javascript: return confirm('Anda yakin hapus ?')">Hapus</a>
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



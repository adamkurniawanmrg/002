<div class="content-wrapper">
    <div class="card">
        <div class="card-header">
            <h3><?=$title;?></h3> 
        </div>

        <ul class="list-group list-group-flush mt-2">
            <li class="list-group-item">
               <div class="row">
                <div class="col-12">
         <?= $this->session->flashdata('pesan'); ?>
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                        
                      <thead>
                        <tr>
                            <th>#</th>
                            <th colspan="2">Nama Website</th>
                            <th>Domain</th>
                            <th></th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php $no = 1;
                        foreach ($website as $bk) : ?>
                            <tr>
                                <th scope="row"><?= $no;$no++; ?>.</th>
                                <td width="40"><img src="<?= base_url("assets/images/logo_website/") . $bk->logo ?>" alt="" width="40"></td>
                                <td><?= $bk->nama_website; ?></td>
                                <td><?= $bk->domain; ?></td>
                                <td align="right">
                                    <a href="<?= base_url('akseswebsites/konfigurasi/') . $bk->id . '?token=' . $_GET['token'] ?>" class="btn btn-warning" style="padding: 8px 15px">
                                        <em class="ti-align-justify"></em> Konfigurasi Menu
                                    </a>
                                    <a href="<?= base_url('akseswebsites/konfigurasirole/') . $bk->id . '?token=' . $_GET['token'] ?>" class="btn btn-info" style="padding: 8px 15px">
                                        <em class="ti-exchange-vertical"></em> Konfigurasi Role
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



<div class="content-wrapper">
    <div class="card">
        <div class="card-header">
            <h3>Data Role - <?=$website->nama_website;?></h3> 
        </div>

        <ul class="list-group list-group-flush">
            <li class="list-group-item">
               <div class="row">
                <div class="col-12">
                 <?= $this->session->flashdata('pesan'); ?>
                  <div class="table-responsive">
                    <table id="roleTable" class="table">
                        
                      <thead>
                        <tr>
                            <th width="10">#</th>
                            <th>Nama Role</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php $no = 1;
                        foreach ($role_api['data'] as $role) : ?>
                            <tr>
                                <th scope="row"><?= $no++ ?>.</th>
                                <td><?= $role['role_name']; ?></td>

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


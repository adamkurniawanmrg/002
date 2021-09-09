<div class="content-wrapper">
    <div class="card">
        <div class="card-header">
            <h3><?=$title;?></h3> 
        </div>
    
    <form method="post">
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <a href="<?=base_url('akseswebsites/konfigurasirole/'.$website->id.'?token='.$_GET['token']);?>" class="btn btn-sm btn-danger"><em class="ti-arrow-left"></em> Kembali</a>
                <button class="btn btn-sm btn-success"><em class="ti-save"></em> Simpan</button>
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
                            <th>Nama Menu</th>
                            <th>Url</th>
                            <th width="30">Akses</th>
                        </tr>
                      </thead>
                      <?=$menu;?>
                    </table>
                  </div>
                </div>
              </div>
            </li>
        </ul>
    </form>
    
<?php $this->view('template/javascript'); ?>
    
    </div>
</div>


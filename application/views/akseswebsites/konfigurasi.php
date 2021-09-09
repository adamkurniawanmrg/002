<div class="content-wrapper">
          <div class="card">
            <div class="card-header">
              <h3><?=$title;?></h3>
            </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <a href="<?=base_url('akseswebsites?token='.$_GET['token']);?>" class="btn btn-sm btn-danger"><em class="ti-arrow-left"></em> Kembali</a>
                	<button id="btnMenuBaru" class="btn btn-sm btn-success"><i class="ti-plus"></i> Menu Baru</button>
                    <button class="btn btn-info btn-sm" id="btnBatal"><i class="ti-reload"></i> Refresh</button>
                    <button class="btn btn-primary btn-sm" id="btnSimpan"><i class="ti-save"></i> Simpan</button>
                </li>
                <li class="list-group-item">
                    <div class="row">
                        <div class="col-md-8 col-lg-6">
                			<div class="mb-5">
                    			<div class="mb-2" id="body_add_menu" style="margin-left: 50px; display:none">
                                    <form method="post" id="formMenu">
                                        <input type="hidden" name="menu_id" id="menu_id">
                                        <div class="form-group mb-3">
                            			    <label for="nama">Nama Menu</label>
                                            <input type="text" id="nama" class="form-control" name="nama" placeholder="Contoh : Halaman Utama">
                                        </div>
                                        <div class="form-group mb-3">
                            			    <label for="url">Url Menu</label>
                                            <input type="text" id="url" class="form-control" name="url" placeholder="Contoh : controller/method">
                                        </div>
                                        <div class="form-group mb-5">
                            			    <label for="icon">Icon</label>
                                            <input type="text" id="icon" class="form-control" name="icon" placeholder="Contoh : ti-home">
                                        </div>
                                        
                            			<a id="btnBatalAdd" class="btn btn-sm btn-default">Tutup</a>
                            			<button id="btnAddMenu" class="btn btn-sm btn-success">Simpan</button>
                                    </form>
                    			</div>
                        		
	
                			    
                			</div>
                            <?=$menus;?>

                        </div>
                      </div>
                    </li>
                  </ul>
          </div>
        </div>
        
<?php $this->view('template/javascript'); ?>
        <!-- content-wrapper ends -->

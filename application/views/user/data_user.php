<div class="content-wrapper">
    <div class="card">
        <div class="card-header">
            <h3>Data Users</h3> 
        </div>

        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <a href="<?= base_url("user/generaterole?token=".$_GET['token']) ?>" class="btn btn-sm btn-primary"><em class="ti-exchange"></em>Generate Role</a>
            </li>
            <?php if($this->session->userdata('role_id')==1) { ?>
            <li class="list-group-item">
                <?= $this->session->flashdata('pesan'); ?>
                <div class="row mb-3">
                    <div class="col-md-2 pt-2">Unit Kerja</div>
                    <div class="col-md-10">
                        <div class="form-group mb-0">
                            <select id="skpd_id" name="skpd_id" class="form-control select2">
                                <option value="">Pilih Unit Kerja</option>
                                <?php foreach ($skpds as $skpd) { ?>
                                    <option value="<?= $skpd['id_skpd']; ?>"><?= $skpd['nama_skpd']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12"><button id="btnFilter" class="btn btn-outline-primary btn-sm">Tampilkan</button></div>
                </div>
            </li>
            <?php }else{ ?>
            <li class="list-group-item">
                <?= $this->session->flashdata('pesan'); ?>
                <div class="row mb-3">
                    <div class="col-md-2 pt-2">Unit Kerja</div>
                    <div class="col-md-10">
                        <div class="form-group mb-0">
                            <select id="skpd_id" name="skpd_id" class="form-control select2">
                                <option value="">Semua Unit Kerja</option>
                                <?php foreach ($skpds2 as $skpd) { ?>
                                    <option value="<?= $skpd['skpd_id']; ?>"><?= $skpd['nama_skpd']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12"><button id="btnFilter" class="btn btn-outline-primary btn-sm">Tampilkan</button></div>
                </div>
            </li>
            <?php } ?>

            <li class="list-group-item">
                <table id="tableUsers" class="table table-hover table-striped" width="100%">
                  <thead>
                    <tr>
                        <th width="20">#</th>
                        <th width="150">Nama</th>
                        <th width="80">SKPD</th>
                        <th width="60">NIP</th>
                        <!--<th width="60">No. WhatsApp</th>-->
                        <th width="40">Opsi</th>
                    </tr>
                  </thead>
                </table>
            </li>
        </ul>
    </div>
</div>

<?php $this->view('template/javascript'); ?>
<script>
	$(document).ready(function() {
        Filter();
        $('#btnFilter').click(function(){
            Filter();
        });
	    function Filter(){
            $('#tableUsers').DataTable().destroy();
            $('#tableUsers').DataTable({
                scrollX: true,
                responsive: true,
    	        ajax: {
    	            url:'<?=base_url('user/getAllUsers?token='.$_GET['token']);?>',
    	            type: 'post',
    	            data:{
    	                skpd_id: $('#skpd_id').val(),
    	            }
    	        },
    		    pageLength: 20,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'copy',
                        exportOptions: {
                            columns: [ ':visible' ]
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    'colvis'
                    // 'copy', 'csv', 'excel', 'pdf', 'print','colvis'
                ]
    		});
	    }
	});
</script>
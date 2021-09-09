<div class="content-wrapper">
    <div class="card">
        <div class="card-header">
            <h3><?= $title ?></h3> 
        </div>

        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <?php if($this->session->userdata('role_id') == 1): ?>
                    <a href="<?= base_url("usertks/generaterole?token=".$_GET['token']) ?>" class="btn btn-sm btn-warning"><em class="ti-exchange"></em> 
                       Generate Role
                    </a>
                    <a href="<?= base_url("usertks/tambah?token=".$_GET['token']) ?>" class="btn btn-sm btn-primary"><em class="ti-plus"></em> 
                      Tambah Pegawai TKS
                    </a>
                <?php else: ?>
                    <a href="<?= base_url("usertks/tambah?token=".$_GET['token']) ?>" class="btn btn-sm btn-primary"><em class="ti-plus"></em> 
                      Tambah Pegawai TKS
                    </a>
                <?php endif ; ?>
                
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
                            <th>#</th>
                            <th>Nama</th>
                            <th>NIK</th>
                            <th>Unit Kerja</th>
                            <th>Nomor HP</th>
                            <th width="40">Aksi</th>
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
                scrollY: false,
                responsive: true,
    	        ajax: {
    	            url:'<?=base_url('usertks/getAllTks?token='.$_GET['token']);?>',
    	            type: 'post',
    	            data:{
    	                skpd_id: $('#skpd_id').val(),
    	            }
    	        },
                initComplete: function(settings, json) {
                    $('.dataTables_scrollBody').css("overflow-y", "hidden");
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

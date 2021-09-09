<div class="content-wrapper">
    <div class="card">
        <div class="card-header">
            <h3>Unit Kerja</h3> 
        </div>

        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <?=$this->session->flashdata('pesan');?>
                <table id="tableUnitkerja" class="table table-hover table-striped table-bordered" width="100%">
                  <thead>
                    <tr>
                        <th width="20">#</th>
                        <th>Nama</th>
                        <th width="500">Unit Kerja</th>
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
	    function Filter(){
            $('#tableUnitkerja').DataTable().destroy();
            $('#tableUnitkerja').DataTable({
                scrollX: true,
                responsive: true,
    	        ajax: {
    	            url:'<?=base_url('unitkerja/getOpd?token='.$_GET['token']);?>',
    	            type: 'post',
    	        },
    		    pageLength: 25,
    		});
	    }
	});
</script>
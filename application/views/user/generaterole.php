<!-- Begin Page Content -->
<div class="content-wrapper">
    <div class="card">
        <div class="card-header">
            <span class="h5 mb-4 text-gray-800"><?= $title ?></span>
        </div>
        <div class="card-body">
            <form method="post" id="formGenerate">
                <?=$this->session->flashdata('pesan');?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group row mb-3">
                            <label for="opd_id" class="col-md-2">OPD</label>
                            <div class="col-md-10">
                                <select id="opd_id" name="opd_id" class="form-control select2">
                                    <option value="0">-- Semua OPD --</option>
                                    <?php foreach ($opds as $opd) { ?>
                                        <option value="<?=$opd->id_skpd; ?>"><?= $opd->nama_skpd; ?></option>
                                    <?php } ?>
                                </select>
                              <?= form_error('opd_id', '<small class="text-danger pl-2">', '</small>'); ?>
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <label for="website_id" class="col-md-2">Website</label>
                            <div class="col-md-10">
                                <select id="website_id" name="website_id" class="form-control select2">
                                    <option value="">-- Pilih Website --</option>
                                    <?php foreach ($websites as $website) { ?>
                                        <option value="<?=$website->id; ?>"><?= $website->nama_website; ?></option>
                                    <?php } ?>
                                </select>
                                <?= form_error('website_id', '<small class="text-danger pl-2">', '</small>'); ?>
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <label for="role" class="col-md-2">Role</label>
                            <div class="col-md-10" id="body_role">
                                -
                            </div>
                          <?= form_error('role', '<small class="text-danger pl-2">', '</small>'); ?>
                        </div>
                        <div class="form-group mb-3 row" id="row_action">
                            <label for="body_action" class="col-md-2">Aksi jika role sudah ada pada pengguna</label>
                            <div class="col-md-10" id="body_action">
                                <label>
                                    <input type="radio" name="action" value="merge" /> Merge
                                </label>
                                <label>
                                    <input type="radio" name="action" class="ml-5" value="skip" checked /> Skip
                                </label>
                            </div>

                        </div>
        
                        <button id="btnFilter" type="button" class="btn btn-primary btn-sm mt-3" id="keyword">Submit</button>
                        <img style="margin-top:15px;" id="loading-animation" src="<?= base_url('assets/img/icon/loading.gif') ?>" width="20" />
        
                        <div id="pegawaiModal" class="labura-modal">
                            <div class="labura-modal-content content-wrapper">
                                <p id="pegawaiList">
                                    <div class="card" style="margin-top:20px; margin-bottom:20px">
                                        <div class="card-header">
                                            <span class="h5 mb-4 text-gray-800" id="judulModal">Pilih Pegawai</span>
                                        </div>
                                        <div class="card-body table-responsive card-modal">
                                            <table class="table-striped table-hover" cellpadding="6" width="100%">
                                                <thead class="text-center">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Nama Pegawai</th>
                                                        <th>NIP</th>
                                                        <th><label for="rekap_semua">Semua</label> <input type='checkbox' id="rekap_semua" name='rekap_semua' value='1' /></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="listTdPegawai">
                                                </tbody>
                                            </table>
                                        </div>
                                        <ul class="list-group list-group-flush table-responsive">
                                            <li class="list-group-item">
                                                <button type="submit" id="btnSelesaiPegawai" class="btn btn-sm btn-primary" disabled>Selesai & Generate</button>
                                                <button type="button" id="closeLaburaModal" class="btn btn-sm btn-danger">Batalkan</button>
                                            </li>
                                        </ul>
                        
                                    </div>
                                </p>
                            </div>
                        </div>
        
                    </div>
                </div>
        
        </form>
        </div>
    </div>
</div>



<?php $this->view('template/javascript'); ?>

<script>
    var capt = "NONE";
    var num_refresh     = [];

    $("#loading-animation").hide();

    $("#btnFilter").click(function() {
        getdatapegawai();
    });
    
    $("#finish-alert").hide();

    $("#website_id").change(function(){
        getDataRole();
    });
    $('#row_action').hide();
    $("#opd_id").change(function(){
        if($("#opd_id").val()==0){
            $('#row_action').hide();
        }else{
            $('#row_action').show();
        }
    });

    
    function getDataRole(){
        $.ajax({
            type: "POST",
            url: "<?= base_url('user/getrole_generaterole?token=' . $_GET['token']); ?>",
            data: {
                "website_id"    : $('#website_id').val(),
            },
            success: function(role) {
                $('#body_role').html(role);
            }
        });

    }
    
    function getdatapegawai() {

        if($('#website_id').val()==""){
            alert('Pilih Website terlebih dahulu!');
            return;
        }        
        if($('#opd_id').val()==0){
            $('#formGenerate').submit();
            return;
        }        

        $("#loading-animation").show();
        $('#btnFilter').html('Sedang di proses . . .');
        $("#btnFilter").prop("disabled", true);

        $.ajax({
            type: "POST",
            url: "<?= base_url('user/getpegawaibyskpd?token='.$_GET['token']); ?>",
            data: {
                "opd_id": $('#opd_id').val(),
            },
            success: function(data) {
                $("#loading-animation").hide();
                $("#btnFilter").html("Submit");
                $("#btnFilter").removeAttr("disabled");

                data = $.parseJSON(data);
                var list = $('#list_console_tarikdata');
                var listTd = $('#listTdPegawai');

                listTd.html(null);

                $('#judulModal').html('Generate Role '+data.opd.nama_skpd);

                for(var i=0; i<data.pegawai.length; i++){
                    listTd.html(listTd.html()+""+addListTdPegawai(i, data.pegawai[i].nip, data.pegawai[i].nama, data.pegawai[i].id));
                }

                $("#pegawaiModal").show();

                $('#rekap_semua').click(function() {
                    $(':checkbox.rekap_pegawai').prop('checked', this.checked);
                    checkNumSelected();

                });

                $("#closeLaburaModal").click(function() {
                    $("#pegawaiModal").fadeOut(500);
                    $('#pegawaiList').html(null);

                });

                $(":checkbox.rekap_pegawai").each(function() {
                    $(this).click(function(){
                        checkNumSelected();
                    });
                });


                function checkNumSelected(){
                    var a= $(":checkbox.rekap_pegawai:checked").length;
                    if(a>0){
                        $('#btnSelesaiPegawai').removeAttr('disabled');
                    }else{
                        $('#btnSelesaiPegawai').prop('disabled', true);
                    }
                }

                
                
            },
            error: function(xhr, status, error) {
                $("#loading-animation").hide();
                $("#btnFilter").html("Submit");
                $("#btnFilter").removeAttr("disabled");

                var errorMessage = xhr.status + ': ' + xhr.statusText;
                alert(errorMessage);
            }
        });
    }



    function addListTdPegawai(index, nip, nama, id){
        return '<tr><td align="center">'+(index+1)+'</td><td>'+nama+'</td><td align="center">'+nip+'</td><td align="center"><input type="checkbox" name="pegawai[]" class="rekap_pegawai" value="'+id+'" /></td></tr>';
        
    }

    function finishAlert(bg, title, desc) {
        $("#finish-alert").fadeTo(15000, 500).slideUp(500, function() {
            $("#finish-alert").slideUp(500);
        });
        $("#alert_judul").html(title);
        $("#alert_deskripsi").html(desc);
        $("#finish-alert").removeClass("alert-danger");
        $("#finish-alert").removeClass("alert-success");
        $("#finish-alert").addClass("alert-"+bg);
    }

</script>

<!-- /.container-fluid -->

<!-- End of Main Content -->
  <!-- plugins:js -->
  <script src="assets/vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->

  <!-- inject:js -->
  <script src="assets/js/off-canvas.js"></script>
  <script src="assets/js/hoverable-collapse.js"></script>
  <script src="assets/js/template.js"></script>
  <script src="assets/js/settings.js"></script>
  <script src="assets/js/todolist.js"></script>
  
<script src="<?=base_url("assets/vendors/datatables.net/jquery.dataTables.js")?>"></script>
<script src="<?=base_url("assets/vendors/datatables.net/jquery.dataTables.js")?>"></script>
<script src="<?=base_url("assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js")?>"></script>
<script src="<?=base_url("assets/vendors/bs-custom-file-input/bs-custom-file-input.min.js")?>"></script>


 <script src="assets/js/file-upload.js"></script>
  <script src="assets/js/typeahead.js"></script>
  <script src="assets/js/select2.js"></script>

<!--Datepicker-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>


<!-- Select2 -->
<script src="<?= base_url('assets/') ?>vendors/select2/select2.min.js"></script>

<!--BS Custom File-->
<script src="<?=base_url("assets/vendors/bs-custom-file-input/bs-custom-file-input.min.js")?>"></script>


  <!-- endinject -->

  <!-- Plugin js for this page-->
  <?php 
    if(isset($javascript)){ 
      for($i=0; $i<count($javascript); $i++){
  ?>
    <script src="<?=$javascript[$i];?>"></script>
  <?php }} ?>

  <script>
    $('.select2').select2({
        theme: 'bootstrap'
    });

    <?=isset($javascriptCode) ? $javascriptCode : null;?>
  </script>
  <!-- End custom js for this page-->

<!--ckeditor script-->
<script src="<?=$conf->admin_url?>ckeditor/ckeditor.js"></script>
<!-- jQuery 2.1.4 -->
    <script src="<?=$conf->admin_url?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?=$conf->admin_url?>bootstrap/js/bootstrap.min.js"></script>
    
    
    <!-- DataTables -->
    <script src="<?=$conf->admin_url?>plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?=$conf->admin_url?>plugins/datatables/dataTables.bootstrap.min.js"></script>
    <!-- Slimscroll -->
    <script src="<?=$conf->admin_url?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="<?=$conf->admin_url?>plugins/fastclick/fastclick.min.js"></script>
    <!-- bootstrap time picker -->
   <script src="<?=$conf->admin_url?>plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?=$conf->admin_url?>dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?=$conf->admin_url?>dist/js/demo.js"></script> 
<script>    
    $(function () {
$(".timepicker").timepicker({
         showInputs: false,
		 step:5
       });
     }); 
	 </script>  
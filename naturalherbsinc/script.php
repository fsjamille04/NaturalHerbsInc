  <!-- ./wrapper -->
  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>

  <script src='dist/js/bootstrap-datepicker.js' type='text/javascript'></script>
  <!-- Bootstrap 4 -->

  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- DataTables -->
  <script src="plugins/datatables/jquery.dataTables.js"></script>
  <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>
  <!-- page script -->
   <script>
  if (window.location.href.indexOf("index") > -1) {
    $('#index').addClass('active');
  }
  if (window.location.href.indexOf("member") > -1) {
    $('#member').addClass('active');
  }
  if (window.location.href.indexOf("referral") > -1) {
    $('#referral').addClass('active');
  }
  if (window.location.href.indexOf("unilevel") > -1) {
    $('#unilevel').addClass('active');
  }
  if (window.location.href.indexOf("register-client.php") > -1) {
    $('#register').addClass('active');
  }
  if (window.location.href.indexOf("repurchase") > -1) {
    $('#repurchase').addClass('active');
  }
  if (window.location.href.indexOf("purchase-history") > -1) {
    $('#history').addClass('active');
  }
  if (window.location.href.indexOf("product-register.php") > -1) {
    $('#product').addClass('active');
  }
  if (window.location.href.indexOf("code") > -1) {
    $('#code').addClass('active');
  }
  $(function() {
    $("#example1").DataTable({
      "paging": true,});
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": false,
    });
  });

  </script>

  </body>

</html>
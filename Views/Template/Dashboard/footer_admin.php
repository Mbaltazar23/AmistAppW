<!-- /.content-wrapper -->
<footer class="main-footer">
    <strong>Copyright &copy; 2023 <a href="<?= base_url() ?>">AdminLTE.io</a>.</strong>
    All rights reserved.
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?= media() ?>/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?= media() ?>/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="<?= media() ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="<?= media() ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= media() ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= media() ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= media() ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?= media() ?>/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= media() ?>/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?= media() ?>/plugins/jszip/jszip.min.js"></script>
<script src="<?= media() ?>/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?= media() ?>/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?= media() ?>/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?= media() ?>/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?= media() ?>/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- SweetAlert2 -->
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script src="<?= media(); ?>/plugins/sweetalert2/swettalert.min.js" type="text/javascript"></script>
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<script>
    $(function () {
        $("#example1").DataTable({
            "responsive": true
        });
    });
</script>
<!-- Bootstrap 4 -->
<script src="<?= media() ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="<?= media() ?>/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="<?= media() ?>/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<!-- jQuery Knob Chart -->
<script src="<?= media() ?>/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?= media() ?>/plugins/moment/moment.min.js"></script>
<script src="<?= media() ?>/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?= media() ?>/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="<?= media() ?>/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?= media() ?>/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= media() ?>/dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?= media() ?>/dist/js/pages/dashboard.js"></script>

<script src="<?= media(); ?>/dist/js/actions/<?= $data['page_functions_js'] ?>" type="text/javascript"></script>

<script>
    const base_url = "<?= base_url(); ?>";
    const smony = "<?= SMONEY; ?>";
</script>

</body>
</html>

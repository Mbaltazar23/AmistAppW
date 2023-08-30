<!-- /.content-wrapper -->
<footer class="main-footer">
    <strong>Copyright &copy; 2023 <a href="<?= base_url() ?>"><?= NOMBRE_WEB ?></a>.</strong>
       Todos los derechos reservados.
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>

<!-- jQuery -->
<script src="<?= media() ?>/js/plugins/jquery/jquery.min.js"></script>
<!-- Vue Js -->
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?= media() ?>/js/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- DataTables  & js/Plugins -->
<script src="<?= media() ?>/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?= media() ?>/js/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= media() ?>/js/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= media() ?>/js/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?= media() ?>/js/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= media() ?>/js/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?= media() ?>/js/plugins/jszip/jszip.min.js"></script>
<script src="<?= media() ?>/js/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?= media() ?>/js/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?= media() ?>/js/plugins/jsPDF/jspdf.min.js" type="text/javascript"></script>
<script src="<?= media() ?>/js/plugins/jsPDF/jspdf.plugin.autotable.js" type="text/javascript"></script>
<!-- SweetAlert2 -->
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script src="<?= media(); ?>/js/plugins/sweetalert2/swettalert.min.js" type="text/javascript"></script>
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?= media() ?>/js/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="<?= media() ?>/js/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="<?= media() ?>/js/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<!-- jQuery Knob Chart -->
<script src="<?= media() ?>/js/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?= media() ?>/js/plugins/moment/moment.min.js"></script>
<script src="<?= media() ?>/js/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?= media() ?>/js/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="<?= media() ?>/js/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?= media() ?>/js/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= media() ?>/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?= media() ?>/js/pages/dashboard.js"></script>

<script src="<?= media(); ?>/js/actions/<?= $data['page_functions_js'] ?>" type="text/javascript"></script>

<script>
    const base_url = "<?= base_url(); ?>";
    const smony = "<?= SMONEY; ?>";
</script>

</body>
</html>

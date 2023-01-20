<!-- jQuery -->
<script src="<?= media(); ?>/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= media(); ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= media(); ?>/dist/js/adminlte.min.js"></script>

<script src="<?= media(); ?>/plugins/sweetalert2/swettalert.min.js" type="text/javascript"></script>

<script src="<?= media(); ?>/dist/js/actions/<?= $data['page_functions_js'] ?>" type="text/javascript"></script>
<script>
    const base_url = "<?= base_url(); ?>";
    const smony = "<?= SMONEY; ?>";
</script>
</body>
</html>
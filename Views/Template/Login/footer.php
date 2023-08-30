<!-- jQuery -->
<script src="<?= media(); ?>/js/plugins/jquery/jquery.min.js"></script>
<!-- Vue Js -->
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= media(); ?>/js/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= media(); ?>/js/adminlte.min.js"></script>

<script src="<?= media(); ?>/js/plugins/sweetalert2/swettalert.min.js" type="text/javascript"></script>

<script src="<?= media(); ?>/js/actions/<?= $data['page_functions_js'] ?>" type="text/javascript"></script>
<script>
    const base_url = "<?= base_url(); ?>";
    const smony = "<?= SMONEY; ?>";
</script>
</body>
</html>
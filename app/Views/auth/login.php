<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login Admin</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="<?= base_url('css/login-styles.css') ?>">
</head>
<body>

<h2>Login Admin</h2>
<form method="post" action="<?= base_url('/auth/login') ?>">
  <input type="text" name="username" placeholder="Username" required><br><br>
  <input type="password" name="password" placeholder="Password" required><br><br>
  <button type="submit">Login</button>
</form>

<?php if (session()->getFlashdata('success')): ?>
  <script>
    Swal.fire('Berhasil!', '<?= session()->getFlashdata('success') ?>', 'success');
  </script>
<?php elseif (session()->getFlashdata('error')): ?>
  <script>
    Swal.fire('Gagal!', '<?= session()->getFlashdata('error') ?>', 'error');
  </script>
<?php endif; ?>

</body>
</html>

<?php
include "../koneksi/koneksi.php";
if (isset($_POST['masuk'])) {
    $user = mysqli_real_escape_string($koneksi, $_POST['user']);
    $password = md5($_POST['password']);
    if ($user and $password != "") {
        $user = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$user' AND password='$password'");
        $cek_user = mysqli_num_rows($user);
        $data_user = mysqli_fetch_assoc($user);
        if ($cek_user > 0) {
            session_start();
            $_SESSION['id_user'] = $data_user['id_user'];
            $_SESSION['username'] = $data_user['username'];
            $_SESSION['level'] = $data_user['level'];
            $_SESSION['login'] = true;
            header("location:login?Berhasil=login");
        } else {
            header("location:login?login=gagal");
        }
    } else {
        header("location:login?kesalahan=login");
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsip Fitrah Hanniah</title>
    <link rel="stylesheet" href="assets/css/bootstrap.css">

    <link rel="shortcut icon" href="assets/images/logo-arsip.jpg" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/app.css">
</head>

<body>
    <div id="auth">
        <div class="container">
            <div class="row">
                <div class="col-md-5 col-sm-12 mx-auto">
                    <div class="card pt-4">
                        <div class="card-body">
                            <div class="text-center">
                                <img style="width: 100%;" src="assets/images/sit.png" class='mb-4'>
                            </div>
                            <form action="" method="post">
                                <?php
                                if (isset($_GET['kesalahan']) == 'login') {
                                ?>
                                    <div class="alert alert-warning" role="alert">
                                        <p style="font-size: 12pt;"><strong>Kesalahan Login !!!</strong></p>
                                    </div>
                                <?php } ?>
                                <?php
                                if (isset($_GET['Berhasil']) == 'login') {
                                ?>
                                    <div class="alert alert-success" role="alert">
                                        <p style="font-size: 12pt;"><strong>Login Anda Berhasil</strong></p>
                                    </div>
                                    <script type="text/javascript">
                                        window.setTimeout(function() {
                                            window.location.replace('dashboard');
                                        }, 3000);
                                    </script>
                                <?php } ?>
                                <?php
                                if (isset($_GET['login']) == 'gagal') {
                                ?>
                                    <div class="alert alert-danger" role="alert">
                                        <p style="font-size: 12pt;"><strong>Username atau password salah !!!</strong></p>
                                    </div>
                                <?php } ?>
                                <div class="form-group position-relative has-icon-left">
                                    <label for="username">Username</label>
                                    <div class="position-relative">
                                        <input type="text" onfocus="this.value=''" placeholder="Username" class="form-control" autocomplete="off" autofocus="" id="user" name="user" required="required">
                                        <div class="form-control-icon">
                                            <i data-feather="user"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group position-relative has-icon-left">
                                    <div class="clearfix">
                                        <label for="password">Password</label>
                                    </div>
                                    <div class="position-relative">
                                        <input type="password" onfocus="this.value=''" placeholder="Password" class="form-control" autocomplete="off" id="password" name="password" required="required">
                                        <div class="form-control-icon">
                                            <i data-feather="lock"></i>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="clearfix">
                                    <button type="submit" style="font-size: 12pt;" class="btn btn-info float-end" name="masuk"><i data-feather="log-in"></i> Masuk</button>
                                </div>
                            </form>
                            <div class="divider">
                                <div class="divider-text"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/feather-icons/feather.min.js"></script>
    <script src="assets/js/app.js"></script>
    <script src="assets/js/main.js"></script>
    <script>
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 2000);
    </script>
</body>

</html>
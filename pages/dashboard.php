<?php 
session_start();
if ( !isset($_SESSION["login"]) ) {
    header("location: login");
}
include"../koneksi/koneksi.php";
$level=$_SESSION['level'];
$id_user=$_SESSION['id_user'];
if (isset($_POST['gantipass'])) {
    $Password_lama=md5($_POST['Password_lama']);
    $Password_baru=md5($_POST['Password_baru']);
    $cek_pass=mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM user WHERE id_user='$id_user' AND password='$Password_lama'"));
    if ($cek_pass > 0) {
        $update=mysqli_query($koneksi,"UPDATE user SET password='$Password_baru' WHERE id_user='$id_user'");
        echo "<script>window.alert('Password Anda Berhasil diganti !!!')
        window.location='dashboard'</script>";
    }else{
        echo "<script>window.alert('Ganti Password gagal !!!')
        window.location='dashboard'</script>";
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

    <link rel="stylesheet" href="assets/vendors/chartjs/Chart.min.css">

    <link rel="stylesheet" href="assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="shortcut icon" href="assets/images/logo-arsip.jpg" type="image/x-icon">
</head>

<body>
    <div id="app">
        <?php 
        require_once"../template/menu.php";
        ?>
        <div id="main">
            <?php 
            require_once"../template/sidebar.php";
            ?>

            <div class="main-content container-fluid">
                <div class="page-title">
                    <h3>Dashboard</h3>
                </div>
                <section class="section">
                    <div class="row mb-2">
                        <div class="col-12 col-md-4">
                            <div class="card card-statistic">
                                <div class="card-body p-0">
                                    <div class="d-flex flex-column">
                                        <div class='px-3 py-3 d-flex justify-content-between'>
                                            <h3 class='card-title'>Jenis Document</h3>
                                            <div class="card-right d-flex align-items-center">
                                                <p>
                                                    <?php 
                                                    $j=mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM jenis_document"));
                                                    echo "$j";
                                                    ?> 
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="card card-statistic">
                                <div class="card-body p-0">
                                    <div class="d-flex flex-column">
                                        <div class='px-3 py-3 d-flex justify-content-between'>
                                            <h3 class='card-title'>Document Administrasi</h3>
                                            <div class="card-right d-flex align-items-center">
                                                <p><?php 
                                                $a=mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM document"));
                                                echo "$a";
                                                ?> </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php 
                        if ($level=="Administratif") {
                         ?>
                         <div class="col-12 col-md-4">
                            <div class="card card-statistic">
                                <div class="card-body p-0">
                                    <div class="d-flex flex-column">
                                        <div class='px-3 py-3 d-flex justify-content-between'>
                                            <h3 class='card-title'>Pengguna</h3>
                                            <div class="card-right d-flex align-items-center">
                                                <p><?php 
                                                $u=mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM user"));
                                                echo "$u";
                                                ?> </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php 
                    if ($level=="user biasa") {
                       ?>
                       <div class="col-12 col-md-4">
                        <div class="card card-statistic">
                            <div class="card-body p-0">
                                <div class="d-flex flex-column">
                                    <div class='px-3 py-3 d-flex justify-content-between'>
                                        <h3 class='card-title'>Document Pribadi</h3>
                                        <div class="card-right d-flex align-items-center">
                                            <p><?php 
                                            $er=mysqli_num_rows(mysqli_query($koneksi,"SELECT * FROM document_pribadi WHERE id_user='$id_user'"));
                                            echo "$er";
                                            ?> </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class='card-heading p-1 pl-3'>Grafik Document Administrasi</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="document"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php 
require_once"../template/footer.php";
?>
</div>
</div>

<div class="modal fade text-left" id="gantipass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel160" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title white" id="myModalLabel160"><i data-feather="key"></i> Ganti Password</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form action="" method="post">
                <div class="modal-body">
                    <!-- content -->
                    <div class="form-group">
                        <label>Masukan Password Lama</label>
                        <input type="Password" name="Password_lama" class="form-control" placeholder="Password Lama" required="required">
                    </div>
                    <div class="form-group">
                        <label>Password baru Anda</label>
                        <input type="Password" name="Password_baru" class="form-control" placeholder="Password baru" required="required">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="submit" name="gantipass" class="btn btn-info ml-1">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Ok</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/feather-icons/feather.min.js"></script>
<script src="assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="assets/js/app.js"></script>
<script src="assets/vendors/chartjs/Chart.min.js"></script>
<!-- <script src="assets/vendors/apexcharts/apexcharts.min.js"></script> -->
<script src="assets/js/pages/dashboard.js"></script>
<script src="assets/js/highcharts.js"></script>
<script src="assets/js/highcharts-more.js"></script>
<script src="assets/js/highchart-setting.js"></script>
<script src="assets/js/main.js"></script>
<script>
    Highcharts.chart('document', {
        chart: {
            type: 'column'
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: ['Grafik']
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Jumlah'
            }
        },
        series: [
        <?php
        $sql = mysqli_query($koneksi,"SELECT * FROM jenis_document");
        while( $ret = mysqli_fetch_array( $sql) ){
            $id_jenis_document       =$ret['id_jenis_document'];
            $jenis_document = $ret['jenis_document'];

            $query_jumlah = mysqli_query($koneksi,"SELECT * FROM document WHERE id_jenis_document='$id_jenis_document' ");
            $data = mysqli_num_rows( $query_jumlah );

            ?>
            {
                name: '<?php echo $jenis_document; ?>',
                data: [<?php echo $data; ?>]
            },
            <?php 
        } 
        ?>
        ]
    });
</script>
</body>

</html>
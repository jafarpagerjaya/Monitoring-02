<?php session_start(); 
require '../../proces/koneksi.php'; 
if(($_SESSION['privilege']==TRUE) AND ($_SESSION['kode_la']=='PRD')){
require '../../class/pegawai.php';
require '../../class/bahan.php';
require '../../proces/lib.php';
$nip = $_SESSION['nip'];
$emp = Pegawai::getDetilPegawai($nip);
$class = classAkun($emp->online);
$status = statusAkun($emp->online);
if(isset($_SESSION['kode_bahan'])){
  $kode_bahan = $_SESSION['kode_bahan'];
}else{
  $kode_bahan = 'AK100';
}
$namaBulan = Bahan::getPeriodeStok($kode_bahan);
$stokBahan = new Bahan();
$stok = $stokBahan->bacaStokBahan6B($kode_bahan);
$ringkasanBahan = Bahan::getRingkasanBahan();
$dashboard = 'active';
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SIMON FP - Produksi</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="../../asset/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- Ionicons -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet">
    <!-- Theme style -->
    <link href="../../asset/dist/css/AdminLTE.min.css" rel="stylesheet">
    <!-- AdminLTE Skins -->
    <link href="../../asset/dist/css/skins/skin-purple.min.css" rel="stylesheet">
    <!-- Override style -->
    <link href="../../asset/dist/css/main.css" rel="stylesheet">
    <!-- DATA TABES -->
    <link href="../../asset/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <!--
  BODY TAG OPTIONS:
  =================
  |---------------------------------------------------------|
  | SKINS         | skin-purple                             |
  |---------------------------------------------------------|
  |LAYOUT OPTIONS | sidebar-mini                            |
  |---------------------------------------------------------|
  -->
  <body class="skin-purple sidebar-mini">
    <div class="wrapper">
    <?php include_once '../header.php'; ?>
    <?php include_once '../main-sidebar.php'; ?>
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>Halaman<small>Dashboard</small></h1>
          <ol class="breadcrumb">
            <li><a href="../../proces/system-priv.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
          </ol>
        </section>
        <!-- Main content -->
        <section class="content">
        <!-- Your Page Content Here -->

          <div class="row">
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3><?php echo $ringkasanBahan->jml_kb; ?></h3>
                  <p>Jumlah Bahan Mentah</p>
                </div>
                <div class="icon">
                  <i class="ion ion-ios-flask"></i>
                </div>
                <a href="bahanbaku.php" class="small-box-footer">Info lanjut <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3><?php echo $ringkasanBahan->jml_kb_aman; ?></h3>
                  <p>Jumlah Bahan Aman</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="bahanbaku.php" class="small-box-footer">Info lanjut <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3><?php echo $ringkasanBahan->jml_kb_taman; ?></h3>
                  <p>Jumlah Tidak Aman</p>
                </div>
                <div class="icon">
                  <i class="ion ion-android-warning"></i>
                </div>
                <a href="bahanbaku.php" class="small-box-footer">Info lanjut <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <h3><?php echo $ringkasanBahan->jml_kb_klaku; ?></h3>
                  <p>Jumlah Bahan Kurang Laku</p>
                </div>
                <div class="icon">
                  <i class="ion ion-podium"></i>
                </div>
                <a href="#" class="small-box-footer" data-toggle="modal" data-target="#myModalTBKL" >Info lanjut <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
          </div>

    	    <div class="row">
            <div class="col-md-12">
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Statistik Stok <?php echo $namaBulan->nama_bahan; ?></h3>
                  <div class="box-tools pull-right">
                    <div class="btn-group">
                      <button class="btn btn-box-tool dropdown-toggle" data-toggle="dropdown" aria-expanded="true"><i class="fa fa-wrench"></i></button>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="#" data-kb="<?php echo strtoupper($kode_bahan); ?>" data-toggle="modal" data-target="#modalBahanLain">Tampilkan Stok Lain</a></li>
                      </ul>
                    </div>
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <div class="box-body">
                  <div class="row">
                    <div class="col-md-8">
                      <p class="text-center">
                        <strong>Data Periode : <?php echo $namaBulan->enam_bln_lalu.' - ' .$namaBulan->satu_bln_lalu; ?></strong>
                      </p>
                      <div class="chart">
                        <!-- Sales Chart Canvas -->
                        <canvas id="chartBahanKeluar" style="height: 180px; width: 632px;" width="632" height="180"></canvas>
                      </div><!-- /.chart-responsive -->
                    </div><!-- /.col -->
                    <div class="col-md-4">
                      <p class="text-center">
                        <strong>Penjelasan</strong>
                      </p>
                      <div class="progress-group">
                        <span class="progress-text">Stok Akumulatif</span>
                        <span class="progress-number"></span>
                        <div class="progress sm">
                          <div class="progress-bar progress-bar-blue" style="width: 100%"></div>
                        </div>
                      </div><!-- /.progress-group -->
                      <div class="progress-group">
                        <span class="progress-text">Stok Keluar</span>
                        <span class="progress-number"></span>
                        <div class="progress sm">
                          <div class="progress-bar progress-bar-red" style="width: 100%"></div>
                        </div>
                      </div><!-- /.progress-group -->
                      <div class="progress-group">
                        <span class="progress-text">Stok Masuk</span>
                        <span class="progress-number"></span>
                        <div class="progress sm">
                          <div class="progress-bar progress-bar-green" style="width: 100%"></div>
                        </div>
                      </div><!-- /.progress-group -->
                      <div class="progress-group">
                        <span class="progress-text">Stok Sisa</span>
                        <span class="progress-number"></span>
                        <div class="progress sm">
                          <div class="progress-bar progress-bar-yellow" style="width: 100%"></div>
                        </div>
                      </div><!-- /.progress-group -->
                    </div><!-- /.col -->
                  </div><!-- /.row -->
                </div>
                <?php /*
                <div class="box-footer">
                  <div class="row">
                    <div class="col-sm-3 col-xs-6">
                      <div class="description-block border-right">
                        <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 17%</span>
                        <h5 class="description-header">$35,210.43</h5>
                        <span class="description-text">TOTAL REVENUE</span>
                      </div><!-- /.description-block -->
                    </div><!-- /.col -->
                    <div class="col-sm-3 col-xs-6">
                      <div class="description-block border-right">
                        <span class="description-percentage text-yellow"><i class="fa fa-caret-left"></i> 0%</span>
                        <h5 class="description-header">$10,390.90</h5>
                        <span class="description-text">TOTAL COST</span>
                      </div><!-- /.description-block -->
                    </div><!-- /.col -->
                    <div class="col-sm-3 col-xs-6">
                      <div class="description-block border-right">
                        <span class="description-percentage text-green"><i class="fa fa-caret-up"></i> 20%</span>
                        <h5 class="description-header">$24,813.53</h5>
                        <span class="description-text">TOTAL PROFIT</span>
                      </div><!-- /.description-block -->
                    </div><!-- /.col -->
                    <div class="col-sm-3 col-xs-6">
                      <div class="description-block">
                        <span class="description-percentage text-red"><i class="fa fa-caret-down"></i> 18%</span>
                        <h5 class="description-header">1200</h5>
                        <span class="description-text">GOAL COMPLETIONS</span>
                      </div><!-- /.description-block -->
                    </div>
                  </div><!-- /.row -->
                </div>
                */ ?>
              </div>
            </div>
          </div>

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
    <?php include_once '../footer.php'; ?>
    </div><!-- ./wrapper -->

  <!-- REQUIRED JS SCRIPTS -->

  <!-- jQuery 2.1.4 -->
  <script src="../../asset/plugins/jQuery/jQuery-2.1.4.min.js"></script>
  <!-- Bootstrap 3.3.2 JS -->
  <script src="../../asset/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
  <!-- AdminLTE App -->
  <script src="../../asset/dist/js/app.min.js" type="text/javascript"></script>
  <!-- ChartJS 1.0.1 -->
  <script src="../../asset/plugins/chartjs/Chart.min.js" type="text/javascript"></script>
  <!-- DATA TABES SCRIPT -->
  <script src="../../asset/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="../../asset/plugins/datatables/dataTables.bootstrap.min.js"></script>

  <script>
    $(document).ready(function(){
        // Show the Modal on load
        $("#myModal").modal("show");
        // Cari Bahan Lain
        $('#modalBahanLain').on('show.bs.modal', function (event) {
          var div = $(event.relatedTarget)
          var kode_bahan = div.data('kb')

          $(".kode_bahan").val(kode_bahan);
        });
    });
    $(function () {
      $("#info-klaku").dataTable();
    /* 
     -------
     ChartJS - Here we will create a few charts using ChartJS
     -------
    */

    //--------------
    //- LINE CHART -
    //--------------

    var lineChartCanvas = $("#chartBahanKeluar").get(0).getContext("2d");
    var lineChart = new Chart(lineChartCanvas);
           
    <?php
      $bulan = array();
      $jumlahm = array();
      $jumlahk = array();
      $sisa = array();
      $akumulatif = array();
      while($hasil = $stok->fetch_assoc()) {
        $bulan[] = $hasil['bulan'];
        $jumlahm[] = $hasil['jumlah_m'];
        $jumlahk[] = $hasil['jumlah_k'];
        $sisa[] = $hasil['sisa'];
        $akumulatif[] = $hasil['akumulatif'];
      }
    ?>
    var lineChartData = {
      labels : <?php echo json_encode($bulan) ?>,
    
      datasets: [
        {
          label: "Keluar",
          fillColor: "rgb(210, 214, 222)",
          strokeColor: "#DD4B39",
          pointColor: "#DD4B39",
          pointStrokeColor: "#c1c7d1",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgb(220,220,220)",
          data : <?php echo json_encode($jumlahk) ?>
        },
        {
          label: "Masuk",
          fillColor: "rgba(60,141,188,0.9)",
          strokeColor: "#00a65a",
          pointColor: "#00a65a",
          pointStrokeColor: "rgba(60,141,188,1)",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(60,141,188,1)",
          data : <?php echo json_encode($jumlahm) ?>
        },
        {
          label: "Total Stok",
          fillColor: "rgba(60,141,188,0.9)",
          strokeColor: "rgba(60,141,188,0.8)",
          pointColor: "#3b8bba",
          pointStrokeColor: "rgba(60,141,188,1)",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgb(220,220,220)",
          data : <?php echo json_encode($akumulatif) ?>
        },
        {
          label: "Sisa",
          fillColor: "rgb(210, 214, 222)",
          strokeColor: "#f39c12",
          pointColor: "#f39c12",
          pointStrokeColor: "#c1c7d1",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgb(220,220,220)",
          data: <?php echo json_encode($sisa) ?>
        }
      ]
    };
    

    var lineChartOptions = {
      //Boolean - If we should show the scale at all
      showScale: true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines: false,
      //String - Colour of the grid lines
      scaleGridLineColor: "rgba(0,0,0,.05)",
      //Number - Width of the grid lines
      scaleGridLineWidth: 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines: true,
      //Boolean - Whether the line is curved between points
      bezierCurve: true,
      //Number - Tension of the bezier curve between points
      bezierCurveTension: 0.3,
      //Boolean - Whether to show a dot for each point
      pointDot: false,
      //Number - Radius of each point dot in pixels
      pointDotRadius: 4,
      //Number - Pixel width of point dot stroke
      pointDotStrokeWidth: 1,
      //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
      pointHitDetectionRadius: 20,
      //Boolean - Whether to show a stroke for datasets
      datasetStroke: true,
      //Number - Pixel width of dataset stroke
      datasetStrokeWidth: 2,
      //Boolean - Whether to fill the dataset with a color
      datasetFill: true,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
      //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio: false,
      //Boolean - whether to make the chart responsive to window resizing
      responsive: true
    };

    // Create the line chart
    lineChartOptions.datasetFill = false;
    lineChart.Line(lineChartData, lineChartOptions);
});
  </script>

  <?php
    if(isset($_SESSION['pesan'])){
  ?>
  <!-- Modal -->
    <!-- Modal Pesan -->
    <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog modal-sm">
        
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Pesan</h4>
          </div>
          <div class="modal-body">
            <?php
                echo $_SESSION['pesan'];
                unset($_SESSION['pesan']);
            ?>
          </div>
        </div>
        
      </div>
    </div>
    <!-- End Modal Pesan -->
  <?php
    }
  ?>
    <!-- Modal Tabel Bahan Kurang Laku -->
    <div class="modal fade" id="myModalTBKL" role="dialog">
      <div class="modal-dialog modal-lg">
        
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"><span class="glyphicon glyphicon-info-sign"></span> Bahan Kurang Laku <span class="pull-right">Bulan <?php echo date('m/Y'); ?></span></h4>
          </div>
          <div class="modal-body">
            <table id="info-klaku" class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>KODE BAHAN</th>
                  <th>NAMA BAHAN</th>
                  <th>HARGA PL</th>
                  <th>STOK</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                  $bacaBahan = new Bahan();
                  $rowtbkl = $bacaBahan->bacaBahanKurangLaku();
                  while ($hasil = $rowtbkl->fetch_assoc()) {
                ?>
                <tr>
                  <td><?php echo inputFilter($hasil['kode_bahan']);?></td>
                  <td><?php echo inputFilter($hasil['nama_bahan']);?></td>
                  <td><?php echo inputFilter($hasil['harga_pl']);?></td>
                  <td><?php echo inputFilter($hasil['stok']);?></td>
                </tr>
                <?php
                  }
                  $rowtbkl->free();
                ?>
              </tbody>
              <tfoot>
                <tr>
                  <th>KODE BAHAN</th>
                  <th>NAMA BAHAN</th>
                  <th>HARGA PL</th>
                  <th>STOK</th>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
        
      </div>
    </div>
    <!-- End Modal Tabel Bahan Kurang Laku -->
    <!-- Modal Bahan Lain -->
    <div class="modal fade" id="modalBahanLain" role="dialog">
      <div class="modal-dialog modal-sm">
      <form name="" action="../../proces/bahan.php" method="POST">    
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"><span class="glyphicon glyphicon-file"></span> Form Tampil Grafik Data Bahan</h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="inputKB">Kode Bahan</label>
              <select name="kode_bahan" class="form-control kode_bahan" required>
                <?php 
                  $rowSCKB = $bacaBahan->dataBahan();
                  if($rowSCKB){
                    while($hasil = $rowSCKB->fetch_assoc()){ ?>
                      <option value="<?php echo $hasil['kode_bahan']; ?>"><?php echo strtoupper($hasil['nama_bahan']).' [' .strtoupper($hasil['kode_bahan']).']'; ?></option>
                <?php 
                    } 
                    $rowSCKB->free(); 
                  }
                ?>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" style="width: 75px;" class="btn btn-default btn-flat pull-left" data-dismiss="modal">Batal</button>
            <button type="submit" name="bhn_lain" style="width: 75px;" class="btn btn-primary btn-flat">Proses</button>
          </div>
        </div>
      </form>
      </div>
    </div>
    <!-- End Modal Bahan Lain -->
  <!-- End Modal -->

  </body>
</html>
<?php
}else{
  $_SESSION['pesan']='Anda belum memiliki hak akses';
  header("Location:../view/broken-page.php");
}

?>
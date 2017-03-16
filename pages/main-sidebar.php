<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">

    <!-- Sidebar user panel (optional) -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="../../asset/dist/img/default.jpg" class="img-circle" alt="User Image" />
      </div>
      <div class="pull-left info">
        <p><?php echo $emp->nama; ?></p>
        <!-- Status -->
        <a href="#"><i class="<?php echo $class; ?>"></i> <?php echo $status; ?></a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
      <li class="header">MAIN NAVIGATION</li>
      <!-- Optionally, you can add icons to the links -->
      <!-- Set job_id -->
      <?php $kode_la=$emp->kode_la; ?>
      <?php if ($kode_la=='MGR') { ?>
      <!-- menu MGR -->
      <li class="<?php echo $dashboard; ?>"><a href="../../proces/system-priv.php"><i class='fa fa-dashboard'></i> <span>Dashboard</span></a></li>
      <li class="<?php echo $akun; ?>"><a href="../view/akun.php"><i class='fa fa-flag'></i> <span>Akun</span></a></li>
      <li class="<?php echo $pegawai; ?>"><a href="../manajer/pegawai.php"><i class='fa fa-group'></i> <span>Pegawai</span></a></li>
      <li class="treeview <?php echo $tree_laporan; ?>">
      <a href="#"><i class='fa fa-file'></i> <span>Kelola Laporan</span><i class="fa fa-angle-left pull-right"></i></a>
      <ul class="treeview-menu">
        <li class="<?php echo $l_transaksi; ?>"><a href="../manajer/lap-transaksi.php"><i class='fa fa-exchange'></i> <span>Data Transaksi</span></a></li>
        <li class="<?php echo $l_peramalan; ?>"><a href="../manajer/lap-peramalan.php"><i class='fa fa-server'></i> <span>Data Peramalan</span></a></li>
      </ul>
      </li>
      <li class="treeview <?php echo $tree_his; ?>">
      <a href="#"><i class='fa fa-clock-o'></i> <span>Kelola History</span><i class="fa fa-angle-left pull-right"></i></a>
      <ul class="treeview-menu">
        <li class="<?php echo $his_transaksi; ?>"><a href="../manajer/h-transaksi.php"><i class='fa fa-exchange'></i> <span>Data Transaksi</span></a></li>
        <li class="<?php echo $his_peramalan; ?>"><a href="../manajer/h-peramalan.php"><i class='fa fa-server'></i> <span>Data Peramalan</span></a></li>
      </ul>
      </li>
      <!-- akhir menu MGR -->
      <?php
      }else if ($kode_la=='PRD') { ?>
      <!-- menu PRD -->
      <li class="<?php echo $dashboard; ?>"><a href="../../proces/system-priv.php"><i class='fa fa-dashboard'></i> <span>Dashboard</span></a></li>
      <li class="<?php echo $bahanbaku; ?>"><a href="../produksi/bahanbaku.php"><i class='fa fa-th-large'></i> <span>Bahan Baku</span></a></li>
      <li class="<?php echo $transaksi; ?>"><a href="../produksi/transaksibahan.php"><i class='fa fa-exchange'></i> <span>Transaksi</span></a></li>
      <!-- akhir menu PRD -->
      <?php
      }else if ($kode_la=='ADM') { ?>
      <!-- menu ADM -->
      <li class="<?php echo $dashboard; ?>"><a href="../../proces/system-priv.php"><i class='fa fa-dashboard'></i> <span>Dashboard</span></a></li>
      <li class="<?php echo $akun; ?>"><a href="../view/akun.php"><i class='fa fa-flag'></i> <span>Akun</span></a></li>
      <li class="<?php echo $transaksi_adm; ?>"><a href="../admin/transaksi-m.php"><i class='fa fa-exchange'></i> <span>Transaksi Master</span></a></li>
      <?php } ?>
      <!-- akhir menu ADM -->
    </ul><!-- /.sidebar-menu -->
  </section>
  <!-- /.sidebar -->
</aside>
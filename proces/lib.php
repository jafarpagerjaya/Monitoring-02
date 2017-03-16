<?php
  function classAkun($online){
  	if($online==1){ 
  	  $class = 'fa fa-circle text-success';
  	}else{
  	  $class = 'fa fa-circle text-muted';
  	}
  	return $class;
    }
  function statusAkun($online){
  	if($online==1){ 
  	  $status = 'Online';
  	}else{
  	  $status = 'Offline';
  	}
  	return $status;
    }
  // Security jika data di dalam tabel terdapat SSX seperti javascript <script>alert();</script> maka saat ditampilkan akan diubah menjadi string.
  function inputFilter($string){
  	return htmlspecialchars(trim($string), ENT_QUOTES, 'UTF-8');
  }
  function classModal($string){
  	if(strlen($string)>100){
  	  $ukuran = 'md';
  	}else{
  	  $ukuran = 'sm';
  	}
  	return $ukuran;
  }
  function sekarang(){
    date_default_timezone_set('Asia/Jakarta');
    return date('d/m/Y H:i:s');
  }
  function kirimEmailAktivasiAkun($email,$kode_aktivasi){
    require '../asset/plugins/PHPMailer/PHPMailerAutoload.php';
    $mail = new PHPMailer;

    $mail->isSMTP();                                   // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';                    // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                            // Enable SMTP authentication
    $mail->Username = 'fiestaparfum1@gmail.com';          // SMTP username
    $mail->Password = '1000parfum';                 // SMTP password
    $mail->SMTPSecure = 'tls';                         // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                 // TCP port to connect to

    $mail->setFrom('fiestaparfum1@gmail.com', 'Admin FP');
    $mail->addReplyTo('fiestaparfum1@gmail.com', 'Admin FP');
    $mail->addAddress($email);   // Add a recipient

    $mail->isHTML(true);  // Set email format to HTML

    $bodyContent = '<h2>Aktivasi</h2>';
    $bodyContent .= '<p>Kode Aktivasi = <b>'.$kode_aktivasi."</b></p>\r\n".
                    'Link Aktivasi'."\r\n\n".
                    'http://localhost/Monitoring/proces/auth.php?kode_aktivasi='.$kode_aktivasi;

    $mail->Subject = 'Kode Aktivasi Akun SIMON FP';
    $mail->Body    = $bodyContent;

    if(!$mail->send()) {
        $perngiriman = 'Email Gagal di kirim. Mailer Error: ' . $mail->ErrorInfo;
    } else {
        $perngiriman = 'Kode Berhasil di kirim '.sekarang();
    }

    return $perngiriman;
  }
  /*
  function kirimEmailAktivasiAkun($email,$kode_aktivasi){
    $kepada  = $email;
    $subject = 'Aktivasi Akun SIMON FP';
    $pesan   = 'Kode Aktivasi = '.$kode_aktivasi."\r\n".
               'Link Aktivasi'."\r\n".
                'http://www.simonfiesta.890m.com/proces/auth.php?kode_aktivasi='.$kode_aktivasi;
    $header  = 'FROM: fiestaparfum1@gmail.com'."\r\n";
    $sekarang = sekarang();

    $pengiriman = mail($kepada,$subject,$pesan,$header);
    if($pengiriman==TRUE){
      $pengiriman = 'Berhasil di kirim';
    }else{
      $kepada  = 'fiestaparfum1@gmail.com';
      $subject = 'Gagal Pengiriman Email Aktivasi';
      $pesan   = 'Kode Aktivasi = '.$kode_aktivasi.' gagal dikirim kepada '.$email.' pada pukul '.$sekarang;
      $header  = 'FROM: @gmail.com';
      $pengiriman = 'Gagal di kirim';
      mail($email,$subject,$pesan,$header);
    }
    return $pengiriman.' '.$sekarang;
  }
  */
  function kirimEmailReAktivasiAkun($email,$password,$kode_aktivasi){
    require '../asset/plugins/PHPMailer/PHPMailerAutoload.php';
    $mail = new PHPMailer;

    $mail->isSMTP();                                   // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';                    // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                            // Enable SMTP authentication
    $mail->Username = 'fiestaparfum1@gmail.com';          // SMTP username
    $mail->Password = '1000parfum';                 // SMTP password
    $mail->SMTPSecure = 'tls';                         // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                 // TCP port to connect to

    $mail->setFrom('fiestaparfum1@gmail.com', 'Admin FP');
    $mail->addReplyTo('fiestaparfum1@gmail.com', 'Admin FP');
    $mail->addAddress($email);   // Add a recipient

    $mail->isHTML(true);  // Set email format to HTML

    $bodyContent = '<h2>Re Aktivasi</h2>';
    $bodyContent .= '<p>Password Sementara = <b>'.$password."</b></p>\r\n".
                    'Kode Re Aktivasi = '.$kode_aktivasi."\r\n".
                    'Link  Re Aktivasi'."\r\n\n".
                    'http://localhost/Monitoring/proces/auth.php?kode_aktivasi='.$kode_aktivasi;

    $mail->Subject = 'Re Aktivasi Akun SIMON FP';
    $mail->Body    = $bodyContent;

    if(!$mail->send()) {
        $perngiriman = 'Password Sementara Gagal di kirim. Mailer Error: ' . $mail->ErrorInfo;
    } else {
        $perngiriman = 'Password Sementara Berhasil di kirim '.sekarang();
    }

    return $perngiriman;
  }
  /*
  function kirimEmailReAktivasiAkun($email,$password,$kode_aktivasi){
    $kepada  = $email;
    $subject = 'Re Aktivasi Akun SIMON FP';
    $pesan   = 'Password Sementara = '.$password."\r\n".
               'Kode Re Aktivasi = '.$kode_aktivasi."\r\n".
               'Link  Re Aktivasi'."\r\n".
                'http://www.simonfiesta.890m.com/proces/auth.php?kode_aktivasi='.$kode_aktivasi;
    $header  = 'FROM: fiestaparfum1@gmail.com'."\r\n";
    $sekarang = sekarang();

    $pengiriman = mail($kepada,$subject,$pesan,$header);
    if($pengiriman==TRUE){
      $pengiriman = 'Berhasil di kirim';
    }else{
      $kepada  = 'fiestaparfum1@gmail.com';
      $subject = 'Gagal Pengiriman Email Re Aktivasi';
      $pesan   = 'Kode Re Aktivasi = '.$kode_aktivasi.' gagal dikirim kepada '.$email.' pada pukul '.$sekarang;
      $header  = 'FROM: @gmail.com';
      $pengiriman = 'Gagal di kirim';
      mail($email,$subject,$pesan,$header);
    }
    return $pengiriman.' '.$sekarang;
  }
  */
  function kirimEmailLupaPassword($email,$password){
    require '../asset/plugins/PHPMailer/PHPMailerAutoload.php';
    $mail = new PHPMailer;

    $mail->isSMTP();                                   // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';                    // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                            // Enable SMTP authentication
    $mail->Username = 'fiestaparfum1@gmail.com';          // SMTP username
    $mail->Password = '1000parfum';                 // SMTP password
    $mail->SMTPSecure = 'tls';                         // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                 // TCP port to connect to

    $mail->setFrom('fiestaparfum1@gmail.com', 'Admin FP');
    $mail->addReplyTo('fiestaparfum1@gmail.com', 'Admin FP');
    $mail->addAddress($email);   // Add a recipient

    $mail->isHTML(true);  // Set email format to HTML

    $bodyContent = '<h2>Lupa Password</h2>';
    $bodyContent .= '<p>Password Sementara = <b>'.$password."</b></p>\r\n".
                    'Link  Login'."\r\n\n".
                    'http://localhost/Monitoring/index.php';

    $mail->Subject = 'Lupa Password Akun SIMON FP';
    $mail->Body    = $bodyContent;

    if(!$mail->send()) {
        $perngiriman = 'Password Sementara Gagal di kirim. Mailer Error: ' . $mail->ErrorInfo;
    } else {
        $perngiriman = 'Password Sementara Berhasil di kirim '.sekarang();
    }

    return $perngiriman;
  }
  /*
  function kirimEmailLupaPassword($email,$password){
    $kepada  = $email;
    $subject = 'Lupa Password';
    $pesan   = 'Password Sementara = '.$password."\r\n".
               'Kode Re Aktivasi = '.$kode_aktivasi."\r\n".
               'Link  Login'."\r\n".
                'http://www.simonfiesta.890m.com/index.php';
    $header  = 'FROM: fiestaparfum1@gmail.com'."\r\n";
    $sekarang = sekarang();

    $pengiriman = mail($kepada,$subject,$pesan,$header);
    if($pengiriman==TRUE){
      $pengiriman = 'Berhasil di kirim';
    }else{
      $kepada  = 'fiestaparfum1@gmail.com';
      $subject = 'Gagal Pengiriman Email Lupa Password';
      $pesan   = 'Email Pemohon = '.$email.' gagal dikirim kepada '.$email.' pada pukul '.$sekarang;
      $header  = 'FROM: @gmail.com';
      $pengiriman = 'Gagal di kirim';
      mail($email,$subject,$pesan,$header);
    }
    return $pengiriman.' '.$sekarang;
  }
  */
  // String kominasi acak huruf & angka
  function randSting(){
    $hasil = '';
    $chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
    $charArray = str_split($chars);
    for($i = 0; $i < 10; $i++){
      $randItem = array_rand($charArray);
      $hasil .= ''.$charArray[$randItem];
    }
    return strtoupper($hasil);
  }
  function preloader(){
    echo '<!-- Override style -->
          <link href="../asset/dist/css/main.css" rel="stylesheet">
          <div class="preload-wrapper">
            <div id="preloader">
             <span></span>
             <span></span>
             <span></span>
             <span></span>
            </div>
          </div>';
  }
  function preloader2(){
    echo '<div class="spinner-thecube">
            <div class="spinner-cube spinner-c1"></div>
            <div class="spinner-cube spinner-c2"></div>
            <div class="spinner-cube spinner-c4"></div>
            <div class="spinner-cube spinner-c3"></div>
          </div>';
  }
  function pegreplaceKontak($kontak){
    return preg_replace('/-/', '', $kontak);
  }
  function pegreplaceWSpace($string){
    return preg_replace('/\s\s+/', ' ', $string);
  }
  function pegreplaceRibuanRp($string){
    $string = preg_replace('/Rp. /', '', $string);
    return preg_replace('/\./', '', $string);
  }
  function pegreplaceRibuan($string){
    return preg_replace('/\./', '', $string);
  }
  /* Untuk datepicker */
  function cekLastDayOfMonth(){
    $lastDayOfMonth = date('t/m/Y');
    $sekarang = date('d/m/Y');
    if($sekarang==$lastDayOfMonth){
      return '"+0m",';
    }else{
      return '"-1m",';
    }
  }
  function setStartDate($startDate){
    return '"-'.$startDate.'m"';
  }
  /* Akhir datepicker */
  /* Sementara di tutup
  function checked($aktive){
    if($aktive=='1'){
      return 'checked';
    }
  }
  */
  /* Akun */
  function classBgAkunStatus($status){
    if($status=='1'){
      return 'green';
    }else if($status=='0'){
      return 'yellow';
    }else{
      return 'red';
    }
  }
  function classIconAkunStatus($status){
    if($status=='1'){
      return 'ok';
    }else if($status=='0'){
      return 'alert';
    }else{
      return 'remove';
    }
  }
  function akunStatus($status){
    if($status=='1'){
      return 'Sudah Aktif';
    }else if($status=='0'){
      return 'Belum Aktif';
    }else{
      return 'Akun Diblok';
    }
  }
  function classBtnAkunStatus($status){
    if($status=='1'){
      return 'danger';
    }else if($status=='0'){
      return 'success';
    }else{
      return 'primary';
    }
  }
  function tooltipAkunStatus($status){
    if($status=='1'){
      return 'Blok Akun';
    }else if($status=='0'){
      return 'Aktifkan';
    }else{
      return 'Unblok Akun';
    }
  }
  function setAksiAkun($status){
    if($status=='1'){
      return 'menutup';
    }else if($status=='0'){
      return 'mengaktifkan';
    }else{
      return 'membuka';
    }
  }
  function setIdAktive($status){
    if($status=='mengaktifkan'){
      return '1';
    }else if($status=='membuka'){
      return '0';
    }else{
      return NULL;
    }
  }
  function setPesanAktive($status){
    if($status=='membuka'){
      return 'dibuka';
    }else if($status=='mengaktifkan'){
      return 'diaktifkan';
    }else{
      return 'ditutup';
    }
  }
  /* Akhir Akun */
  /* Transaksi */
  function laporanStatus($status){
    if($status=='B'){
      return 'Belum Disahkan';
    }else{
      return 'Sudah Disahkan';
    }
  }
  function classBgLaporanStatus($status){
    if($status=='B'){
      return 'yellow';
    }else{
      return 'green';
    }
  }
  function classIconLaporanStatus($status){
    if($status=='B'){
      return 'alert';
    }else{
      return 'ok';
    }
  }
  function getModalByLA($KLA){
    if($KLA=='PRD'){
      return '#myModalSimpanLaporan';
    }else{
      return '#myModalUSLT';
    }
  }
  function getButtonTextByLA($KLA){
    if($KLA=='PRD'){
      return 'Simpan Laporan Transaksi';
    }else{
      return 'Sahkan Laporan';
    }
  }
  function classCekStatusLT($status){
    if(($status=='B') OR ($status=='')){
      return '';
    }else{
      return 'hidden';
    }
  }
  function setTglTransaksi($jenis_transaksi){
    if($jenis_transaksi=='M'){
      return '01';
    }else{
      return '28';
    }
  }
  /* Akhir Transaksi */
  /* Peramalan */
  function classCekKLA($KLA){
    if($KLA=='PRD'){
      return '';
    }else{
      return 'hidden';
    }
  }
  /* Akhir Peramalan */
  function classLabelStatPengadaan($status){
    if($status=='Belum Dilakukan'){
      return 'danger';
    }else{
      return 'primary';
    }
  }
?>
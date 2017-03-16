<?php 
  
  class Pegawai{

    public static function getDetilPegawai($nip){
      global $db;
      $query = "SELECT a.online, a.nip, CONCAT_WS(' ',a.nama_depan,a.nama_belakang) as nama, a.email, a.terupdate, a.kontak, b.kode_la, b.nama_la
                FROM petugas a LEFT JOIN level_akses b
                ON(a.kode_la = b.kode_la)
                WHERE a.nip = $nip";
      $hasil = $db->query($query);
      if($hasil->num_rows == 1){
        $data = $hasil->fetch_object();
        return $data;
      }else{
        return false;
      }
      $db->close();
    }

    public function dataPegawai(){
      global $db;
      $query = "SELECT a.nip, a.nama_depan, a.nama_belakang, a.email, a.kontak, a.kode_la, b.nama_la, date_format(a.terupdate,'%d-%m-%Y %T') terupdate
                FROM petugas a LEFT JOIN level_akses b 
                ON(a.kode_la = b.kode_la)";
      $hasil = $db->query($query);
      if($hasil->num_rows > 0){
        return $hasil;
      }else{
        return false;
      }
      $hasil->free();
      $db->close();
    }

    public static function getNipSelanjutnya(){
      global $db;
      $stmt = $db->prepare("SELECT LPAD((COUNT(nip)+1),10,'0') seqNip FROM petugas;");
      $stmt->execute();
      if(!$stmt){
        return FALSE;
      }else{
        $stmt->bind_result($seqNip);
        $stmt->fetch();
        return $seqNip;
      }
      $stmt->close();
      $db->close();
    }

    public function tambahPegawai($nip,$nama_depan,$nama_belakang,$email,$kontak,$kode_la){
      global $db;
      $nip           = $db->real_escape_string($nip);
      $nama_depan    = $db->real_escape_string($nama_depan);
      $nama_belakang = $db->real_escape_string($nama_belakang);
      $email         = $db->real_escape_string($email);
      $kontak        = $db->real_escape_string($kontak);
      $kode_la       = $db->real_escape_string($kode_la);
      $stmt = $db->prepare("INSERT INTO petugas(nip,nama_depan,nama_belakang,email,kontak,kode_la) VALUES(?,?,?,?,?,?)");
      $stmt->bind_param('ssssss', $nip,$nama_depan,$nama_belakang,$email,$kontak,$kode_la);
      $stmt->execute();

      if($stmt->affected_rows==0){
        return $_SESSION['pesan'] = 'Data petugas dengan <b>nama</b> <label class="text-primary">'.$nama_depan.'</label> gagal disimpan';
      }else{
        return $_SESSION['pesan'] = 'Data petugas dengan <b>NIP</b> <label class="text-primary">'.$nip.'</label> telah berhasil simpan';
      }
      $stmt->close();
      $db->close();
    }

    public function cekUbahPegawai($pk,$kode_la){
      if(($pk==$_SESSION['nip']) AND ($kode_la!=$_SESSION['kode_la'])){
        $_SESSION['pesan'] = 'Jabatan NIP <label class="text-primary">'.$pk.'</label> Untuk saat ini tidak bisa diubah';
        return FALSE;
      }else{
        $_SESSION['pesan'] = 'Data NIP <label class="text-primary">'.$pk.'</label> Berhasil diubah';
        return TRUE;
      }
    }

    public function ubahPegawai($nama_depan,$nama_belakang,$email,$kontak,$kode_la,$nip){
      global $db;
      $nip           = $db->real_escape_string($nip);
      $nama_depan    = $db->real_escape_string($nama_depan);
      $nama_belakang = $db->real_escape_string($nama_belakang);
      $email         = $db->real_escape_string($email);
      $kontak        = $db->real_escape_string($kontak);
      $kode_la  = $db->real_escape_string($kode_la);
      $stmt = $db->prepare("UPDATE petugas SET nama_depan = ?,nama_belakang = ?,email = ?,kontak = ?,kode_la = ? WHERE nip = ?");
      $stmt->bind_param('ssssss', $nama_depan,$nama_belakang,$email,$kontak,$kode_la,$nip);
      $stmt->execute();

      $stmt->close();
      $db->close();
    }

    public function cekHapusPegawai($pk){
      if($pk==$_SESSION['nip']){
        $_SESSION['pesan'] = 'NIP <label class="text-primary">'.$pk.'</label> Untuk saat ini tidak bisa dihapus';
        return FALSE;
      }else{
        $_SESSION['pesan'] = '<label class="text-primary">'.$pk.'</label> Berhasil dihapus';
        return TRUE;
      }
    }

    public function hapusPegawai($nip){
      global $db;
      $nip = $db->real_escape_string($nip);
      $stmt = $db->prepare("DELETE FROM petugas WHERE nip = ?");
      $stmt->bind_param('s', $nip);
      $stmt->execute();

      $stmt->close();
      $db->close();
    }

  }
 
?>
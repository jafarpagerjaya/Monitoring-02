<?php
  class bahan{

    public static function getPeriodeStok($kode_bahan){
      global $db;
      $kode_bahan = $db->real_escape_string($kode_bahan);
      $query = "SELECT DISTINCT(bm.kode_bahan),bm.nama_bahan,(
                                                              SELECT DISTINCT(DATE_FORMAT(tgl_transaksi,'%b %Y'))
                                                              FROM transaksi_bahan
                                                              WHERE kode_bahan = '$kode_bahan' AND tgl_transaksi BETWEEN DATE_SUB(NOW(), INTERVAL 6 MONTH) AND NOW()
                                                              ORDER BY year(tgl_transaksi) ASC, month(tgl_transaksi) ASC LIMIT 1
                                                             ) enam_bln_lalu,
                                                             (
                                                              SELECT DATE_FORMAT(SUBDATE(NOW(),INTERVAL 1 MONTH),'%b %Y')
                                                             ) satu_bln_lalu
                FROM bahan_mentah bm JOIN transaksi_bahan tb
                ON(bm.kode_bahan = tb.kode_bahan)
                WHERE tb.kode_bahan = '$kode_bahan'";
      $hasil = $db->query($query);
      if($hasil->num_rows == 1){
        $data = $hasil->fetch_object();
        return $data;
      }else{
        return false;
      }
      $hasil->free();
      $db->close(); 
    }

    public function bacaStokBahan6B($kode_bahan){
      global $db;
      $kode_bahan = $db->real_escape_string($kode_bahan);
      $stmt = $db->prepare("SELECT b.bulan bulan, SUM(b.jumlah_m) jumlah_m,SUM(b.jumlah_k) jumlah_k,(SUM(b.jumlah_m)-SUM(b.jumlah_k))+(sisa-SUM(b.jumlah_m)) sisa, b.sisa akumulatif
                            FROM (SELECT a.bulan,
                              CASE WHEN a.jenis_transaksi = 'M' THEN a.jumlah ELSE 0 END jumlah_m,
                              CASE WHEN a.jenis_transaksi = 'K' THEN a.jumlah ELSE 0 END jumlah_k, a.sisa
                                  FROM (SELECT date_format(tgl_transaksi,'%m/%Y') bulan, jenis_transaksi, jumlah, sisa
                                        FROM transaksi_bahan
                                        WHERE kode_bahan = ? 
                                        AND STR_TO_DATE(DATE_FORMAT(tgl_transaksi,'%Y-%m'),'%Y-%m') 
                                        BETWEEN STR_TO_DATE(DATE_FORMAT(SUBDATE(NOW(), INTERVAL 6 MONTH),'%Y-%m'),'%Y-%m') AND STR_TO_DATE(DATE_FORMAT(SUBDATE(NOW(), INTERVAL 1 MONTH),'%Y-%m'),'%Y-%m')
                                 ) a
                                 ) b
                            GROUP BY b.bulan
                            ORDER BY YEAR(STR_TO_DATE(b.bulan,'%m/%Y')),MONTH(STR_TO_DATE(b.bulan,'%m/%Y'))");
      $stmt->bind_param('s', $kode_bahan);
      $stmt->execute();
      if(!$stmt){
        return FALSE;
      }else{
        return $stmt->get_result();
      }
      $stmt->close();
      $db->close(); 
    }

    public function setIdLaporan(){
      global $db;
      $stmt = $db->prepare("SELECT (COUNT(*)+1) id_laporan, 'NULL' c2 FROM laporan");
      $stmt->execute();
      if(!$stmt){
        return FALSE;
      }else{
        $stmt->bind_result($id_laporan,$c2);
        $stmt->fetch();
        return $stmt->get_result();
      }
      $stmt->close();
      $db->close(); 
    }

    public function simpanLaporanTB($bln){
      global $db;
      $bln  = $db->real_escape_string($bln);
      $call = $db->prepare("Call laporan_transaksi_bulanan(?, @opesan)");
      $call->execute();
      $call->bind_param('s', $bln);
      $call->execute();
      
      $select = $db->query("SELECT @opesan");
      $hasil = $select->fetch_assoc();
      $_SESSION['pesan'] = $hasil['@opesan'];
      if(isset($_SESSION['pesan'])){
        return TRUE;
      }else{
        return FALSE;
      }
      $call->close();
      $db->close();
    }

    public function bacaLaporanTransaksi($bln){
      global $db;
      $bln  = $db->real_escape_string($bln);
      $stmt = $db->prepare("SELECT b.kode_bahan,c.nama_bahan,b.bulan,SUM(b.jumlah_m) jumlah_m,SUM(b.jumlah_k) jumlah_k,b.akumulatif-SUM(jumlah_k) sisa,b.akumulatif
                            FROM (
                                  SELECT a.kode_bahan,a.bulan,CASE WHEN a.jenis_transaksi = 'M' THEN a.jumlah ELSE 0 END jumlah_m,
                                                              CASE WHEN a.jenis_transaksi = 'K' THEN a.jumlah ELSE 0 END jumlah_k,a.akumulatif
                                  FROM (
                                        SELECT kode_bahan,jenis_transaksi,jumlah,date_format(tgl_transaksi,'%m/%Y') bulan,sisa akumulatif
                                        FROM transaksi_bahan
                                  WHERE date_format(tgl_transaksi,'%b %Y') = ?
                                       ) a
                                 ) b JOIN bahan_mentah c
                            ON(b.kode_bahan = c.kode_bahan)
                            GROUP BY b.kode_bahan
                            ORDER BY b.kode_bahan ASC");
      $stmt->bind_param('s', $bln);
      $stmt->execute();
      if(!$stmt){
        return FALSE;
      }else{
        return $stmt->get_result();
      }
      $stmt->close();
      $db->close(); 
    }

    public function getBulanTransaksi(){
      global $db;
      $stmt = $db->prepare("SELECT DISTINCT(date_format(tgl_transaksi,'%b %Y')) bln
                            FROM transaksi_bahan
                            WHERE id_laporan IS NULL
                            ORDER BY YEAR(tgl_transaksi) ASC, MONTH(tgl_transaksi) ASC");
      $stmt->execute();
      if(!$stmt){
        return FALSE;
      }else{
        return $stmt->get_result();
      }
      $stmt->close();
      $db->close(); 
    }

    public static function getRingkasanBahan(){
      global $db;
      $query = "SELECT COUNT(c.kode_bahan) jml_kb, SUM(c.jml_kb_aman) jml_kb_aman, SUM(c.jml_kb_taman) jml_kb_taman, SUM(kb_klaku) jml_kb_klaku
                FROM (SELECT b.kode_bahan,
                       CASE WHEN b.stok > b.stok_aman THEN 1 ELSE 0 END jml_kb_aman,
                       CASE WHEN b.stok <= b.stok_aman THEN 1 ELSE 0 END jml_kb_taman,
                       CASE WHEN b.kode_bahan NOT IN (SELECT kode_bahan
                                                      FROM transaksi_bahan
                                                      WHERE tgl_transaksi = month(NOW())) THEN 1 ELSE 0 END kb_klaku
                FROM (SELECT kode_bahan, stok, stok_aman
                      FROM bahan_mentah) b
                     ) c;";
      $hasil = $db->query($query);
      if($hasil->num_rows == 1){
        $data = $hasil->fetch_object();
        return $data;
      }else{
        return FALSE;
      }
      $hasil->free();
      $db->close(); 
    }

    public function bacaBahanKurangLaku(){
      global $db;
      $stmt = $db->prepare("SELECT kode_bahan, nama_bahan, harga_pl, stok, stok_aman
                            FROM bahan_mentah
                            WHERE kode_bahan NOT IN (
                                   SELECT kode_bahan
                                   FROM transaksi_bahan
                                   WHERE tgl_transaksi = month(NOW())
                                  )");
      $stmt->execute();
      if(!$stmt){
        return FALSE;
      }else{
        return $stmt->get_result();
      }
      $stmt->close();
      $db->close(); 
    }

    public function bacaTransaksi(){
      global $db;
      $query = "SELECT id_transaksi,kode_bahan,jenis_transaksi,jumlah,sisa,date_format(tgl_transaksi,'%d/%m/%Y') tgl_transaksi 
                FROM transaksi_bahan
                ORDER BY id_transaksi DESC";
      $hasil = $db->query($query);
      if($hasil->num_rows > 0){
        return $hasil;
      }else{
        return false;
      }
      $hasil->free();
      $db->close();
    }

    public function tambahTransaksiMasuk($kode_bahan,$jumlah){
      global $db;
      $kode_bahan = $db->real_escape_string($kode_bahan);
      $jumlah     = $db->real_escape_string($jumlah);
      $call = $db->prepare("CALL transaksi_masuk(?, ?, @opesan)");
      $call->bind_param('si', $kode_bahan,$jumlah);
      $call->execute();
      
      $select = $db->query("SELECT @opesan");
      $hasil = $select->fetch_assoc();
      $_SESSION['pesan'] = $hasil['@opesan'];
      if(isset($_SESSION['pesan'])){
        return TRUE;
      }else{
        return FALSE;
      }
      $call->close();
      $db->close();
    }

    public function tambahTransaksiKeluar($kode_bahan,$jumlah){
      global $db;
      $kode_bahan = $db->real_escape_string($kode_bahan);
      $jumlah     = $db->real_escape_string($jumlah);
      $call = $db->prepare("CALL transaksi_keluar(?, ?, @opesan)");
      $call->bind_param('si', $kode_bahan,$jumlah);
      $call->execute();
      
      $select = $db->query("SELECT @opesan");
      $hasil = $select->fetch_assoc();
      $_SESSION['pesan'] = $hasil['@opesan'];
      if(isset($_SESSION['pesan'])){
        return TRUE;
      }else{
        return FALSE;
      }
      $call->close();
      $db->close();
    }

    public function dataBahan(){
      global $db;
      $query = "SELECT kode_bahan,UPPER(nama_bahan) nama_bahan,FORMAT(harga_pl,0,'id_ID') harga_pl,stok,stok_aman,CASE WHEN stok <= stok_aman THEN 'Tidak Aman' ELSE 'Aman' END as 'status stok',date_format(terupdate,'%T %d/%m/%Y') terupdate
                FROM bahan_mentah";
      $hasil = $db->query($query);
      if($hasil->num_rows > 0){
        return $hasil;
      }else{
        return false;
      }
      $hasil->free();
      $db->close();
    }

    public function dataBahanRamal(){
      global $db;
      $query = "SELECT kode_bahan,UPPER(nama_bahan) nama_bahan
                FROM bahan_mentah
                WHERE kode_bahan NOT IN (SELECT dp.kode_bahan
                                         FROM detil_peramalan dp JOIN peramalan pr
                                         ON(dp.id_peramalan = pr.id_peramalan)
                                         WHERE pr.status_pengadaan = 'B')";
      $hasil = $db->query($query);
      if($hasil->num_rows > 0){
        return $hasil;
      }else{
        return false;
      }
      $hasil->free();
      $db->close();
    }

    public static function getKodeBahan(){
      global $db;
      $stmt = $db->prepare("SELECT kode_bahan
                            FROM bahan_mentah
                            WHERE kode_bahan NOT IN (SELECT dp.kode_bahan
                                                     FROM detil_peramalan dp JOIN peramalan pr
                                                     ON(dp.id_peramalan = pr.id_peramalan)
                                                     WHERE pr.status_pengadaan = 'B')
                            ORDER BY kode_bahan ASC LIMIT 1");
      $stmt->execute();
      if(!$stmt){
        return FALSE;
      }else{
        $stmt->bind_result($kode_bahan);
        $stmt->fetch();
        return $kode_bahan;
      }
      $stmt->close();
      $db->close();
    }

    public function tambahBahan($kode_bahan,$nama_bahan,$harga_pl){
      global $db;
      $kode_bahan = $db->real_escape_string($kode_bahan);
      $nama_bahan = $db->real_escape_string($nama_bahan);
      $harga_pl   = $db->real_escape_string($harga_pl);
      $stmt = $db->prepare("INSERT INTO bahan_mentah(kode_bahan,nama_bahan,harga_pl) VALUES(UPPER(?),?,?)");
      $stmt->bind_param('ssi', $kode_bahan,$nama_bahan,$harga_pl);
      $stmt->execute();
      if($stmt->affected_rows==0){
        return $_SESSION['pesan'] = 'Data bahan parfum dengan <b>KODE</b> <label class="text-primary">'.$kode_bahan.'</label> gagal ditambahkan';
      }else{
        return $_SESSION['pesan'] = 'Data bahan parfum dengan <b>KODE</b> <label class="text-primary">'.$kode_bahan.'</label> telah berhasil ditambahkan';
      }
      $stmt->close();
      $db->close();
    }

    public function ubahBahan($kode_bahan,$nama_bahan,$harga_pl){
      global $db;
      $kode_bahan = $db->real_escape_string($kode_bahan);
      $nama_bahan = $db->real_escape_string($nama_bahan);
      $harga_pl   = $db->real_escape_string($harga_pl);
      $stmt = $db->prepare("UPDATE bahan_mentah SET nama_bahan = ?,harga_pl = ? WHERE kode_bahan = ?");
      $stmt->bind_param('sis', $nama_bahan,$harga_pl,$kode_bahan);
      $stmt->execute();
      if($stmt->affected_rows==0){
        return $_SESSION['pesan'] = 'Data bahan parfum dengan <b>KODE</b> <label class="text-primary">'.$kode_bahan.'</label> tidak ditemukan';
      }else{
        return $_SESSION['pesan'] = 'Data bahan parfum dengan <b>KODE</b> <label class="text-primary">'.$kode_bahan.'</label> telah berhasil diubah';
      }
      $stmt->close();
      $db->close();
    }

    public function hapusBahan($kode_bahan){
      global $db;
      $kode_bahan = $db->real_escape_string($kode_bahan);
      $stmt = $db->prepare("DELETE FROM bahan_mentah WHERE kode_bahan = ?");
      $stmt->bind_param('s', $kode_bahan);
      $stmt->execute();
      if($stmt->affected_rows==0){
        return $_SESSION['pesan'] = 'Data bahan parfum dengan <b>KODE</b> <label class="text-primary">'.$kode_bahan.'</label> tidak ditemukan';
      }else{
        return $_SESSION['pesan'] = 'Data bahan parfum dengan <b>KODE</b> <label class="text-primary">'.$kode_bahan.'</label> telah berhasil dihapus';
      }
      $stmt->close();
      $db->close();
    }

  }
?>
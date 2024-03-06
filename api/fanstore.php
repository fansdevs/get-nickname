<?php
include('../config/setting.php');
$sql_5 = mysqli_query($conn,"SELECT * FROM `tb_tripayapi` WHERE cuid = 12") or die(mysqli_error());
$s5 = mysqli_fetch_array($sql_5);
$merchantCodes = $s5['merchant_code'];
$apiKey = $s5['api_key'];

date_default_timezone_set("Asia/Jakarta");
$date = date('H');
$created_date = date('Y-m-d');

if ($date == '00'){
$delete = mysqli_query($conn,"DELETE FROM `tb_produk` WHERE jenis = 12") or die(mysqli_error($conn));
$delete = mysqli_query($conn,"DELETE FROM `tb_produk_premium` WHERE jenis = 12") or die(mysqli_error($conn));
$delete = mysqli_query($conn,"DELETE FROM `tb_prepaid` WHERE jenis = 12") or die(mysqli_error($conn));
}

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://fanstore.site/api/services.php',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array(
      'api_key' => $apiKey.$api_key_fanstore,
      'type' => 'game-premium',
  ),
));
$response = curl_exec($curl);
curl_close($curl);
echo $response;
$hasil = json_decode($response, true);
for ($i=0; $i < count($hasil['data']); $i++) {
    $a = strlen($i);
    if($a == 1){
        $aa = '4000'.$i;
    }
    else if($a == 2){
        $aa = '400'.$i;
    }
    else if($a == 3){
        $aa = '40'.$i;
    }
    else if($a == 4){
        $aa = '4'.$i;
    }
    else if($a == 5){
        $aa = $i;
    }
    $code = $hasil['data'][$i]['code'];
    $game = $hasil['data'][$i]['kategori'];
    $slug = strtolower(preg_replace("/[^a-zA-Z0-9]/", "",$game));
    $image = strtolower(str_replace(' ','_',$game)).'.png';
    $title = str_replace(array( "’","'" ),"&apos;",$hasil['data'][$i]['title']);
    $hargaModal = $hasil['data'][$i]['harga'];
    $tipe_data = $hasil['data'][$i]['status'];
    
if($tipe_data == 'Tersedia'){
// Get Produk Game
if($game != 'Canva Pro' && $game != 'Disney Hotstar' && $game != 'Garena Shell Murah' && $game != 'iQIYI Premium' && $game != 'Netflix Premium' && $game != 'Spotify Premium' && $game != 'Vidio Premier' && $game != 'WeTV Premium' && $game != 'Youtube Premium'){
$getAdmin = mysqli_query($conn,"SELECT * FROM `tb_admin` WHERE cuid = 1") or die(mysqli_error());
$ga = mysqli_fetch_array($getAdmin);
$persen_sell = $ga['persen_sell'];
$persen_res = $ga['persen_res'];
$satuan = $ga['satuan'];
if($satuan == 0){
$hargaJual = round(($hargaModal*$persen_sell) / 100);
$harga_jual = $hargaModal + $hargaJual;
$hargaRes =  round(($hargaModal*$persen_res) / 100);
$harga_reseller = $hargaModal + $hargaRes;
}
else {
$harga_jual = $hargaModal + $persen_sell;
$harga_reseller = $hargaModal + $persen_res;
}

$cekProduk = mysqli_query($conn,"SELECT * FROM `tb_produk` WHERE code = '$code' AND title = '$title'") or die(mysqli_error($conn));
$cp = mysqli_num_rows($cekProduk);
if($cp == 0){
$insert = mysqli_query($conn,"INSERT INTO `tb_produk` (`cuid`, `slug`, `code`, `title`, `kategori`, `harga_modal`, `harga_jual`, `harga_reseller`, `image`, `currency`, `status`, `created_date`, `jenis`, `product_type`) VALUES ('', '$slug', '$code', '$title', '$game', '$hargaModal', '$harga_jual', '$harga_reseller', '$image', '', 1, '$created_date', 12, 1)") or die(mysqli_error($conn));
}
else if($cp != 0){
$update = mysqli_query($conn,"UPDATE `tb_produk` SET `code` = '$code', `title` = '$title', `kategori` = '$game', `harga_modal` = '$hargaModal', `harga_jual` = '$harga_jual', `harga_reseller` = '$harga_reseller' WHERE code = '$code'") or die(mysqli_error($conn));
 }
 }
 // Get Produk Premium
else if($game == 'Canva Pro' || $game == 'Disney Hotstar' || $game == 'Garena Shell Murah' || $game == 'iQIYI Premium' || $game == 'Netflix Premium' || $game == 'Spotify Premium' || $game == 'Vidio Premier' || $game == 'WeTV Premium' || $game == 'Youtube Premium'){
$getAdmin = mysqli_query($conn,"SELECT * FROM `tb_admin` WHERE cuid = 3") or die(mysqli_error());
$ga = mysqli_fetch_array($getAdmin);
$persen_sell = $ga['persen_sell'];
$persen_res = $ga['persen_res'];
$satuan = $ga['satuan'];
if($satuan == 0){
$hargaJual = round(($hargaModal*$persen_sell) / 100);
$harga_jual = $hargaModal + $hargaJual;
$hargaRes =  round(($hargaModal*$persen_res) / 100);
$harga_reseller = $hargaModal + $hargaRes;
}
else {
$harga_jual = $hargaModal + $persen_sell;
$harga_reseller = $hargaModal + $persen_res;
}

$cekProduk = mysqli_query($conn,"SELECT * FROM `tb_produk_premium` WHERE code = '$code' AND title = '$title'") or die(mysqli_error($conn));
$cp = mysqli_num_rows($cekProduk);
if($cp == 0){
$insert = mysqli_query($conn,"INSERT INTO `tb_produk_premium` (`cuid`, `slug`, `code`, `title`, `kategori`, `harga_modal`, `harga_jual`, `harga_reseller`, `image`, `currency`, `status`, `created_date`, `jenis`, `product_type`) VALUES ('', '$slug', '$code', '$title', '$game', '$hargaModal', '$harga_jual', '$harga_reseller', '$image', '', 1, '$created_date', 12, 1)") or die(mysqli_error($conn));
}
else if($cp != 0){
$update = mysqli_query($conn,"UPDATE `tb_produk_premium` SET `code` = '$code', `title` = '$title', `kategori` = '$game', `harga_modal` = '$hargaModal', `harga_jual` = '$harga_jual', `harga_reseller` = '$harga_reseller' WHERE code = '$code'") or die(mysqli_error($conn));
}
}
}
else {
$delete = mysqli_query($conn,"DELETE FROM `tb_produk` WHERE code = '$code'") or die(mysqli_error($conn));
$delete = mysqli_query($conn,"DELETE FROM `tb_produk_premium` WHERE code = '$code'") or die(mysqli_error($conn));
}
}
?>
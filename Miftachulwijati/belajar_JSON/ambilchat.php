<?php
$con = mysqli_connect("localhost","root","", "webchat");

if (isset($_GET['nama'])){
    $nama = $_GET['nama'];
}

if (isset($_GET['pesan'])){
    $pesan = $_GET['pesan'];
}

$waktu = date("H:i");

if (isset($_GET['akhir'])){
    @$akhir = $_GET['akhir'];
}


$json = '{"messages": {';
    if(@$akhir==0){
        $nomor = mysqli_query($con, "select nomor from drzchat order by nomor desc limit 1");
        $n = mysqli_fetch_array($nomor);
        $no = $n['nomor'] + 1;

        $json .= '"pesan":[ {';
        $json .= '"id":"'.$no.'",
        "nama": "Admin",
        "teks": "Selamat datang di chatting room",
        "waktu": "'.$waktu.'"
        }]';

        $masuk = mysqli_query($con, "insert into drzchat values(null, 'Admin', $nama bergabung dalam chat', '$waktu')");
    } else {
        if($pesan){
            $masuk = mysqli_query($con, "insert into drzchat values(null, '$nama','$pesan','$waktu')");
        }

        $query = mysqli_query($con, "select * from drzchat where nomor > $akhir");
        $json .= '"pesan":[ ';
        while($x = mysqli_fetch_array($query)) {
            $json .= '{';
            $json .= '"id": "' . $x['nomor'] . '",
            "nama": "' . htmlspecialchars($x['nama']) . '",
            "teks": "' . htmlspecialchars($x['pesan']) . '",
            "waktu": "' . $x['waktu'] . '"
            },';
    }
    $json = substr($json,0,strlen($json)-1);
    $json .= ']'; 
}

    $json .= '}}';
    echo $json;

?>
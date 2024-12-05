<?php

$host    = "WAPII";
$connInfo = array("Database" => "STDSYS", "UID" => "", "PWD" => "");
$conn = sqlsrv_connect($host, $connInfo);

if ($conn) {
    echo "Koneksi berhasil. <br/>";
} else {
    echo "Koneksi gagal";
    die(print_r(sqlsrv_errors(), true));
}
?>
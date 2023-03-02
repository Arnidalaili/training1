<?php
    include('../../db.php');

    function get_structure()
    {
        $field = ['Invoice', 'Nama', 'Tgl', 'Jeniskelamin', 'Saldo'];
    }

    function jenisKelamin()
    {
        $jeniskelamin = $_GET('Jeniskelamin');
    }
?>
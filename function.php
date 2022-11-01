<?php

function multiple($sql){
    global $db;

    $sorgu = $db->prepare($sql);
    $sorgu->execute();
    $liste = $sorgu->fetchAll(PDO::FETCH_ASSOC);

    return $liste;
}

function single($tablo,$sutun,$id){
    global $db;

    $sorgu = $db->prepare("SELECT * FROM $tablo WHERE $sutun='$id' ");
    $sorgu->execute();
    $liste = $sorgu->fetch(PDO::FETCH_ASSOC);

    return $liste;
}
?>
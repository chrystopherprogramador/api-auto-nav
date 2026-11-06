<?php


$caminhobd = realpath("C:\Samos\motel.mdb");



try{

    if(!file_exists($caminhobd)){
        die("Arquivo do banco nao encontrado!");
    }else{
        $bd = new PDO("odbc:DRIVER={Microsoft Access Driver (*.mdb, *.accdb)}; DBQ=$caminhobd; Uid=Admin; Pwd=;");
    }
} catch (Exception $e){
    echo "Error: " . $e->getMessage();
}


?>
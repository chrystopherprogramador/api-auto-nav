<?php


    include("conect_banco.php");





    $result_msg_cont = "SELECT * FROM SUITES WHERE NUMERO=16";


try{

    $resultado_msg_cont = $bd->prepare($result_msg_cont);
    $resultado_msg_cont->execute();

	while ($row_msg_cont = $resultado_msg_cont->fetch(PDO::FETCH_ASSOC)) {
		$status = $row_msg_cont['situacao'];
		$limpeza = $row_msg_cont['limpeza'];
	}

    
        

    $resultadopainel = "";
	

    if($status == "D"){
        $resultadopainel = "LIVRE";
    }
	if($status == "O"){
        $resultadopainel = "OCUPADA";
    }
	if($status == "C"){
        $resultadopainel = "OCUPADA";
    }
	if($status == "L" and $limpeza == true){
        $resultadopainel = "LIMPEZA";
    }
	if($status == "M"){
        $resultadopainel = "MANUTENCAO";
    }
	if($limpeza == false and $status == "L"){
        $resultadopainel = "SUJA";
    }
	
    date_default_timezone_set('America/Sao_Paulo');
    $dataatual = date("Y") . "-" . date("m") . "-" . date("d") . "T" . date("H") . ":" . date("i") . ":" . date("s");

	$array = Array (
"success" => true,
"message" => "OK",
"data" => [Array (
    "status" => "$resultadopainel",
    "current" => "$dataatual"
)] 
);

	$json = $array;
    $bd = null;
    echo json_encode($json);

} catch (Exception $e){
    echo "Error: " . $e->getMessage();
}

?>
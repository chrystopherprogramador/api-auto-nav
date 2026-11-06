<?php


    include("conect_banco.php");



    @$suite = $_GET['suite'];


    $result_msg_cont = "SELECT * FROM SUITES WHERE NUMERO=$suite";


try{

    $resultado_msg_cont = $bd->prepare($result_msg_cont);
    $resultado_msg_cont->execute();

	while ($row_msg_cont = $resultado_msg_cont->fetch(PDO::FETCH_ASSOC)) {
		$status = $row_msg_cont['situacao'];
		$limpeza = $row_msg_cont['limpeza'];
	}

    
        

    $resultadopainel = "";
	

    if ($status == "D"){
        $resultadopainel = "LIVRE";
    }elseif ($status = "L"){
        $resultadopainel = "LIMPEZA";
    }elseif ($status = "O"){
        $resultadopainel = "OCUPADO";
    }elseif ($status = "M"){
        $resultadopainel = "MANUTENCAO";
    }elseif ($limpeza = false){
        $resultadopainel = "SUJA";
    }

    $dataatual = date(DATE_ATOM, mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y")));


    echo json_encode("
    
        {
            sucess: true,
            message: 'OK',
                data[
                    {
                        status: '$resultadopainel',
                        current: '$dataatual'
                    }
                ]
        }
    
    
    ");

} catch (Exception $e){
    echo "Error: " . $e->getMessage();
}

?>
<?php


    include("conect_banco.php");

try{
	
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	$post = file_get_contents('php://input');

	$post = json_decode($post,true);
	
	
	
	
	@$suite = "999";
	
	@$request = $post['requests'];
	

	$data = date("d") . "/" . date("m") . "/" . date("Y") ;
	$hora = date("H") . ":" . date("i") . ":" . date("s");
	
    $result_msg_cont = "INSERT INTO PEDIDOS (SUITE,DATA,HORA,STATUS) VALUES ('$suite','$data','$hora','RECEBIDO')";

    $resultado_msg_cont = $bd->prepare($result_msg_cont);
    $resultado_msg_cont->execute();


	if (!empty($request)){
		

	foreach($request as $item) {
		$codigo = $item['code'];
		$quantidade = $item['quantity'];
		
			if($quantidade == 0){
			$quantidade = 1;
		}

		$strSql = "SELECT * FROM itens WHERE codigo = $codigo";
		
		 $resultado_msg_cont = $bd->prepare($strSql);
		 $resultado_msg_cont->execute();
		 $row_msg_cont = $resultado_msg_cont->fetch(PDO::FETCH_ASSOC);
		 $descricao = $row_msg_cont['descricao'];
		
		$strSql = "SELECT * FROM Pedidos ORDER BY Id DESC";
		
		 $resultado_msg_cont = $bd->prepare($strSql);
		 $resultado_msg_cont->execute();
		 $row_msg_cont = $resultado_msg_cont->fetch(PDO::FETCH_ASSOC);
		 $ultlancamento = $row_msg_cont['Id'];
		 	
		
		 $strSql = "INSERT INTO MovPedido (Mov,Data,hora,suite,prod,prodesc,qnt) values 
			('$ultlancamento','$data','$hora','$suite','$codigo','$descricao','$quantidade')";
		
		
		 $resultado_msg_cont = $bd->prepare($strSql);
		 $resultado_msg_cont->execute();
		
	}

	}
	
	$array = Array(
		"success" => true,
		"message" => "OK",
		"data" => []
	);
	$bd = null;
	echo json_encode($array);



	
}else{
 


	$array = array(
	"id" => 0,
	"status" => "ABERTA",
	"checkin" => "2022-12-14T15:30:00",
	"forecast" => "2022-12-14T15:30:00",
	"service" => 405,
	"consumption" => 200,
	"discount" => 0,
	"paid" => 200,
	"period" => "04:00:00");
	$bd = null;
	echo json_encode($array);
 
}
} catch (Exception $e){
    
}

?>
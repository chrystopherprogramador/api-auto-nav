<?php


    include("conect_banco.php");





    $result_msg_cont = "SELECT ITENS.CODIGO AS CODITEM,
						ITENS.VALOR AS PRECO, ITENS.DESCRICAO AS NOME, ITENS.ESPECIE AS CATEGORIA
							 FROM ITENS";


try{

    $resultado_msg_cont = $bd->prepare($result_msg_cont);
    $resultado_msg_cont->execute();

	$array = "{
			\"sucess\": true,
			\"message\": \"OK\",
			\"data\":[
		
		
		";

	$x = 0;

while ($row_msg_cont = $resultado_msg_cont->fetch(PDO::FETCH_ASSOC)) {
		$codigo = $row_msg_cont['CODITEM'];
		$preco = $row_msg_cont['PRECO'];
		$nome = $row_msg_cont['NOME'];
		$categoria = $row_msg_cont['CATEGORIA'];


		$array = $array . "
		
		{
		\"code\": $codigo,
		\"name\": \"$nome\",
		\"group\": \"$categoria\",
		\"price\": $preco,
		\"unity\": \"UN\",
		\"stock_id\": 11,
		\"stock_quantity\": 999,
		\"maximum_sale_quantity\": 9,
		\"kit\": false,
		\"origins_available\":[2],
		\"variation\": []
		},";

}	 

	$array = substr($array,0,-1);
	
	$array = $array . "]}";

	echo $array;
 

} catch (Exception $e){
    echo "Error: " . $e->getMessage();
}

?>
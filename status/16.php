<?php
include("conect_banco.php");

try {
    // Verifica se a conexão foi estabelecida corretamente
    if (!isset($bd)) {
        throw new Exception("Erro: Conexão com o banco de dados não estabelecida.");
    }

    // Consulta para buscar a suíte número 7
    $result_msg_cont = "SELECT * FROM SUITES WHERE NUMERO=16";
    $resultado_msg_cont = $bd->prepare($result_msg_cont);
    $resultado_msg_cont->execute();

    $status = null;
    $limpeza = null;

    // Busca os resultados
    while ($row_msg_cont = $resultado_msg_cont->fetch(PDO::FETCH_ASSOC)) {
        $status = $row_msg_cont['situacao'];
        $limpeza = $row_msg_cont['limpeza'];
    }

    // Define o status do painel com base nos resultados
    $resultadopainel = "";

    if ($status === "D") {
        $resultadopainel = "LIVRE";
    } elseif (in_array($status, ["O", "C"])) {
        $resultadopainel = "OCUPADA";
    } elseif ($status === "L" && $limpeza) {
        $resultadopainel = "LIMPEZA";
    } elseif ($status === "M") {
        $resultadopainel = "MANUTENCAO";
    } elseif ($status === "L" && !$limpeza) {
        $resultadopainel = "SUJA";
    }

    // Define o fuso horário e a data atual
    date_default_timezone_set('America/Sao_Paulo');
    $dataatual = date("Y-m-d\TH:i:s");

    // Cria o array de resposta
    $array = [
        "success" => true,
        "message" => "OK",
        "data" => [
            [
                "status" => $resultadopainel,
                "current" => $dataatual
            ]
        ]
    ];

    // Fecha a conexão
    $bd = null;

    // Retorna a resposta em JSON
    echo json_encode($array);

} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => "Erro: " . $e->getMessage()
    ]);
}
?>

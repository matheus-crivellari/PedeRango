<?php
require_once '../conexao/conecta.php';

// Obtem o id do estado da URL
$estado_cod = $_GET['estado_cod'] ?? 0;

if($estado_cod){
    // SQL para obter somente as cidades do estado correspondente
    $sql = "SELECT * FROM tb_cidade WHERE estado_cod=$estado_cod";

    // Executa a query e obtem um resultado
    $resultado = mysqli_query($conexao, $sql);

    if($resultado){ // Se existir um resultado
        $cidades = []; // Cria um array vazio de cidades

        // Para cada linha de resultado do banco adiciona
        // uma linha no array cidades
        while($cidade = mysqli_fetch_assoc($resultado)){
            // Trata o nome da cidade com utf8_encode para não
            // impedir o json
            $cidade['nome'] = utf8_encode($cidade['nome']);
            $cidades[] = $cidade;
        }

        print json_encode($cidades);
    }else{
        print 'erro';
    }
}

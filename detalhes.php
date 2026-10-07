<?php

require_once './partials/header.php';

$host = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'db_docemaria';

$conn = new mysqli($host, $usuario, $senha, $banco);
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// 1. Obtém e valida o ID do produto primeiro
$id_produto = $_GET['id_produto'] ?? null;

if (!$id_produto) {
    header('Location: produtos.php');
    exit;
}

$id_produto_safe = $conn->real_escape_string($id_produto);

// 2. Consulta os dados do produto
$sql = "SELECT * FROM produtos WHERE id_produto = '$id_produto_safe'";
$resultado = $conn->query($sql);

if (!$resultado) {
    die("Erro na consulta SQL: " . $conn->error);
}

$produto = $resultado->fetch_assoc();
if (!$produto) {
    echo "<div style='text-align:center; padding: 50px;'>";
    echo "<h2>Produto não encontrado!</h2>";
    echo "<a href='produtos.php' style='color:#d1a07d;'>Voltar para a lista</a>";
    echo "</div>";
    exit;
}

// 3. Consulta a última avaliação específica deste produto
$sql_avaliacao = "SELECT * FROM avaliacoes WHERE produto_id = '$id_produto_safe' ORDER BY id DESC LIMIT 1";
$res_avaliacao = $conn->query($sql_avaliacao);
$avaliacao = $res_avaliacao ? $res_avaliacao->fetch_assoc() : null;

date_default_timezone_set('America/Sao_Paulo');

// Prepara a data caso exista uma avaliação
$dataHora = null;
if (!empty($avaliacao['data_avaliacao'])) {
    $dataHora = new DateTime($avaliacao['data_avaliacao']);
}

// Trata os valores da tabela produtos
$nome = $produto['nome_produto'] ?? 'Produto sem nome';
$preco = $produto['preco'] ?? 0;
$imagem = $produto['img_produto'] ?? 'cookie.png';
$descricao = $produto['descricao'] ?? 'Sem descrição disponível para este produto.';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($nome); ?> - Detalhes</title>
    <link rel="stylesheet" href="produtos.css">
    <style>
        .container-detalhes {
            max-width: 900px;
            margin: auto;
            margin-top: 130px;
            background: #ffffff;
            padding: 30px;
            border-radius: 15px;
            display: flex;
            gap: 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .detalhes-img {
            width: 300px;
            height: 300px;
            object-fit: cover;
            border-radius: 10px;
        }

        .detalhes-info {
            flex-grow: 1;
        }

        .btn-voltar {
            display: inline-block;
            margin-bottom: 20px;
            color: #d1a07d;
            text-decoration: none;
            font-weight: bold;
        }

        .btn-avaliar {
            background-color: #d1a07d;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 15px;
        }

        .btn-avaliar:hover {
            background-color: #b07a5a;
        }

        .container-avaliar {
            max-width: 900px;
            margin: 20px auto;
            background: #ffffff;
            padding: 50px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .box-avaliacoes {
            margin-top: 20px;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
        }
    </style>
</head>

<body>

    <main class="container-detalhes">
        <div class="detalhes-foto">
            <img src="./imagens/<?php echo htmlspecialchars($imagem); ?>" alt="<?php echo htmlspecialchars($nome); ?>"
                class="detalhes-img">
        </div>

        <div class="detalhes-info">
            <a href="produtos.php" class="btn-voltar">← Voltar para a lista</a>
            <h1><?php echo htmlspecialchars($nome); ?></h1>
            <h2 style="color: #d1a07d;">R$ <?php echo number_format((float) $preco, 2, ',', '.'); ?></h2>

            <p><strong>Descrição:</strong></p>
            <p><?php echo nl2br(htmlspecialchars($descricao)); ?></p>

            <button class="btn-compre" style="margin-top: 20px; padding: 10px 20px; font-size: 16px;">Adicionar ao
                Carrinho</button>
        </div>

    </main>

    <section class="container-avaliar">


        <h2>Avaliações</h2>
        <div class="box-avaliacoes">
            <?php
            if (!empty($avaliacao)):
                echo '
    <p>Cliente:' . $avaliacao['nome'] . '</p>';

                echo '
    <p>Data da Avaliação: ' . $dataHora->format('d/m/Y à\s H:i') . '</p>
    
    <p>Nota:' . $avaliacao['nota'] . '</p>
    <p>Texto da Avaliação:<br>' . $avaliacao['comentario'] . '</p>';
            else:
                echo '<p>Nenhuma avaliação encontrada.</p>';
            endif;
            ?>
    </div>
        <a h    ref="avaliar.php?id_produto=<?= $id_produto ?>&nome_produto=<?= $nome ?>">
                <button type="button" class="btn-avaliar">Avaliar</button>
</a>
        
    </section>

</body>

</html>
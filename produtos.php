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

$categoria_selecionada = $_GET['categoria'] ?? '';

if (!empty($categoria_selecionada)) {
    $categoria_safe = $conn->real_escape_string($categoria_selecionada);

    $sql = "SELECT * FROM produtos WHERE categoria = '$categoria_safe' ORDER BY nome_produto";
} else {

    $sql = "SELECT * FROM produtos ORDER BY nome_produto";
}

$resultado = $conn->query($sql);

session_start();
if (!isset($_SESSION['quantidade'])) {
    $_SESSION['quantidade'] = 1;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['acao'])) {
    if ($_POST['acao'] === 'mais') {
        $_SESSION['quantidade']++;
    } elseif ($_POST['acao'] === 'menos' && $_SESSION['quantidade'] > 1) {
        $_SESSION['quantidade']--;
    }
}

$novoValor = $_SESSION['quantidade'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Todos</title>
    <link rel="stylesheet" href="produtos.css">
</head>
<body>

    <main>
        <h1>Ver todos</h1>




        <div class="layout-conteudo">
            <aside class="sidebar-categorias">
                <h2>Categorias</h2>
                <form method="GET" action="" id="form-filtro">
                    <ul>
                        <?php 
                        $categorias = ['Brigadeiro', 'Brownies', 'Bolos', 'Cupcakes', 'Donuts', 'Macaron', 'Pirulitos'];
                        foreach ($categorias as $cat): 
                            $checked = ($categoria_selecionada === $cat) ? 'checked' : '';
                        ?>
                            <li>
                                <label>
                                    <input type="radio" name="categoria" value="<?php echo $cat; ?>" <?php echo $checked; ?> onchange="this.form.submit()">
                                    <?php echo $cat; ?>
                                </label>
                            </li>
                        <?php endforeach; ?>
                    </ul>

                    <?php if (!empty($categoria_selecionada)): ?>
                        <a href="produtos.php" style="display:inline-block; margin-top:10px; font-size:13px; color:#d9534f; text-decoration:none; font-weight:bold;">
                            ✕ Limpar filtro
                        </a>
                    <?php endif; ?>
                </form>
            </aside>

           
            <section class="grid-produtos">
                <?php 
                if ($resultado && $resultado->num_rows > 0) {
                    while ($produto = $resultado->fetch_assoc()) { 
                        // Tratamento de colunas com fallbacks
                        $nome   = $produto['nome_produto'] ?? $produto['nome'] ?? 'Produto';
                        $preco  = $produto['preco'] ?? 0;
                        $imagem = $produto['img_produto'] ?? $produto['imagem'] ?? 'cookie.png';
                ?>
                        <div class="card-produtos">
                            <img src="./imagens/<?php echo htmlspecialchars($imagem); ?>" alt="<?php echo htmlspecialchars($nome); ?>" class="img-produto">
                            
                            <!-- Nome -->
                            <p class="titulo-produto"><?php echo htmlspecialchars($nome); ?></p>
                            
                            <!-- Preço -->
                            <p class="preco-produto">R$ <?php echo number_format((float)$preco, 2, ',', '.'); ?></p>

                            <!-- Botões de Ação -->
                            <div class="acoes-card">
                                <a href="detalhes.php?id_produto=<?php echo $produto['id_produto']; ?>" class="btn-compre">Compre</a>
                                <div class="contador-qtd">
        <form method="POST" action="">
            <button type="submit" name="acao" value="menos" class="btn-menos">-</button>
            <span class="qtd-valor"><?php echo $novoValor; ?></span>
            <button type="submit" name="acao" value="mais" class="btn-mais">+</button>
        </form>
    </div>
                            </div>
                        </div>
                <?php 
                    }
                } else {
                    echo "<p>Nenhum produto encontrado.</p>";
                }
                ?>
            </section>
        </div>
    </main>


</body>
</html>

<?php
$host = 'localhost';
$dbname = 'db_docemaria';
$usuario = 'root';
$senha = '' or 'ABC123yxz'; // Deixe em branco se usar XAMPP/WAMP padrão

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Obtém e valida os parâmetros enviados via GET na URL
$id_produto_avaliado = $_GET['id_produto'] ?? '';
$nome_produto_avaliado = $_GET['nome_produto'] ?? $_GET['nome'] ?? '';

if (empty($id_produto_avaliado) || empty($nome_produto_avaliado)) {
    echo "Produto ou nome não especificado.";
    exit;
}

if (!isset($_SESSION['user_tipo'])) {
    ?>
    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/style.css">
        <link rel="icon" type="x-icon" href="uploads/Logo-LM.png">
        <title>Acesso Negado</title>
    </head>

    <body>
        <style>
            body {
                background-color: #f1f7fd;
                margin: 0;
                padding: 0;
                min-height: 99vh;
                display: flex;
                flex-direction: column;
            }
        </style>
        <?php require_once 'partials/header.php'; ?>

        <main
            style="display:flex; flex-direction:column; align-items:center; justify-content:center; height:60vh; gap:16px; text-align:center;">
            <img src="imagens/acesso_negado.png" alt="Acesso Negado" style="width:270px; max-width:90%;">
            <p style="color:#696969;">Você precisa estar logado para deixar uma avaliação.</p>
            <a href="login.php"
                style="background:#ffa5ab; color:#1a1a1a; padding:12px 24px; border-radius:8px; font-weight:600; text-decoration:none;">
                Fazer Login
            </a>
        </main>
    </body>

    </html>
    <?php
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/avaliar.css">
    <link rel="icon" type="x-icon" href="uploads/Logo-LM.png">
    <title>Enviar Avaliação</title>
    <link rel="stylesheet" href="./avaliar.css">

</head>

<body>
    <?php require_once 'partials/header.php'; ?>

    <main class="pagina-principal">
        <form action="./CRUD/insert.php" method="POST" class="avaliacao">
            <p>Digite o título</p>
            <input type="text" name="titulo" required>

            <p>Produto avaliado</p>
            <input type="text" name="nome_produto" value="  <?php echo htmlspecialchars($nome_produto_avaliado); ?>"
                required readonly>

            <p>Nota da Avaliação</p>
            <input type="number" name="nota" min="1" max="5" placeholder="  Entre 1 e 5" required>

            <p>Comentário sobre o produto</p>
            <textarea name="comentario" rows="5" required></textarea>

            <input type="hidden" name="id_produto" value="<?php echo htmlspecialchars($id_produto_avaliado); ?>">
            <input type="hidden" name="id_user" value="<?php echo htmlspecialchars($_SESSION['id_user'] ?? ''); ?>">
            <input type="hidden" name="nome_produto" value="<?php echo htmlspecialchars($nome_produto_avaliado); ?>">

            <button type="submit">Enviar Avaliação</button>
        </form>
    </main>
</body>

</html>
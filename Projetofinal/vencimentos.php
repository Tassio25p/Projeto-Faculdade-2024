<?php
session_start();
require "../Projetofinal/conectar.php";

// Verifica se o usuário está logado
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

// Obtém o ID do usuário logado
$user_id = $_SESSION['id'];

// Cadastro de vencimento
if (isset($_POST['cadastrar'])) {
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'];
    $vencimento = $_POST['vencimento'];

    // Inserção no banco de dados
    $sql = "INSERT INTO vencimentos (ven_descricao, ven_valor, ven_data, user_id) VALUES (?, ?, ?, ?)";
    $stmt = $conecta->prepare($sql);
    $stmt->execute([$descricao, $valor, $vencimento, $user_id]);
}

// Listagem de vencimentos do usuário logado
$sql = "SELECT * FROM vencimentos WHERE user_id = ?";
$data = $conecta->prepare($sql);
$data->execute([$user_id]);
$vencimentos = $data->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['deletar_vencimento'])) {
    $ven_cod = $_POST['ven_cod'];

    $sql = "DELETE FROM vencimentos WHERE ven_cod = ? AND user_id = ?";
    $data = $conecta->prepare($sql);

    if ($data->execute([$ven_cod, $user_id])) {
    } else {
        echo "<p style='color: red;'>Erro ao excluir vencimento.</p>";
    }
}


// Atualizar vencimento
if (isset($_POST['atualizar_vencimento'])) {
    $ven_cod = $_POST['ven_cod'];
    $ven_descricao = $_POST['ven_descricao'];
    $ven_valor = $_POST['ven_valor'];
    $ven_data = $_POST['ven_data'];

    $sql = "UPDATE vencimentos SET ven_descricao = ?, ven_valor = ?, ven_data = ? WHERE ven_cod = ? AND user_id = ?";
    $data = $conecta->prepare($sql);

    if ($data->execute([$ven_descricao, $ven_valor, $ven_data, $ven_cod, $user_id])) {
    } else {
        echo "<p style='color: red;'>Erro ao atualizar vencimento.</p>";
    }
}



?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vencimentos</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="painel.php">Home</a></li>
                <li><a href="perfil_de_usuario.php">Usuário</a></li>
                <li><a href="contas.php">Contas</a></li>
                <li><a href="vencimentos.php">Vencimentos</a></li>
                <li><a href="logout.php">Sair</a></li>
            </ul>
        </nav>
    </header>

    <h1>Vencimentos</h1>

    <!-- Formulário de Cadastro -->
    <form method="post">
        <input type="text" name="descricao" placeholder="Descrição" required>
        <input type="number" step="0.01" name="valor" placeholder="Valor" required>
        <input type="date" name="vencimento" required>
        <button type="submit" name="cadastrar">Cadastrar</button>
    </form>

    <!-- Listagem de Vencimentos -->
    <h2>Vencimentos Cadastrados</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Descrição</th>
                <th>Valor</th>
                <th>Data de Vencimento</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($vencimentos)) : ?>
                <?php foreach ($vencimentos as $vencimento) : ?>
                    <tr id="row-<?php echo htmlspecialchars($vencimento['ven_cod']); ?>">
                        <td><input type="text" id="descricao-<?php echo $vencimento['ven_cod']; ?>" value="<?php echo htmlspecialchars($vencimento['ven_descricao']); ?>" required></td>
                        <td><input type="number" id="valor-<?php echo $vencimento['ven_cod']; ?>" value="<?php echo htmlspecialchars($vencimento['ven_valor']); ?>" required></td>
                        <td><input type="date" id="data-<?php echo $vencimento['ven_cod']; ?>" value="<?php echo htmlspecialchars($vencimento['ven_data']); ?>" required></td>
                        <td>
                            <button type="button" onclick="updateVencimento(<?php echo $vencimento['ven_cod']; ?>)">Atualizar</button>
                            <button type="button" onclick="deleteVencimento(<?php echo $vencimento['ven_cod']; ?>)">Excluir</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="4">Nenhum vencimento cadastrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <script src="att.js"></script>

</body>

</html>
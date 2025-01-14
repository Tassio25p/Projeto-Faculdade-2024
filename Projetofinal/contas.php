<?php
session_start();
require "../Projetofinal/conectar.php";
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

// Verifica se o usuário está logado
if (!isset($_SESSION['id'])) {
    // Redireciona para login caso o usuário não esteja logado
    header('Location: login.php');
    exit();
}

// Define a variável de ID do usuário
$user_id = $_SESSION['id'];

// Cadastro de conta
if (isset($_POST['cadastrar'])) {
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'];
    $vencimento = $_POST['vencimento'];
    $tipopag = $_POST['tipopag'];

    // Inserção de nova conta
    $sql = "INSERT INTO contas (con_descricao, con_valor, con_vencimento, con_tipopag, user_id) VALUES (?, ?, ?, ?, ?)";
    $data = $conecta->prepare($sql);
    $data->execute([$descricao, $valor, $vencimento, $tipopag, $user_id]);
}

// Atualização de conta
if (isset($_POST['atualizar'])) {
    $con_cod = $_POST['con_cod'];
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'];
    $vencimento = $_POST['vencimento'];
    $tipopag = $_POST['tipopag'];

    // Atualiza a conta no banco de dados
    $sql = "UPDATE contas SET con_descricao = ?, con_valor = ?, con_vencimento = ?, con_tipopag = ? WHERE con_cod = ? AND user_id = ?";
    $data = $conecta->prepare($sql);
    $data->execute([$descricao, $valor, $vencimento, $tipopag, $con_cod, $user_id]);
}

// Exclusão de conta
if (isset($_POST['excluir'])) {
    $con_cod = $_POST['con_cod'];

    $sql = "DELETE FROM contas WHERE con_cod = ? AND user_id = ?";
    $data = $conecta->prepare($sql);
    $data->execute([$con_cod, $user_id]);
}

// Listagem de contas do usuário logado
$sql = "SELECT * FROM contas WHERE user_id = ?";
$data = $conecta->prepare($sql);
$data->execute([$user_id]);
$contas = $data->fetchAll(PDO::FETCH_ASSOC) ?? []; // Garantir que $contas seja um array
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Contas</title>
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <header>
        <nav>
            <ul>
                <li><a href="painel.php?id=<?php echo $user_id; ?>">Home</a></li>
                <li><a href="perfil_de_usuario.php?id=<?php echo $user_id; ?>">Usuário</a></li>
                <li><a href="contas.php?id=<?php echo $user_id; ?>">Contas</a></li>
                <li><a href="vencimentos.php?id=<?php echo $user_id; ?>">Vencimentos</a></li>
                <li><a href="logout.php">Sair</a></li>
            </ul>
        </nav>
    </header>

<div class="Salario">

<h1>

<input type="text" name="Dinheiro" placeholder="Dinheiro" required  required onblur="showAlert()">

</h1>
</div>


    <h2>Cadastrar Conta</h2>
    <form method="post">
        <input type="text" name="descricao" placeholder="Descrição" required>
        <input type="number" step="0.01" name="valor" placeholder="Valor" required>
        <input type="date" name="vencimento" required>
        <select name="tipopag" required>
            <option value="Cartão de Crédito">Cartão de Crédito</option>
            <option value="Cartão de Débito">Cartão de Débito</option>
            <option value="Dinheiro">Dinheiro</option>
            <option value="Boleto">Boleto</option>
        </select>
        <button type="submit" name="cadastrar">Cadastrar</button>
    </form>

    <h2>Contas Cadastradas</h2>
    <table border="1">
        <tr>
            <th>Descrição</th>
            <th>Valor</th>
            <th>Vencimento</th>
            <th>Tipo de Pagamento</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($contas as $conta): ?>
            <tr>
                <form method="post">
                    <input type="hidden" name="con_cod" value="<?php echo $conta['con_cod']; ?>">
                    <td><input type="text" name="descricao" value="<?php echo $conta['con_descricao']; ?>" required></td>
                    <td><input type="number" step="0.01" name="valor" value="<?php echo $conta['con_valor']; ?>" required></td>
                    <td><input type="date" name="vencimento" value="<?php echo $conta['con_vencimento']; ?>" required></td>
                    <td>
                        <select name="tipopag" required>
                            <option value="Cartão de Crédito" <?php if ($conta['con_tipopag'] == 'Cartão de Crédito') echo 'selected'; ?>>Cartão de Crédito</option>
                            <option value="Cartão de Débito" <?php if ($conta['con_tipopag'] == 'Cartão de Débito') echo 'selected'; ?>>Cartão de Débito</option>
                            <option value="Dinheiro" <?php if ($conta['con_tipopag'] == 'Dinheiro') echo 'selected'; ?>>Dinheiro</option>
                            <option value="Boleto" <?php if ($conta['con_tipopag'] == 'Boleto') echo 'selected'; ?>>Boleto</option>
                        </select>
                    </td>
                    <td>
                        <button type="button" onclick="updateItem(<?php echo $conta['con_cod']; ?>)">Atualizar</button>
                        <button type="button" onclick="confirmDelete(<?php echo $conta['con_cod']; ?>)">Excluir</button>

                    </td>
                </form>
            </tr>
        <?php endforeach; ?>
    </table>
    <script src="att.js"></script>
</body>

</html>
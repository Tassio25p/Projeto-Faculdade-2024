<?php
session_start();
require '../Projetofinal/conectar.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

// Acessa os dados do usuário logado
$user_id = $_SESSION['id'];
$user_name = $_SESSION['name'];
$user_email = $_SESSION['email'];

// Verifica se o formulário foi enviado para atualizar os dados
if (isset($_POST['atualizar'])) {
    $novo_nome = $_POST['user_name'];
    $novo_email = $_POST['user_email'];
    $nova_password = $_POST['user_password'];

    // Inicializa a string SQL com os campos a serem atualizados
    $sql = "UPDATE users SET user_name = '$novo_nome', user_email = '$novo_email'";

    if (!empty($nova_password)) {
        $nova_password = md5($nova_password);
        $sql .= ", user_password = '$nova_password'";
    }

    // Adiciona a condição para atualizar apenas o usuário logado
    $sql .= " WHERE user_id = $user_id";

    try {
        if ($conecta->exec($sql)) {
            $_SESSION['name'] = $novo_nome;
            $_SESSION['email'] = $novo_email;
            header("refresh:3;url=login.php");
        } else {
            echo "<div class='alert alert-danger'>Erro ao atualizar os dados!</div>";
        }
    } catch (PDOException $e) {
        echo "<div class='alert alert-danger'>Erro: " . $e->getMessage() . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Dados</title>
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

    <div class="container">
        <h1>Atualizar Dados do Usuário</h1>

        <form action="" method="POST">
            <div class="textfield">
                <label for="user_name">Nome</label>
                <input type="text" name="user_name" id="user_name" value="<?php echo $user_name; ?>" required>
            </div>

            <div class="textfield">
                <label for="user_email">Email</label>
                <input type="email" name="user_email" id="user_email" value="<?php echo $user_email; ?>" required>
            </div>

            <div class="textfield">
                <label for="user_password">Nova Senha</label>
                <input type="password" name="user_password" id="user_password" placeholder="Deixe em branco para não alterar">
            </div>

            <button onclick="updateUser()" type="submit" name="atualizar" value="atualizar" class="btn">Atualizar</button>
        </form>
    </div>
    <script src="att.js">  </script>
</body>

</html>
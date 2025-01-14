<?php
session_start();
require '../Projetofinal/conectar.php';
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);


if (isset($dados['atualizar'])) {
    unset($dados['atualizar']);
    $dados = array_values($dados);
    try {
        $sql = "UPDATE users SET user_name = ? , user_email = ?, user_password = ? WHERE user_id = ?";
        $data = $conecta->prepare($sql);
        $data->execute($dados);
        echo "<div class='alert alert-success'>Sucesso: usuario atualizado com sucesso</div>";
        header("refresh:3, url=listar_usuarios_adm.php");
    } catch (PDOException $erro) {
        echo "<div class='alert alert-error'>Erro: Não foi possível atualizar o usuario. Procure o admin!</div>";
    }
}

// Realizando o select a partir do ID enviado
$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if ($id) {  // Verifica se o ID é válido
    $select = $conecta->prepare("SELECT * FROM users WHERE user_id = ?");
    $select->execute([$id]);
    $res = $select->fetch(PDO::FETCH_ASSOC);
} else {
    $res = ['user_id' => ''];  // pega o id do usuario 
}
?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Usuário</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <h1>Atualizar Usuário</h1>

    <form method="POST" action="">

        <div class="name">
            <label for="user_name">Nome:</label>
            <input type="text" id="user_name" name="user_name" value="<?php echo ($res['user_name'] ?? ''); ?>" placeholder="Digite seu novo Nome" required><br><br>
        </div>
        <div class="email">
            <label for="user_email">E-mail:</label>
            <input type="email" id="user_email" name="user_email" value="<?php echo ($res['user_email'] ?? ''); ?>" placeholder="Digite seu novo E-mail" required><br><br>
        </div>
        <div class="password ">
            <label for="user_password">Senha:</label>
            <input type="password" id="user_password" name="user_password" placeholder="Digite a nova senha" required><br><br>
        </div>
        <input type="hidden" name="user_id" value="<?php echo ($res['user_id'] ?? ''); ?>">
        <button onclick="uptadeuser()" type="submit" name="atualizar" class="atualizar" id="atualizar">Atualizar</button>
    </form>
 
    <a href="listar_usuarios_adm.php">Voltar</a>
    <script src="att.js"> </script>
</body>

</html>
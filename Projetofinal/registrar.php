<?php
session_start();
require '../Projetofinal/conectar.php';  

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

// Verifica se o formulário foi enviado
if (isset($dados['cadastrar'])) {
    unset($dados['cadastrar']); // Remove o botão 'cadastrar' dos dados

    // Verifica se as senhas coincidem
    if ($dados['user_password'] !== $dados['ConfirmarSenha']) {
        echo "<div class='alert alert-danger'>As senhas não coincidem!</div>";
        exit();
    }

    // Criptografa a senha com MD5
    $user_password = md5($dados['user_password']);
    
    
    $user_nivel = 2;  // Definindo nível padrão (usuário comum)


    try {
        // Prepara a consulta SQL para inserir os dados
        $sql = "INSERT INTO users (user_name, user_email, user_password, user_nivel) 
                VALUES ('" . $dados['user_name'] . "', '" . $dados['user_email'] . "', '" . $user_password . "', $user_nivel)";
        
        // Executa a consulta SQL
        $conecta->exec($sql);

        // Exibe uma mensagem de sucesso e redireciona para o login
        header("refresh:3;url=login.php");  // Redireciona para a página de login após 3 segundos
    } catch (PDOException $erro) {
        // Exibe o erro caso a consulta falhe
        echo "<div class='alert alert-danger'>Erro: Não foi possível cadastrar. Detalhes: " . $erro->getMessage() . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar</title>
    <link rel="stylesheet" href="css/style.css">
</head> 

<body>
    <div class="main-register">
        <div class="left-register">
            <h1>Registre-se e<br>faça parte do nosso time</h1>
            <img src="../Projetofinal/css/familia.svg" class="left-register-image">
        </div>
        <form action="" method="POST">
            <div class="right-register">
                <div class="card-register">
                    <h1>Registrar</h1>
                    <div class="textfield">
                        <label for="user_name">Usuário</label>
                        <input type="text" name="user_name" id="user_name" placeholder="Usuário" required>
                    </div>
                    <div class="textfield">
                        <label for="user_email">Email</label>
                        <input type="email" name="user_email" id="user_email" placeholder="Email" required>
                    </div>
                    <div class="textfield">
                        <label for="user_password">Senha</label>
                        <input type="password" name="user_password" id="user_password" placeholder="Senha" required>
                    </div>
                    <div class="textfield">
                        <label for="ConfirmarSenha">Confirmar Senha</label>
                        <input type="password" name="ConfirmarSenha" id="ConfirmarSenha" placeholder="Confirmar Senha" required>
                    </div>

                    <button type="submit" class="btn-register" name="cadastrar" id="cadastrar" value="cadastrar" onclick="registerItem()">Registrar</button>
                    <div class="login-link">
                        <p>Já possui uma conta? <a href="login.php">Login</a></p>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="att.js">  </script>
</body>

</html>

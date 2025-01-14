<?php
session_start();
require '../Projetofinal/conectar.php';

// vai verificar se o formulario foi enviado usando o metod2 post no formulario 
if (isset($_POST['login'])) {

    $user_email = filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL); //valida para ver se realmente é um email que está entrando 
    $user_password = md5($_POST['user_password']);  // Criptografa a senha *resolver* nao está funcionando 

    // Verifica se o usuario colocou senha e emagil 
    if ($user_email && !empty($user_password)) {
        try {
            $sql = "SELECT * FROM users WHERE user_email = :user AND user_password = :password";
            $data = $conecta->prepare($sql);
            $data->execute([ 'user' =>$user_email, 'password' => $user_password]);
            $user = $data->fetch(PDO::FETCH_ASSOC);
            if ($user) {              
                // isso vai armazena os dados da sessão 
                $_SESSION['id'] = $user['user_id'];
                $_SESSION['name'] = $user['user_name'];
                $_SESSION['email'] = $user['user_email'];
                $_SESSION['nivel'] = $user['user_nivel'];

                header('Location: painel.php');
                exit();
            } else {
                echo "<div class='alert alert-danger'>E-mail ou senha incorretos!</div>";
            }
        } catch (PDOException $erro) {
            echo "<div class='alert alert-danger'>Erro: Não foi possível fazer login. Detalhes: " . $erro->getMessage() . "</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Por favor, preencha todos os campos corretamente.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="main-login">
        <div class="left-login">
            <h1>Bem-vindo de volta!</h1>
            <img src="../Projetofinal/css/familia.svg" class="left-login-image">
        </div>
        <form action="" method="POST">
            <div class="right-login">
                <div class="card-login">
                    <h1>Login</h1>
                    <div class="textfield">
                        <label for="user_email">Email</label>
                        <input type="email" name="user_email" id="user_email" placeholder="Email" required>
                    </div>
                    <div class="textfield">
                        <label for="user_password">Senha</label>
                        <input type="password" name="user_password" id="user_password" placeholder="Senha" required>
                    </div>
                    
                    <button type="button" id="togglePassword" class="toggle-password">👁️</button> 
                    <button type="submit" class="btn-login" name="login" value="login">Entrar</button>
                    <div class="register-link">
                        <p>Não tem uma conta? <a href="registrar.php">Registrar</a></p>
                    </div>
                </div>
            </div>
        </form>
    </div>
<script src="att.js" ></script>
</body>

</html>
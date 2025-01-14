<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}


// Acessa os dados do usuário logado
$user_id = $_SESSION['id'];

//pega de qual nivel será o usuario logado nivel admin ou nivel usuario comum
$user_nivel = $_SESSION['nivel'];
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel</title>
    <link rel="stylesheet" href="./css/style.css">
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
    <h1>Bem-vindo ao Sistema de Gestão de Contas e Vencimentos</h1>
    <p>Este sistema foi desenvolvido para auxiliar na organização e no controle de informações de usuários e suas finanças pessoais. Com ele, você pode realizar diversas ações, como:

        Cadastro de Usuários: Gerencie suas informações de login e mantenha seu perfil atualizado.
        Controle de Contas: Cadastre e visualize as contas a pagar, incluindo vencimentos e tipos de pagamento.
        Gestão de Vencimentos: Cadastre e acompanhe os vencimentos de contas, vinculando-os a um usuário específico para facilitar a organização financeira.
        Atualização e Exclusão de Dados: Permite que o usuário faça alterações em seus dados pessoais e na lista de vencimentos, sempre de forma segura e rápida.
        Este sistema é simples de usar, mas poderoso o suficiente para ajudá-lo a organizar e gerenciar seus compromissos financeiros e dados de usuário. Se você for um administrador, também terá acesso a funções extras, como a gestão de todos os usuários registrados e a atualização de dados importantes.
        Entre em sua conta, e comece a utilizar as funcionalidades para melhorar a organização e controle das suas finanças!</p>


    <div class="container">
        <?php if ($user_nivel == 1) { ?>
            <h2>Área administrativa</h2>
            <a href="listar_usuarios_adm.php">Lista de usuarios</a>
        <?php } else {
        } ?>

    </div>
<script src="att.js">  </script>
<div class="by">
<footer><p>BY FOR TÁSSIO HENRIQUE MARQUES XAVIER BRUSCHI RA:219394</p></footer>
</div>
</body>

</html>
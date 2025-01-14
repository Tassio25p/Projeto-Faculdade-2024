<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Usuário</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <?php
    require '../Projetofinal/conectar.php';
    $dados = $conecta->query("SELECT * FROM users");
    $dados = $dados->fetchAll(PDO::FETCH_ASSOC);
    ?>
    <h1>Listas de Usuários</h1>



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

    <div style="width: 80%; margin: 20px; text-align: right">
    </div>
    <table border="1" style="width: 80%; margin: auto; text-align: center;">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Senha</th>
                <th>Opções</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dados as $users) { ?>
                <tr>
                    <td><?php echo $users['user_name']; ?></td>
                    <td><?php echo $users['user_email']; ?></td>
                    <td><?php echo $users['user_password']; ?></td> <!-- Escondendo a senha por segurança -->
                    <td>
                        <a href="atualizar.php?id=<?php echo $users['user_id']; ?>" class="btn update">Atualizar</a>
                        <a href="deletar.php?id=<?php echo $users['user_id'] ?>" class="btn delete">Deletar</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>

</html>
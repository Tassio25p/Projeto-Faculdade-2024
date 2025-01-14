<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deletar</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <div class="container">
        <?php
        require "../Projetofinal/conectar.php";


        // Filtra o ID uma vez
        $id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

        if ($id) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                try {
                    // Prepara e executa o SQL com o ID
                    $sql = "DELETE FROM users WHERE user_id = ?";
                    $data = $conecta->prepare($sql);
                    $data->execute([$id]);
                    header("Refresh:2, url=listar_usuarios_adm.php");
                } catch (PDOException $error) {
                    echo "<div class='alert alert-error'>Erro: Não foi possível excluir o usuário, procure o admin!</div>";
                    header("Refresh:5, url=listar_usuarios_adm.php");
                }
            } else {
                // Busca os dados do usuário
                $res = $conecta->query("SELECT * FROM users WHERE user_id = $id");
                $res = $res->fetch(PDO::FETCH_ASSOC);
            }
        } else {
            echo "<div class='alert alert-error'>Erro: ID inválido.</div>";
        }
        ?>
        <form action="" method="post">
            <button type="submit" onclick="deleteUser()" type="submit" class="btn-delete" name="deletar" value="Deletar">Deletar</button>
             <button type="submit" href="listar_usuarios_adm.php" class="btn-update">Cancelar
        </form>
    

    </div>
<script src="att.js"></script>
</body>


</html>
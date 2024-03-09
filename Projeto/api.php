<?php

header("Content-Type: application/json");
include('connection.php');

if (isset($_GET['nome']) && isset($_GET['pass']) && isset($_GET['update']) && isset($_GET['isAdmin'])) {
    $nome = $_GET['nome'];
    $pass = $_GET['pass'];
    $admin = $_GET['isAdmin'];

    $query = "INSERT INTO users (userNome, userSenha, isAdmin) VALUES ('$nome', '$pass', '$admin')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $response = "Usuário adicionado com sucesso.";
    } else {
        $response = "Erro ao adicionar usuário.";
    }
} else {
    $query = "SELECT * FROM `users`";
    $result = mysqli_query($conn, $query);

    $response = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $response[] = $row;
    }
}if(isset($_GET['nome']) && isset($_GET['pass']) && isset($_GET['update']) && isset($_GET['procurar'])){
    $nome = $_GET['nome'];
    $pass = $_GET['pass'];

    $query = "SELECT * FROM users WHERE userNome = '$nome' AND userSenha = '$pass'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $isAdmin = $row['isAdmin']; // Valor da coluna isAdmin

        echo json_encode(array("success" => true, "isAdmin" => $isAdmin)); // Retorna um JSON indicando sucesso e o valor de isAdmin
    exit();
    } else {
        echo json_encode(array("success" => false)); // Retorne um JSON indicando sucesso
        exit();
    }
}
if (isset($_GET['id']) && isset($_GET['nome']) && isset($_GET['pass'])) {
    $id = $_GET['id'];
    $nome = $_GET['nome'];
    $pass = $_GET['pass'];

    // Verifica se os campos de nome e senha estão vazios
    if (empty($nome)) {
        $query = "SELECT userNome FROM users WHERE id = '$id'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $nome = $row['userNome'];
    }
    if (empty($pass)) {
        $query = "SELECT userSenha FROM users WHERE id = '$id'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $pass = $row['userSenha'];
    }

    $query = "UPDATE users SET userNome = '$nome', userSenha = '$pass' WHERE id = '$id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $response = "Usuário alterado com sucesso.";
    } else {
        $response = "Erro ao alterar usuário.";
    }
}
if (isset($_GET['id']) && isset($_GET['apagar'])) {
    $id = $_GET['id'];

    $query = "DELETE FROM users WHERE id = '$id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "Usuário removido com sucesso.";
    } else {
        echo "Erro ao remover usuário.";
    }
}
if(isset($_GET['todos'])){
    $query = "SELECT * FROM users";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $users = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $users[] = $row;
        }
        echo json_encode($users);
    } else {
        echo "Erro na consulta: " . mysqli_error($conn);
    }
} else {
    echo "Parâmetros inválidos.";
}
exit;
?>
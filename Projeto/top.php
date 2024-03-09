<?php
header("Content-Type: application/json");
include('connection.php');

if (isset($_GET['reaction']) && isset($_GET['leader'])) {
    $query = "SELECT * FROM reactionleader ORDER BY avg ASC";
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
}
if (isset($_GET['nome']) && isset($_GET['avg']) && isset($_GET['reaction'])) {
    $nome = mysqli_real_escape_string($conn, $_GET['nome']);
    $average = mysqli_real_escape_string($conn, $_GET['avg']);

    if ($nome == "")
        exit;

    // Verificar se já existe um registro com o mesmo nome
    $checkQuery = "SELECT * FROM reactionleader WHERE nome = '$nome'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if ($checkResult && mysqli_num_rows($checkResult) > 0) {
        $row = mysqli_fetch_assoc($checkResult);
        $existingAvg = $row['avg'];

        // Comparar o valor atual de avg com o valor recebido por parâmetro
        if ($average < $existingAvg) {
            // Atualizar o registro com o novo valor de avg
            $updateQuery = "UPDATE reactionleader SET avg = '$average' WHERE nome = '$nome'";
            $updateResult = mysqli_query($conn, $updateQuery);

            if ($updateResult) {
                $response = array("status" => "success", "message" => "Dados atualizados com sucesso");
            } else {
                $response = array("status" => "error", "message" => "Erro ao atualizar os dados: " . mysqli_error($conn));
            }
        } else {
            // O valor existente de avg é menor ou igual, não há necessidade de atualizar
            $response = array("status" => "success", "message" => "Nenhum dado foi alterado");
        }
    } else {
        // Não existe um registro com o mesmo nome, inserir um novo registro
        $insertQuery = "INSERT INTO reactionleader (nome, avg) VALUES ('$nome', '$average')";
        $insertResult = mysqli_query($conn, $insertQuery);

        if ($insertResult) {
            $response = array("status" => "success", "message" => "Dados inseridos com sucesso");
        } else {
            $response = array("status" => "error", "message" => "Erro ao inserir os dados: " . mysqli_error($conn));
        }
    }

    // Fechar a conexão com o banco de dados
    mysqli_close($conn);

    // Enviar a resposta como JSON
    echo json_encode($response);
}
if (isset($_GET['precision']) && isset($_GET['leader'])) {
    $query = "SELECT * FROM precisionleader ORDER BY hits DESC";
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
}
if (isset($_GET['nome']) && isset($_GET['hits']) && isset($_GET['precision'])) {
    $nome = mysqli_real_escape_string($conn, $_GET['nome']);
    $hits = mysqli_real_escape_string($conn, $_GET['hits']);

    if ($nome == "")
        exit;

    // Verificar se já existe um registro com o mesmo nome
    $checkQuery = "SELECT * FROM precisionleader WHERE nome = '$nome'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if ($checkResult && mysqli_num_rows($checkResult) > 0) {
        $row = mysqli_fetch_assoc($checkResult);
        $existinghits = $row['hits'];

        // Comparar o valor atual de avg com o valor recebido por parâmetro
        if ($hits > $existinghits) {
            // Atualizar o registro com o novo valor de avg
            $updateQuery = "UPDATE precisionleader SET hits = '$hits' WHERE nome = '$nome'";
            $updateResult = mysqli_query($conn, $updateQuery);

            if ($updateResult) {
                $response = array("status" => "success", "message" => "Dados atualizados com sucesso");
            } else {
                $response = array("status" => "error", "message" => "Erro ao atualizar os dados: " . mysqli_error($conn));
            }
        } else {
            // O valor existente de avg é menor ou igual, não há necessidade de atualizar
            $response = array("status" => "success", "message" => "Nenhum dado foi alterado");
        }
    } else {
        // Não existe um registro com o mesmo nome, inserir um novo registro
        $insertQuery = "INSERT INTO precisionleader (nome, hits) VALUES ('$nome', '$hits')";
        $insertResult = mysqli_query($conn, $insertQuery);

        if ($insertResult) {
            $response = array("status" => "success", "message" => "Dados inseridos com sucesso");
        } else {
            $response = array("status" => "error", "message" => "Erro ao inserir os dados: " . mysqli_error($conn));
        }
    }

    // Fechar a conexão com o banco de dados
    mysqli_close($conn);

    // Enviar a resposta como JSON
    echo json_encode($response);
}
if (isset($_GET['tracker']) && isset($_GET['leader'])) {
    $query = "SELECT * FROM trackerleader ORDER BY hits DESC";
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
}
if (isset($_GET['nome']) && isset($_GET['hits']) && isset($_GET['tracker'])) {
    $nome = mysqli_real_escape_string($conn, $_GET['nome']);
    $hits = mysqli_real_escape_string($conn, $_GET['hits']);

    if ($nome == "")
        exit;

    // Verificar se já existe um registro com o mesmo nome
    $checkQuery = "SELECT * FROM trackerleader WHERE nome = '$nome'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if ($checkResult && mysqli_num_rows($checkResult) > 0) {
        $row = mysqli_fetch_assoc($checkResult);
        $existinghits = $row['hits'];

        // Comparar o valor atual de avg com o valor recebido por parâmetro
        if ($hits > $existinghits) {
            // Atualizar o registro com o novo valor de avg
            $updateQuery = "UPDATE trackerleader SET hits = '$hits' WHERE nome = '$nome'";
            $updateResult = mysqli_query($conn, $updateQuery);

            if ($updateResult) {
                $response = array("status" => "success", "message" => "Dados atualizados com sucesso");
            } else {
                $response = array("status" => "error", "message" => "Erro ao atualizar os dados: " . mysqli_error($conn));
            }
        } else {
            // O valor existente de avg é menor ou igual, não há necessidade de atualizar
            $response = array("status" => "success", "message" => "Nenhum dado foi alterado");
        }
    } else {
        // Não existe um registro com o mesmo nome, inserir um novo registro
        $insertQuery = "INSERT INTO trackerleader (nome, hits) VALUES ('$nome', '$hits')";
        $insertResult = mysqli_query($conn, $insertQuery);

        if ($insertResult) {
            $response = array("status" => "success", "message" => "Dados inseridos com sucesso");
        } else {
            $response = array("status" => "error", "message" => "Erro ao inserir os dados: " . mysqli_error($conn));
        }
    }

    // Fechar a conexão com o banco de dados
    mysqli_close($conn);

    // Enviar a resposta como JSON
    echo json_encode($response);
}



exit;
?>
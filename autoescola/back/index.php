<?php 
require "config.php"; 
 
$rota = $_GET["rota"] ?? ($_SERVER["REQUEST_METHOD"] === "POST" ? "alunos" : "teste");
 
function teste() { 
    echo json_encode(["mensagem" => "Back-end respondendo"]); 
} 
 
function createAlunos($con){  
    $nome = $_POST["nome"]; 
    $email = $_POST["email"]; 
    $telefone = $_POST["telefone"]; 
    $data_nascimento = $_POST["data_nascimento"]; 
    try { 
        $stmt = $con->prepare("INSERT INTO Alunos (nome, email, telefone, data_nascimento) VALUES (?, ?, ?, ?)"); 
        $stmt->execute([ $nome, $email, $telefone, $data_nascimento]); 
        header("Location: ../front/index.html"); 
    } catch (PDOException $e) { 
        echo json_encode(["erro" => "Falha na conexão: " . $e->getMessage()]);
        exit;
    } 

} 
 
function createIntrutores($con){ 
    $nome = $_POST["nome"]; 
    $email = $_POST["email"]; 
    $telefone = $_POST["telefone"]; 
    $categoria_cnh = $_POST["categoria_cnh"]; 
    $data_cadastro = $_POST["data_cadastro"]; 
    try { 
        $stmt = $con->prepare("INSERT INTO Instrutores (idInstrutor, nomeInstrutor, emailInstrutor, telefoneInstrutor, categoriacnhInstrutor, datacadastroInstrutor) VALUES (?, ?, ?, ?, ?, ?)"); 
        $stmt->execute([$id, $nome, $email, $telefone, $categoria_cnh, $data_cadastro]); 
        header("Location: ../front/index.html"); 
    } catch (PDOException $e) { 
        echo json_encode(["mensagem" => $e]); 
        exit;
    } 
} 
 
function readAlunos($con) { 
    $stmt = $con->query("SELECT * FROM Alunos"); 
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC)); 
} 
 
function readInstrutores($con) { 
    $stmt = $con->query("SELECT * FROM Instrutores"); 
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC)); 
} 

if ($_SERVER["REQUEST_METHOD"] === "POST"){
    createAlunos($con);
}elseif ($rota === "alunos"){
    readAlunos($con);
}elseif ($rota === "instrutor"){
    readInstrutores($con);
}else {
    teste();
}
?>

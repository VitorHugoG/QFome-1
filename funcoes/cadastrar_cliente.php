<?php
require_once 'conect.php';
session_start();

$conn = Connection();

function Cadastrar($nome, $email, $senha, $conn){
    if(ValidaEmail($email, $conn)){
        header("Location: ../cadastro.php?msg=1");
    }
    else{
        $result = $conn->prepare("INSERT INTO usuario (nome_usu, email_usu, senha_usu, url_foto_usu, cod_status_usu, cod_tipo_usu) VALUES('$nome', '$email', '$senha','imagens_png/imagem_padrao.png','A', 1)");
        $result->execute();
        header("Location: ../login.php");
    }
}

function ValidaEmail ($email, $conn){
    $result = $conn->prepare("SELECT * FROM usuario WHERE email_usu = '$email'");
    $result->execute();
    $count=$result->rowCount();
    if($count == 1){
        return true;
    }else{
        return false;
    }
}


if(isset($_POST["nome"])){
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
   

        Cadastrar($nome, $email, $senha, $conn);
}else{
    unset($_SESSION['cod']);
    unset($_SESSION['usuario']);
    unset($_SESSION['nome']);
    unset($_SESSION['senha']);
    unset($_SESSION['tipo']);
    unset($_SESSION['email']);
    session_destroy();
    header("Location: ../cadastro.php?msg=2");
}

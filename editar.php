<?php 
    include_once "conexao.php";
    include_once "funcoes.php";
    
    if(isset($_GET['id']) && $_GET['id'] > 0 ){
        $id = $_GET['id'];
        
        $conexaoComBanco = abrirBanco();

        $pegarDados = $conexaoComBanco->prepare("SELECT * FROM pessoas WHERE id = ?");
        $pegarDados->bind_param("i", $id);
        $pegarDados->execute();
        $result =  $pegarDados->get_result();

        if($result->num_rows == 1){
            $registro = $result->fetch_assoc();
        }
        fecharBanco($conexaoComBanco);

        if($_SERVER['REQUEST_METHOD'] == "POST") {
            // dd($_POST);

            $id= $_POST['id'];
            $nome = $_POST['nome'];
            $sobrenome = $_POST['sobrenome'];
            $nascimento = $_POST['nascimento'];
            $endereco = $_POST['endereco'];
            $telefone = $_POST['telefone'];
    
            $conexaoComBanco = abrirBanco();

            $sql = "UPDATE pessoas SET nome = '$nome', 
            sobrenome = '$sobrenome', nascimento= '$nascimento', 
            endereco = '$endereco', telefone = '$telefone' WHERE id = $id";

              if ($conexaoComBanco->query($sql) === TRUE){
                echo ":) Contato atualizado com suceso no banco de dados";
              }else{
                echo ":( Erro ao salvar n banco de dados" . $conexaoComBanco ->error;
              }
        }
    
    }
  

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <header>    
        <h1>Atualizar Contatos</h1>
     
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="cadastrar.php">cadastrar</a></li>
            </ul>
        </nav>
    </header>
    
  
    <section>
        <h2>Lista de contatos</h2>
        <form action="" method="POST">
            <label for="nome">Nome</label>
            <input type="text" name= "nome" value="<?= $registro['nome']?>" required>

            <label for="sobrenome">Sobrenome</label>
            <input type="text" name= "sobrenome" value="<?= $registro['sobrenome']?>" required>

            <label for="nascimento">Nascimento</label>
            <input type="date" name= "nascimento"value="<?= $registro['nascimento']?>"  required>

            <label for="endereco">Endereço</label>
            <input type="text" name= "endereco" value="<?= $registro['endereco']?>" required>

            <label for=telefone">Telefone</label>
            <input type="text" name= "telefone" value="<?= $registro['telefone']?>" required>

            <input type="hidden" name= "id" value="<?= $registro['id']?>" required> 
            
            <button type="submit">Salvar</button>
        </form>
    </section>
</body>
</html>
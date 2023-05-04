<?php

/**
 * ╔═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════╗
 * ║                                               CONTROLE FINANCEIRO                                                 ║
 * ║  ┌─────────────────────────────────────────────────────────────────────────────────────────────────────────────┐  ║
 * ║  │ @description: Repository of 'Usuario'                                                                       │  ║
 * ║  | @dir: Model                                                                                                 │  ║
 * ║  │ @author: Tiago César da Silva Lopes                                                                         │  ║
 * ║  │ @date: 08/03/23                                                                                             │  ║
 * ║  └─────────────────────────────────────────────────────────────────────────────────────────────────────────────┘  ║
 * ║═══════════════════════════════════════════════════════════════════════════════════════════════════════════════════║
 */

 namespace model;

use PDOException;

 class Usuario_repositorio{

    public function cadastrar($nome,  $email, $senha , $pdo){
        try{

            $stmt = $pdo->prepare("Insert INTO Usuario (nome, email, senha)
            VALUES ( :nome , :email , sha1( :senha )  ) ");

            $stmt->execute(array(
                ':nome' => $nome ,
                ':email' => $email ,
                ':senha' => $senha
            ));

            return true;

        } catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }


    public function verificar_existe($email , $pdo){
        // $consulta = $pdo->query("Select * from Usuario where email = '{$email}' ");


        try{
            $stmt = $pdo->prepare("Select * from Usuario where email = :email  ");

            $stmt->execute(array(
                ':email' => $email
            ));

            // var_dump($stmt);
            while ($linha = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                if ($email = $linha['email'] ) {
                    // ECHO "tá igual";
                    return true;
                }
            }

        } catch (PDOException $e){
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    
    public function login ($email, $senha, $pdo){
        try{
            $stmt = $pdo->prepare("Select * from Usuario where email = :email and senha = sha1( :senha ) ; ");

            $stmt->execute(array(
                ":email" => $email,
                "senha" => $senha
            ));

            // var_dump($stmt);
            while ($linha = $stmt->fetch(\PDO::FETCH_ASSOC)){
                // if ($email = $linha['email'] and sha1($senha) = sha1($linha['senha'])){

                // }
                return true;
            }

            return false;
        }catch (PDOException $e){
            echo "Error: " . $e->getMessage();
            return false;
        }
    }


    public function consultar_usuario ($email, $senha, $pdo){
        try{
            $stmt = $pdo->prepare("Select * from Usuario where email = :email and senha = sha1( :senha ) ; ");

            $stmt->execute(array(
                ":email" => $email,
                "senha" => $senha
            ));

            $Usuario = new Usuario();
            while ($linha = $stmt->fetch(\PDO::FETCH_ASSOC)){
                
                $Usuario->setId($linha['id']);
                $Usuario->setNome($linha['nome']);
                $Usuario->setEmail($linha['email']);
                $Usuario->setStatus($linha['status']);
                $Usuario->setCreated($linha['created']);


                return $Usuario;
            }

            return false;
        }catch (PDOException $e){
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    
    public function alterar_senha ($senha , $idUsuario, $pdo){

        try{

            $stmt = $pdo->prepare ("Update Usuario set senha = sha1 ( :senha ) , updated = now() where id = :idUsuario  ");

            $stmt->execute(array(
                "senha" => $senha,
                "idUsuario" => $idUsuario
            ));

            return true;

        } catch (PDOException $e){
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

 }
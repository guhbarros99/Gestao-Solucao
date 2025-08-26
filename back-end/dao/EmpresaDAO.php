<?php

// CREATE TABLE empresa (
//     id_empresa INT AUTO_INCREMENT PRIMARY KEY,
//     nome VARCHAR(100) NOT NULL,
//     email VARCHAR(150) NOT NULL UNIQUE,
//     cnpj VARCHAR(18) NOT NULL UNIQUE,
//     senha VARCHAR(255) NOT NULL,
//     token VARCHAR(255) NULL
// );

class EmpresaDAO
{
    private $conn;

    public function __construct()
    {
        $this->conn = Database::getConnection();
    }

    public function buscarEmpresaPorEmail(string $email)
    {
        $query = "SELECT * FROM empresa WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Empresa(
                $row['id'],
                $row['nome'],
                $row['email'],
                $row['cnpj'],
                $row['senha'],
                $row['token']
            );
        }
        return null;
    }

    public function buscarEmpresaPorCnpj(string $cnpj)
    {
        $query = "SELECT * FROM empresa WHERE cnpj = :cnpj";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':cnpj', $cnpj);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Empresa(
                $row['id'],
                $row['nome'],
                $row['email'],
                $row['cnpj'],
                $row['senha'],
                $row['token']
            );
        }
        return null;
    }

    public function getAllEmpresas()
    {
        $query = "SELECT * FROM empresa";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $empresas = $stmt->fetchAll(PDO::FETCH_CLASS, 'Empresa');
        return $empresas ?: [];
    }

    


   
    public function cadastrarEmpresa(Empresa $empresa) {
        $query = "INSERT INTO empresa (nome, email, cnpj, senha, token) VALUES (:nome, :email, :cnpj, :senha, :token)";
        $stmt = $this->conn->prepare($query);

        $nome = $empresa->getNome();
        $email = $empresa->getEmail();  
        $cnpj = $empresa->getCnpj();
        $senha = password_hash($empresa->getSenha(), PASSWORD_DEFAULT);
        $token = $empresa->getToken();

        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':cnpj', $cnpj);
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':token', $token);


        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

}

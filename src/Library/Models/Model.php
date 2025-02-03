<?php

declare(strict_types=1);

/**
 * Classe base para Modelos no Flint ORM.
 * 
 * Responsável por fornecer métodos básicos para interação com o banco de dados,
 * incluindo a recuperação, inserção, atualização e remoção de registros.
 * 
 * @package Flint\Models
 */
namespace Flint\Library\Models;

use Flint\Databases\ModelPdo;
use PDO;
use PDOException;

abstract class Model {
    /**
     * @var string Nome da tabela no banco de dados.
     */
    protected string $table_name;

    /**
     * @var PDO Instância da conexão PDO.
     */
    protected PDO $pdo;

    /**
     * Construtor da classe Model.
     * Inicializa a conexão com o banco de dados.
     */
    public function __construct()
    {
        $this->pdo = ModelPdo::getInstance();
    }

    /**
     * Retorna todos os registros da tabela correspondente ao modelo.
     *
     * @return array Lista de registros.
     */
    public function all(): array {
        try {
            $stmt = $this->pdo->query("SELECT * FROM {$this->table_name}");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Retorna um único registro pelo ID.
     *
     * @param int $id ID do registro.
     * @return array|null Registro encontrado ou null se não existir.
     */
    public function find(int $id): ?array {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM {$this->table_name} WHERE id = :id");
            $stmt->execute(['id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
        } catch (PDOException $e) {
            return null;
        }
    }

    /**
     * Insere um novo registro na tabela correspondente ao modelo.
     *
     * @param array $data Dados a serem inseridos (chave => valor).
     * @return bool Retorna verdadeiro em caso de sucesso, falso caso contrário.
     */
    public function save(array $data): bool {
        try {
            $columns = implode(',', array_keys($data));
            $placeholders = ':' . implode(', :', array_keys($data));
            
            $sql = "INSERT INTO {$this->table_name} ({$columns}) VALUES ({$placeholders})";
            $stmt = $this->pdo->prepare($sql);
            
            return $stmt->execute($data);
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Atualiza um registro pelo ID.
     *
     * @param int $id ID do registro a ser atualizado.
     * @param array $data Dados para atualização.
     * @return bool Retorna verdadeiro se a atualização for bem-sucedida, falso caso contrário.
     */
    public function update(int $id, array $data): bool {
        try {
            $fields = implode(', ', array_map(fn($key) => "$key = :$key", array_keys($data)));
            $data['id'] = $id;
            
            $sql = "UPDATE {$this->table_name} SET {$fields} WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            
            return $stmt->execute($data);
        } catch (PDOException $e) {
            return false;
        }
    }

    /**
     * Exclui um registro pelo ID.
     *
     * @param int $id ID do registro a ser excluído.
     * @return bool Retorna verdadeiro se a exclusão for bem-sucedida, falso caso contrário.
     */
    public function delete(int $id): bool {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM {$this->table_name} WHERE id = :id");
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            return false;
        }
    }
}

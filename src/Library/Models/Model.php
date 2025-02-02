<?php

declare(strict_types=1);

/**
 * Arquivo Model para gerenciar a ORM (Mapeamento-Objeto-Relacional) do Flint.
 *
 */

namespace Flint\Models;

use Flint\Databases\ModelPdo;

abstract class Model {

    protected string $table_name;
    protected mixed $pdomodel;

    public function __construct()
    {
        $this->pdomodel = ModelPdo::getInstance();
    }

    public function all(): array {
        $pdomodel = ModelPdo::getInstance();

        $stmt = $pdomodel->quey("SELECT * FROM {$this->table_name}");

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function save($data): bool {

        $columns = implode(',', array_keys($data));
        $values = ':'. implode(', :', array_keys($data));

        $sql = "INSERT INTO {$this->table_name} ({$columns}) VALUES ({$values})";
        $stmt = $this->pdomodel->prepare($sql);
        return $stmt->execute($data);
    }
}
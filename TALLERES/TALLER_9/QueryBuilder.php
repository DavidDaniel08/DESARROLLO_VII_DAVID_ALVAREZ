<?php
class QueryBuilder {
    private $pdo;
    private $table;
    private $conditions = [];
    private $parameters = [];
    private $orderBy = [];
    private $limit = null;
    private $offset = null;
    private $joins = [];
    private $groupBy = [];
    private $having = [];
    private $fields = ['*'];

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function table($table) {
        $this->table = $table;
        return $this;
    }

    public function select($fields) {
        $this->fields = is_array($fields) ? $fields : func_get_args();
        return $this;
    }

    public function where($column, $operator, $value = null) {
        if ($value === null) {
            $value = $operator;
            $operator = '=';
        }

        $placeholder = ':' . str_replace('.', '_', $column) . count($this->parameters);
        $this->conditions[] = "$column $operator $placeholder";
        $this->parameters[$placeholder] = $value;

        return $this;
    }

    public function whereIn($column, array $values) {
        if (empty($values)) {
            throw new InvalidArgumentException("El array de valores no puede estar vacío.");
        }

        $placeholders = [];
        foreach ($values as $i => $value) {
            $placeholder = ':' . str_replace('.', '_', $column) . $i;
            $placeholders[] = $placeholder;
            $this->parameters[$placeholder] = $value;
        }

        $this->conditions[] = "$column IN (" . implode(', ', $placeholders) . ")";
        return $this;
    }

    public function join($table, $first, $operator, $second, $type = 'INNER') {
        $this->joins[] = [
            'type' => $type,
            'table' => $table,
            'conditions' => "$first $operator $second"
        ];
        return $this;
    }

    public function orderBy($column, $direction = 'ASC') {
        $this->orderBy[] = "$column $direction";
        return $this;
    }

    public function groupBy($columns) {
        $this->groupBy = is_array($columns) ? $columns : func_get_args();
        return $this;
    }

    public function having($condition) {
        $this->having[] = $condition;
        return $this;
    }
    

    public function limit($limit, $offset = null) {
        $this->limit = $limit;
        $this->offset = $offset;
        return $this;
    }

    public function buildQuery() {
        if (empty($this->table)) {
            throw new RuntimeException("La tabla no puede estar vacía.");
        }

        $sql = "SELECT " . implode(', ', $this->fields) . " FROM " . $this->table;

        foreach ($this->joins as $join) {
            $sql .= " {$join['type']} JOIN {$join['table']} ON {$join['conditions']}";
        }

        if (!empty($this->conditions)) {
            $sql .= " WHERE " . implode(' AND ', $this->conditions);
        }

        if (!empty($this->groupBy)) {
            $sql .= " GROUP BY " . implode(', ', $this->groupBy);
        }

        if (!empty($this->having)) {
            $sql .= " HAVING " . implode(' AND ', $this->having);
        }

        if (!empty($this->orderBy)) {
            $sql .= " ORDER BY " . implode(", ", $this->orderBy);
        }

        if ($this->limit !== null) {
            $sql .= " LIMIT " . $this->limit;
            if ($this->offset !== null) {
                $sql .= " OFFSET " . $this->offset;
            }
        }

        return $sql;
    }

    public function execute() {
        $sql = $this->buildQuery();
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($this->parameters);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getParameters() {
        return $this->parameters;
    }
}

// Clase para construir consultas de inserción seguras
class InsertBuilder {
    private $pdo;
    private $table;
    private $data = [];

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function into($table) {
        $this->table = $table;
        return $this;
    }

    public function values(array $data) {
        $this->data = $data;
        return $this;
    }

    public function execute() {
        if (empty($this->table) || empty($this->data)) {
            throw new RuntimeException("La tabla y los datos no pueden estar vacíos.");
        }

        $columns = array_keys($this->data);
        $placeholders = array_map(function($col) {
            return ':' . $col;
        }, $columns);

        $sql = "INSERT INTO {$this->table} (" . 
               implode(', ', $columns) . 
               ") VALUES (" . 
               implode(', ', $placeholders) . 
               ")";

        $stmt = $this->pdo->prepare($sql);
        
        $params = array_combine($placeholders, array_values($this->data));
        return $stmt->execute($params);
    }
}

// Clase para construir consultas de actualización seguras
class UpdateBuilder {
    private $pdo;
    private $table;
    private $data = [];
    private $conditions = [];
    private $parameters = [];

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function table($table) {
        $this->table = $table;
        return $this;
    }

    public function set(array $data) {
        $this->data = $data;
        return $this;
    }

    public function where($column, $operator, $value = null) {
        if ($value === null) {
            $value = $operator;
            $operator = '=';
        }

        $placeholder = ':where_' . str_replace('.', '_', $column);
        $this->conditions[] = "$column $operator $placeholder";
        $this->parameters[$placeholder] = $value;

        return $this;
    }

    public function execute() {
        if (empty($this->table) || empty($this->data)) {
            throw new RuntimeException("La tabla y los datos no pueden estar vacíos.");
        }

        $setParts = [];
        foreach ($this->data as $column => $value) {
            $placeholder = ':set_' . $column;
            $setParts[] = "$column = $placeholder";
            $this->parameters[$placeholder] = $value;
        }

        $sql = "UPDATE {$this->table} SET " . implode(', ', $setParts);

        if (!empty($this->conditions)) {
            $sql .= " WHERE " . implode(' AND ', $this->conditions);
        }

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($this->parameters);
    }
}

// Ejemplo de uso
require_once "config_pdo.php";

try {
    // Crear instancia del QueryBuilder
    $qb = new QueryBuilder($pdo);

    // Ejemplo de consulta compleja
   // Construir la consulta
$resultados = $qb->table('productos p')
->select('p.id', 'p.nombre', 'c.nombre as categoria', 'p.precio', 'COUNT(p.id) AS product_count')
->join('categorias c', 'p.categoria_id', '=', 'c.id')
->where('p.precio', '>', 100)
->whereIn('c.id', [1, 2, 3])
->groupBy(['p.id', 'c.nombre'])
->having('product_count > 1')
->orderBy('p.precio', 'DESC')
->limit(10)
->execute();


    // Ejemplo de inserción
    $insert = new InsertBuilder($pdo);
    $insert->into('productos')
           ->values([
               'nombre' => 'Nuevo Producto',
               'precio' => 199.99,
               'categoria_id' => 1
           ])
           ->execute();

    // Ejemplo de actualización
    $update = new UpdateBuilder($pdo);
    $update->table('productos')
           ->set(['precio' => 299.99])
           ->where('id', '=', 1)
           ->execute();

    // Mostrar resultados
    echo "<pre>";
    print_r($resultados);
    echo "</pre>";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
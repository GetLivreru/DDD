<?php

class ProductRepository
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findByCode ($code)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE code = :code LIMIT 1");
        $stmt->execute(['code' => $code]);
        $row = $stmt->fetch();
        return $row ? new Product($row['id'], $row['name'], $row['code']) : null;
    }

    public function save(Product $product)
    {
        if ($product->id) {
            $stmt = $this->pdo->prepare("UPDATE products SET name = :name, code = :code WHERE id = :id");
            $stmt->execute([
                'id' => $product->id,
                'name' => $product->name,
                'code' => $product->code
            ]);
        } else {
            $stmt = $this->pdo->prepare("INSERT INTO products (name, code) VALUES (:name, :code) RETURNING id");
            $stmt->execute([
                'name' => $product->name,
                'code' => $product->code
            ]);
            $product->id = $stmt->fetchColumn();
        }
        return $product;
    }
} 
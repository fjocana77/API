<?php

class Product {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli('mysql', 'root', 'root', 'productdb');

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getAllProducts() {
        $query = "SELECT * FROM products";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();

        if (!$result) {
            die("Error en la consulta: " . $this->conn->error);
        }

        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
        return json_encode($products);
    }

    public function getProduct($id) {
        $query = "SELECT * FROM products WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result && $result->num_rows > 0) {
            return json_encode($result->fetch_assoc());
        }
        return json_encode(['message' => 'Product not found']);
    }

    public function createProduct($data) {
        $name = $data['name'];
        $description = $data['description'];
        $price = $data['price'];
        
        $query = "INSERT INTO products (name, description, price, created_at) VALUES (?, ?, ?, NOW())";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bind_param("ssd", $name, $description, $price);
        
        if ($stmt->execute()) {
            return json_encode(['message' => 'Product created successfully']);
        }
        return json_encode(['message' => 'Failed to create product', 'error' => $this->conn->error]);
    }

    public function updateProduct($id, $data) {
        $name = $data['name'];
        $description = $data['description'];
        $price = $data['price'];
        
        $query = "UPDATE products SET name = ?, description = ?, price = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bind_param("ssdi", $name, $description, $price, $id);
        
        if ($stmt->execute()) {
            return json_encode(['message' => 'Product updated successfully']);
        }
        return json_encode(['message' => 'Failed to update product', 'error' => $this->conn->error]);
    }

    public function deleteProduct($id) {
        $query = "DELETE FROM products WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            return json_encode(['message' => 'Product deleted successfully']);
        }
        return json_encode(['message' => 'Failed to delete product', 'error' => $this->conn->error]);
    }
}

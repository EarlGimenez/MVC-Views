<?php

namespace Models;

use Models\Database;

class UserRepository implements DataRepositoryInterface {
    private $db;

    public function __construct(Database $db) {
        $this->db = $db;
    }

    public function getAll() {
        return $this->db->query("SELECT * FROM users");
    }
    
    public function getById($id) {
        return $this->db->query("SELECT * FROM users WHERE id = ?", [$id]);
    }

    public function delete($id) {
        $this->db->query("DELETE FROM users WHERE id = ?", [$id]);
    }

    // JWT implementations -----------------------------------------------------------------------------------------------------------------------------------
    public function getByUsername($username) {
        return $this->db->query("SELECT * FROM users WHERE username = ?", [$username]);
    }

    public function create($data) {
        $this->db->query("INSERT INTO users (username, password) VALUES (?, ?)", [
            $data['username'],
            $data['password']
        ]);
    }

    public function update($id, $data) {
        $this->db->query("UPDATE users SET username = ?, password = ? WHERE id = ?", [
            $data['username'], 
            $data['password'], 
            $id
        ]);
    }
}

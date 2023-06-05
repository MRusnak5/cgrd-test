<?php
// User.php
require_once 'Database.php';

class User {
    private $db;

    public function __construct() {
        try {
            $this->db = new Database();
        } catch(PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getUser($id) {
        try {
            $sql = "SELECT * FROM users WHERE id = ?";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->execute([$id]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user) {
                return $user;
            } else {
                throw new Exception('User not found.');
            }
        } catch(PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        } catch (Exception $e) {
            die($e->getMessage());

        }
    }

    public function login($data) {
        try {
            $username = $data['username'];
            $password = $data['password'];
    
            $sql = "SELECT * FROM users WHERE username = ?";
            $stmt = $this->db->getConnection()->prepare($sql);

            $stmt->execute([$username]);
    
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $user = $result;
                if (password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    return ['status' => 'success', 'message' => 'Login successful.'];
                } else {
                    return ['status' => 'error', 'message' => 'Wrong Login Data'];
                }
            } else {
                return ['status' => 'error', 'message' => 'Wrong Login Data'];
            }
        } catch(PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
    
}
?>
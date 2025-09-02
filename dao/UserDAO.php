<?php

include_once "models/User.php";
include_once "models/Message.php";

class UserDAO implements UserDAOInterface {

    private $conn;
    private $url;
    private $message;

    public function __construct(PDO $conn, $url) {
        $this->conn = $conn;
        $this->url = $url;
        $this->message = new Message($url);
    }

    public function buildUser($data) {
        $user = new User();

        $user->id       = $data["id"]       ?? null;
        $user->name     = $data["name"]     ?? null;
        $user->lastname = $data["lastname"] ?? null;
        $user->email    = $data["email"]    ?? null;
        $user->password = $data["password"] ?? null; // Evita undefined index
        $user->image    = $data["image"]    ?? null;
        $user->bio      = $data["bio"]      ?? null;
        $user->token    = $data["token"]    ?? null;

        return $user;
    }

    public function create(User $user, $authUser = false) {
        $stmt = $this->conn->prepare("INSERT INTO users (
            name, lastname, email, password, token
        ) VALUES (
            :name, :lastname, :email, :password, :token
        )");

        $stmt->bindParam(":name", $user->name);
        $stmt->bindParam(":lastname", $user->lastname);
        $stmt->bindParam(":email", $user->email);
        $stmt->bindParam(":password", $user->password);
        $stmt->bindParam(":token", $user->token);

        $stmt->execute();

        if ($authUser) {
            $this->setTokenToSession($user->token);
        }
    }

    public function update(User $user) {
        $stmt = $this->conn->prepare("UPDATE users SET 
            name = :name,
            lastname = :lastname,
            email = :email,
            image = :image,
            bio = :bio,
            token = :token
            WHERE id = :id
        ");

        $stmt->bindParam(":name", $user->name);
        $stmt->bindParam(":lastname", $user->lastname);
        $stmt->bindParam(":email", $user->email);
        $stmt->bindParam(":image", $user->image);
        $stmt->bindParam(":bio", $user->bio);
        $stmt->bindParam(":token", $user->token);
        $stmt->bindParam(":id", $user->id);

        $stmt->execute();

        $this->message->setMessage("Dados atualizados com sucesso!", "success", "editprofile.php");
    }

    public function changePassword($user) {
        $stmt = $this->conn->prepare("UPDATE users SET 
            password = :password
            WHERE id = :id
        ");

        $stmt->bindParam(":password", $user->password);
        $stmt->bindParam(":id", $user->id);

        $stmt->execute();

        $this->message->setMessage("Senha atualizada!", "success", "editprofile.php");
    }

    public function findByToken($token) {
        $stmt = $this->conn->prepare("SELECT id, name, lastname, email, password, image, bio, token 
                                      FROM users WHERE token = :token");

        $stmt->bindParam(":token", $token);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $this->buildUser($data);
        } else {
            return false;
        }
    }

    public function findByEmail($email) {
        if ($email != "") {
            $stmt = $this->conn->prepare("SELECT id, name, lastname, email, password, image, bio, token 
                                          FROM users WHERE email = :email");

            $stmt->bindParam(":email", $email);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                return $this->buildUser($data);
            } else {
                return false;
            }
        }

        return false;
    }

    public function setTokenToSession($token, $redirect = true) {
        $_SESSION["token"] = $token;

        if ($redirect) {
            $this->message->setMessage("Seja bem-vindo!", "success", "editprofile.php");
        }
    }

    public function verifyToken($protected = true) {
        if (!empty($_SESSION["token"])) {
            $token = $_SESSION["token"];
            $user = $this->findByToken($token);

            if ($user) {
                return $user;
            } else if ($protected) {
                $this->message->setMessage("Faça a autenticação para acessar esta página.", "error", "index.php");
            }
        } else {
            return false;
        }
    }

    public function authenticateUser($email, $password) {
        $user = $this->findByEmail($email);

        if ($user) {
            if (password_verify($password, $user->password)) {
                $token = $user->generateToken();
                $this->setTokenToSession($token, false);
                $user->token = $token;
                $this->update($user);
                return true;
            }
        }

        return false;
    }

    public function destroyToken() {
        $_SESSION["token"] = "";
        $this->message->setMessage("Você fez o logout com sucesso!", "success", "index.php");
    }

    public function findById($id) {
        if ($id != "") {
            $stmt = $this->conn->prepare("SELECT id, name, lastname, email, password, image, bio, token 
                                          FROM users WHERE id = :id");

            $stmt->bindParam(":id", $id);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                return $this->buildUser($data);
            } else {
                return false;
            }
        }
    }
}
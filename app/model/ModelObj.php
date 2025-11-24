<?php
require_once __DIR__ . '/../../config/db-connection.php';

function selectArticles($limit = null, $offset = null) {
    global $conn;
    try {
        // Ojo con `user`, mejor entre backticks porque es palabra reservada en MySQL
        $sql = "SELECT id, `user`, titol, cos 
                FROM articles 
                ORDER BY id ASC";

        // offset per començar a agafar articles a partir del article X i limit per agafar la quantitat d'articles per pagina
        if ($limit !== null && $offset !== null) {
            $sql .=  " LIMIT :limit OFFSET :offset";
        }

        // En cas de no posar els parametres en la funcio els agafa tots els articles
        $stmt = $conn->prepare($sql);
        if ($limit !== null && $offset !== null) {
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return [];
    }
}

function selectArticlesByUser($user, $limit = null, $offset = null) {
    global $conn;
    try {
        $sql = "SELECT id, `user`, titol, cos 
                FROM articles 
                WHERE `user` = :user
                ORDER BY id ASC";

        if ($limit !== null && $offset !== null) {
            $sql .= " LIMIT :limit OFFSET :offset";
        }

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':user', $user, PDO::PARAM_STR);
        if ($limit !== null && $offset !== null) {
            $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return [];
    }
}

function countArticles() {
    global $conn;
    try {
        $sql = "SELECT COUNT(id) AS total FROM articles";
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)$result['total'];

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return 0;
    }
}

function countArticlesByUser($user) {
    global $conn;

    try {
        $sql = "SELECT COUNT(id) AS total 
                FROM articles
                WHERE `user` = :user";

        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':user', $user, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)$result['total'];

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return 0;
    }
}

function createArticle($user, $titol, $cos) {
    global $conn;
    try {
        $sql = "INSERT INTO articles (user, titol, cos) VALUES (:user, :titol, :cos)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ":user" => $user,
            ":titol" => $titol,
            ":cos" => $cos
        ]);
        return "Article creat correctament";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return "Error al crear article";
    }
}

function getArticleById($id) {
    global $conn;
    try {
        $sql = "SELECT id, `user`, titol, cos
                FROM articles
                WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return null;
    }
}

function updateArticle($id, $titol, $cos) {
    global $conn;
    try {
        $sql = "UPDATE articles
                SET titol = :titol, cos = :cos
                WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':titol' => $titol,
            ':cos'   => $cos,
            ':id'    => (int)$id
        ]);
        return true;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

function deleteArticle($id) {
    global $conn;
    try {
        $sql = "DELETE FROM articles WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}
?>
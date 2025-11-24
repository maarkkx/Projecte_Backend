<?php
require_once __DIR__ . '/../../config/db-connection.php';
/**
 * Funcion para coger objetos
 * @param limit el maximo de objetos
 * @param offset a partir de que objeto empieza a cogerlos 
 */
function selectArticles($limit = null, $offset = null) {
    global $conn;
    try {
        $sql = "SELECT id, user, titol, cos 
                FROM articles 
                ORDER BY id ASC";
        if ($limit !== null && $offset !== null) {
            $sql .=  " LIMIT :limit OFFSET :offset";
        }

        //Si no pones ninguno de los parametros los coge todos
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

/**
 * Funcion para coger objetos de un usuario en especifico
 * @param user los objetos que pertenecen al usuario
 * @param limit el maximo de objetos
 * @param offset a partir de que objeto empieza a cogerlos 
 */
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

/**
 * Contar todos los objetos
 */
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

/**
 * Contar todos los objetos de un usuario
 * @param user usuario del que contaremos los objetos
 */
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

/**
 * crear objetos
 * @param user usuario que los crea
 * @param titol titulo del objeto
 * @param cos descripcion del objeto
 */
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
        return "Object created!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return "Error creating the object";
    }
}

/**
 * Obtener un objeto
 * @param id id del objeto que queremos
 */
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


/**
 * Actualizar objetos
 * @param id id del objeto que queremos modificar
 * @param titol nuevo titulo
 * @param cos nueva descripcion 
 */
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

/**
 * eliminar objetos
 * @param id id del objeto que queremos eliminar
 */
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
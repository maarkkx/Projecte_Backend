<?php

function saveApiKey($apikey, $conn, $user) {
    try {
        $sql = "UPDATE users 
                SET api_key_hash = :api, api_key_created_at = :apidate
                WHERE user = :u";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':api' => $apikey,
            ':apidate' => date("Y-m-d H:i:s"),
            ':u' => $user
        ]);

        return true;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

function getApiKey($conn, $user) {
    $sql = "SELECT api_key_hash FROM users WHERE user = :u";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':u' => $user
    ]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
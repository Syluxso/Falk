<?php

namespace db\handlers;

use db\OptInRequestSQLHandler;
use Exception;
use OptInRequest;
use PDO;
use PDOException;

class OIRMySQLHandler implements OptInRequestSQLHandler {
    private $pdo;

    public function __construct($config) {
        try {
            $dsn = "mysql:host={$config['db_host']};dbname={$config['db_name']};charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
            ];
            $this->pdo = new PDO($dsn, $config['db_user'], $config['db_pass'], $options);
        } catch (PDOException $e) {
            throw new Exception("Connection failed: " . $e->getMessage());
        }
    }

    public function get($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM opt_in_request WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return null;
        }

        $optInRequest = new OptInRequest(
            $result['id'],
            $result['site_id'],
            $result['site_name'],
            $result['phone'],
            $result['status'],
            $result['created'],
            $result['hash']
        );

        return $optInRequest;
    }

    public function getByHash($hash) {
        $stmt = $this->pdo->prepare("SELECT * FROM opt_in_request WHERE hash = :hash");
        $stmt->bindParam(":hash", $hash);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return null;
        }

        $optInRequest = new OptInRequest(
            $result['id'],
            $result['site_id'],
            $result['site_name'],
            $result['phone'],
            $result['status'],
            $result['created'],
            $result['hash']
        );

        return $optInRequest;
    }

    /**
     * @throws Exception
     */
    public function create(OptInRequest $optInRequest): OptInRequest {
        $stmt = $this->pdo->prepare("
            INSERT INTO opt_in_request (site_id, site_name, phone, status, created, hash)
            VALUES (:site_id, :site_name, :phone, :status, :created, :hash)
        ");
        $stmt->bindValue(':site_id', $optInRequest->getSiteId());
        $stmt->bindValue(':site_name', $optInRequest->getSiteName());
        $stmt->bindValue(':phone', $optInRequest->getPhone(), PDO::PARAM_INT);
        $stmt->bindValue(':status', $optInRequest->getStatus(), PDO::PARAM_INT);
        $stmt->bindValue(':created', $optInRequest->getCreated(), PDO::PARAM_INT);
        $stmt->bindValue(':hash', $optInRequest->getHash());

        try{
            $stmt->execute();
        } catch (Exception $e){
            // They will likely eventually want to be able to resend an opt-in request
            error_log("Exception ".$e->getMessage());

            if(str_contains($e->getMessage(), "Integrity constraint violation")){
                throw new Exception("This record already exists");
            }
        }

        $id = $this->pdo->lastInsertId();
        return $this->get($id);
    }

    public function update($optInRequest) {
        $stmt = $this->pdo->prepare("
            UPDATE opt_in_request
            SET site_id = :site_id,
                site_name = :site_name,
                phone = :phone,
                status = :status,
                created = :created,
                hash = :hash
            WHERE id = :id
        ");
        $stmt->bindValue(':site_id', $optInRequest->getSiteId());
        $stmt->bindValue(':site_name', $optInRequest->getSiteName());
        $stmt->bindValue(':phone', $optInRequest->getPhone(), PDO::PARAM_INT);
        $stmt->bindValue(':status', $optInRequest->getStatus(), PDO::PARAM_INT);
        $stmt->bindValue(':created', $optInRequest->getCreated(), PDO::PARAM_INT);
        $stmt->bindValue(':hash', $optInRequest->getHash());
        $stmt->bindValue(':id', $optInRequest->getId(), PDO::PARAM_INT);
        $stmt->execute();

        return $this->get($optInRequest->getId());
    }

    public function delete($id) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM opt_in_request WHERE id = :id");
            $stmt->bindParam(":id", $id);
            $stmt->execute();

            // Return true if the deletion was successful
            return true;
        } catch (PDOException $e) {
            // Handle the exception
            echo "Error deleting opt-in request: " . $e->getMessage();
            return false;
        }
    }
}
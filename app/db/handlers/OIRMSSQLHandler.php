<?php

namespace db\handlers;

use db\OptInRequestSQLHandler;
use Exception;
use OptInRequest;
use PDO;
use PDOException;

class OIRMSSQLHandler implements OptInRequestSQLHandler {
    private $pdo;

    public function __construct($config) {
        $dsn = sprintf(
            'sqlsrv:Server=%s,%s;Database=%s',
            $config['db_host'],
            $config['db_port'],
            $config['db_name']
        );

        try {
            $this->pdo = new PDO($dsn, $config['db_user'], $config['db_pass']);
        } catch (PDOException $e) {
            throw new Exception('Could not connect to MSSQL database');
        }
    }
    public function get($id): ?OptInRequest {
        $stmt = $this->pdo->prepare("SELECT * FROM opt_in_request WHERE id = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch();
        if (!$result) {
            return null;
        }

        return new OptInRequest($result['id'], $result['site_id'], $result['site_name'], $result['phone'], $result['status'], $result['created'], $result['hash']);
    }

    public function getByHash($hash): ?OptInRequest {
        $stmt = $this->pdo->prepare("SELECT * FROM opt_in_request WHERE hash = :hash");
        $stmt->bindParam(":hash", $hash);
        $stmt->execute();

        $result = $stmt->fetch();
        if (!$result) {
            return null;
        }

        return new OptInRequest($result['id'], $result['site_id'], $result['site_name'], $result['phone'], $result['status'], $result['created'], $result['hash']);
    }

    public function create(OptInRequest $optInRequest): OptInRequest {
        $stmt = $this->pdo->prepare("INSERT INTO opt_in_request (site_id, site_name, phone, status, created, hash) 
                                     VALUES (:site_id, :site_name, :phone, :status, :created, :hash)");

        $data = $optInRequest->toArray();

        $stmt->bindParam(":site_id", $data['site_id']);
        $stmt->bindParam(":site_name", $data['site_name']);
        $stmt->bindParam(":phone", $data['phone'], PDO::PARAM_INT);
        $stmt->bindParam(":status", $data['status'], PDO::PARAM_INT);
        $stmt->bindParam(":created", $data['created'], PDO::PARAM_INT);
        $stmt->bindParam(":hash", $data['hash']);
        $stmt->execute();

        $id = $this->pdo->lastInsertId();
        return $this->get($id);
    }

    public function update($optInRequest): OptInRequest {
        $stmt = $this->pdo->prepare("UPDATE opt_in_request 
                                     SET site_id = :site_id, site_name = :site_name, phone = :phone, 
                                         status = :status, created = :created, hash = :hash 
                                     WHERE id = :id");

        $data = $optInRequest->toArray();

        $stmt->bindParam(":id", $data['id'], PDO::PARAM_INT);
        $stmt->bindParam(":site_id", $data['site_id']);
        $stmt->bindParam(":site_name", $data['site_name']);
        $stmt->bindParam(":phone", $data['phone'], PDO::PARAM_INT);
        $stmt->bindParam(":status", $data['status'], PDO::PARAM_INT);
        $stmt->bindParam(":created", $data['created'], PDO::PARAM_INT);
        $stmt->bindParam(":hash", $data['hash']);
        $stmt->execute();

        return $optInRequest;
    }

    public function delete($id): bool {
        $sql = "DELETE FROM `opt_in_request` WHERE `id` = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
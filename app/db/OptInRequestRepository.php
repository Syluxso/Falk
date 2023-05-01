<?php

namespace db;

require_once("OptInRequestSQLHandler.php");
require_once("handlers/OIRMSSQLHandler.php");
require_once("handlers/OIRMySQLHandler.php");

class OptInRequestRepository {
    private OptInRequestSQLHandler $handler;

    public function __construct(OptInRequestSQLHandler $handler) {
        $this->handler = $handler;
    }

    public function get($id) {
        return $this->handler->get($id);
    }

    public function create($data) {
        return $this->handler->create($data);
    }

    public function update($data) {
        return $this->handler->update($data);
    }

    public function delete($id) {
        return $this->handler->delete($id);
    }
}
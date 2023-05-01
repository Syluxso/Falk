<?php

namespace db;

use OptInRequest;

require_once(__DIR__."/../core/model/OptInRequest.php");

interface OptInRequestSQLHandler {
    public function __construct($config);
    public function get($id);
    public function create(OptInRequest $optInRequest);
    public function update($optInRequest);
    public function delete($id);
}
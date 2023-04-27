<?php

require_once 'controllers/SyNT.php';
require_once 'controllers/NyTechPhone.php';
require_once 'controllers/DBConnect.php';
require_once 'controllers/SMSSend.php';


class NewInvite {

  function __construct($args, $config) {
    $this->args = $args;
    $this->config = $config;
    $this->phone();
    $this->site_id = $this->args['get']['site_id'];
    $this->site_name = $this->args['get']['site_name'];
    $this->created = time();
    new SMSSend($this->phone, $this->site_name, 'https://www.nybergtechnology.com', $this->config);
    // $this->create();
  }

  private function phone() {
    $this->phone_validates = false;
    if(!empty($this->args['get']['phone'])) {
      $this->phone = NyTechPhone::clean_phone($this->args['get']['phone']);
      if(strlen($this->phone) == 10) {
        $this->phone_validates = true;
      }
    }
  }

  private function create() {
    $e = 'Malformed request.';
    if(!empty($this->site_id) && !empty($this->site_name) && !empty($this->phone_validates)) {
      try {
        $db = new DBConnect();
        $args = [
          ':site_id' => $this->site_id,
          ':site_name' => $this->site_name,
          ':phone' => $this->phone,
          ':created' => time(),
        ];
        $query = '
        INSERT INTO `site_request` (`site_id`, `site_name`, `phone`, `created`) 
        VALUES (:site_id, :site_name, :phone, :created)';
        $db->db_query($query, $args);
        $this->code = 201;
        $this->message = '';
        $this->data = ['Record created', $this->args['get']];
      } catch (Exception $e) {

      }
    }
    $this->code = 400;
    $this->message = 'Error creating database';
    $this->data = ['error' => $e];
  }

  public function synt() {
    return new SyNT($this->code, $this->message, $this->data);
  }
}
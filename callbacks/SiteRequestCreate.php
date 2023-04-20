<?php

class SiteRequestCreate {
  public $site_id;
  public $site_name;
  public $phone;
  public $created;

  function __construct($site_id, $site_name, $phone) {
    $this->site_id = $site_id;
    $this->site_name = $site_name;
    $this->phone($phone);
    $this->created = time();
    $this->create();
  }

  private function phone($phone) {
    if(!empty($phone)) {
      $this->phone = NyTechPhone::clean_phone($phone);
    }
  }

  private function create() {
    if(!empty($this->site_id) && !empty($this->site_name) && !empty($this->phone)) {
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
    }
  }
}
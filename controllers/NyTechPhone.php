<?php

class NyTechPhone {
  static function pretty_phone($phone) {
    $phone = preg_replace('/^\+?1|\|1|\D/', '', ($phone));;
    $phone = NyTechPhone::clean_phone($phone);
    $phone = preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "($1) $2-$3", $phone);
    return $phone;
  }

  static function clean_phone($phone) {
    $phone = preg_replace('/[^0-9]/', '', $phone);
    return $phone;
  }

  static function pretty_phone_dashes($phone) {
    $phone = preg_replace('/^\+?1|\|1|\D/', '', ($phone));;
    $phone = NyTechPhone::clean_phone($phone);
    $phone = preg_replace("/^1?(\d{3})(\d{3})(\d{4})$/", "$1-$2-$3", $phone);
    return $phone;
  }
}
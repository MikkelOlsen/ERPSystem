<?php

class Service extends Database
{
    public static function fetchServices(String $id) : array {
      return (new self)->query("SELECT
                                service.id, service.name, service.hours, service.rate, service.approved, SUM(service.rate * service.hours) AS total
                                FROM service
                                WHERE service.invoiceId = :ID
                                GROUP BY service.id", [':ID' => $id])->fetchAll();
    }

  public static function updateService(String $id, String $name, String $hours, String $rate) {
    try {
      (new self)->query("UPDATE service SET name = :NAME, hours = :HOURS, rate = :RATE, approved = 1 WHERE id = :ID", 
      [
        ':NAME' => $name,
        ':HOURS' => $hours,
        ':RATE' => $rate,
        ':ID' => $id
      ]);
      return true;
    } catch (PDOException $e) {
      echo $e->getMessage();
      return false;
    }
  }

  public static function serviceCheck(String $id) : array {
    return (new self)->query("SELECT
                                service.id
                                FROM service
                                WHERE service.invoiceId = :ID 
                                AND service.approved = 0
                                GROUP BY service.id", [':ID' => $id])->fetchAll();
  }

}

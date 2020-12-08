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

}

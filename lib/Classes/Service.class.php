<?php

class Service extends Database
{
  /**
   * Returns all services where the invoice ID matches the parameter
   *
   * @param String $id
   * @return array
   */
    public static function fetchServices(String $id) : array {
      return (new self)->query("SELECT
                                service.id, service.name, service.hours, service.rate, service.approved, SUM(service.rate * service.hours) AS total
                                FROM service
                                WHERE service.invoiceId = :ID
                                GROUP BY service.id", [':ID' => $id])->fetchAll();
    }

    /**
     * Update service based on ID
     *
     * @param String $id
     * @param String $name
     * @param String $hours
     * @param String $rate
     * @return void
     */
  public static function updateService(String $id, String $name, String $hours, String $rate) {
    try {
      (new self)->query("UPDATE service SET name = :NAME, hours = :HOURS, rate = :RATE, approved = 1 WHERE id = :ID", 
      [
        ':NAME' => $name,
        ':HOURS' => $hours,
        ':RATE' => $rate,
        ':ID' => $id
      ]);
      Log::insertLog("Service with id: " . $id . ' - updated & approved. </br> {Name: ' . $name . ', Hours: ' . $hours . ', Rate: '. $rate, 0 );
      return true;
    } catch (PDOException $e) {
      echo $e->getMessage();
      return false;
    }
  }

  /**
   * Check if there are any services that are unapproved on a specified invoice ID
   *
   * @param String $id
   * @return array
   */
  public static function serviceCheck(String $id) : array {
    return (new self)->query("SELECT
                                service.id
                                FROM service
                                WHERE service.invoiceId = :ID 
                                AND service.approved = 0
                                GROUP BY service.id", [':ID' => $id])->fetchAll();
  }

}

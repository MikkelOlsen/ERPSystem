<?php

class Invoice extends Database
{

    /**
     * Undocumented function
     *
     * @return array
     */
    public static function fetchAllInvoices() : array {
      return (new self)->query("SELECT
                                invoice.id AS invoiceid, invoice.company, invoice.date, invoice.billedTo, invoice.approved AS invoiceApproved, service.id AS serviceid, service.name, service.hours, service.rate, service.approved AS serviceApproved, SUM(service.hours * service.rate) AS total
                                FROM service
                                INNER JOIN invoice
                                ON invoice.id = service.invoiceId
                                GROUP BY invoice.id")->fetchAll();
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    public static function fetchApprovedInvoices() : array {
      return (new self)->query("SELECT
                                invoice.id AS invoiceid, invoice.company, invoice.date, invoice.billedTo, invoice.approved AS invoiceApproved, service.id AS serviceid, service.name, service.hours, service.rate, service.approved AS serviceApproved, SUM(service.hours * service.rate) AS total
                                FROM service
                                INNER JOIN invoice
                                ON invoice.id = service.invoiceId 
                                WHERE invoice.approved = 1
                                GROUP BY invoice.id")->fetchAll();
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    public static function fetchNotApprovedInvoices() : array {
      return (new self)->query("SELECT
                                invoice.id AS invoiceid, invoice.company, invoice.date, invoice.billedTo, invoice.approved AS invoiceApproved, service.id AS serviceid, service.name, service.hours, service.rate, service.approved AS serviceApproved, SUM(service.hours * service.rate) AS total
                                FROM service
                                INNER JOIN invoice
                                ON invoice.id = service.invoiceId
                                WHERE invoice.approved = 0
                                GROUP BY invoice.id")->fetchAll();
    }

    /**
     * Undocumented function
     *
     * @param String $id
     * @return object
     */
    public static function fetchSingleInvoice(String $id) : object {
      return (new self)->query("SELECT
                                invoice.id AS invoiceid, invoice.company, invoice.date, invoice.billedTo, invoice.approved AS invoiceApproved, service.id AS serviceid, service.name, service.hours, service.rate, service.approved AS serviceApproved, SUM(service.hours * service.rate) AS total
                                FROM service
                                INNER JOIN invoice
                                ON invoice.id = service.invoiceId
                                GROUP BY invoice.id
                                WHERE invoice.id = :ID", [':ID' => $id])->fetch();
    }

    /**
     * Undocumented function
     *
     * @param String $id
     * @return void
     */
    public static function updateInvoice(String $id) {
      try {
        (new self)->query("UPDATE invoice SET approved = 1 WHERE id = :ID", 
        [
          ':ID' => $id
        ]);       
        return true;
      } catch (PDOException $e) {
        echo $e->getMessage();
        return false;
      }
    }

}

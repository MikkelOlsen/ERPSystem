<?php

class Invoice extends Database
{

  public static function showdb() : array {
    return (new self)->query("SHOW TABLES")->fetchAll();
  }


    public static function fetchAllInvoices() : array {
      return (new self)->query("SELECT
                                invoice.id AS invoiceid, invoice.company, DATE_FORMAT(invoice.date, '%D of %M - %Y') AS date, invoice.billedTo, invoice.approved AS invoiceApproved, service.id AS serviceid, service.name, service.hours, service.rate, service.approved AS serviceApproved, SUM(service.hours * service.rate) AS total
                                FROM service
                                INNER JOIN invoice
                                ON invoice.id = service.invoiceId
                                GROUP BY invoice.id")->fetchAll();
    }

    public static function fetchApprovedInvoices() : array {
      return (new self)->query("SELECT
                                invoice.id AS invoiceid, invoice.company, DATE_FORMAT(invoice.date, '%D of %M - %Y') AS date, invoice.billedTo, invoice.approved AS invoiceApproved, service.id AS serviceid, service.name, service.hours, service.rate, service.approved AS serviceApproved, SUM(service.hours * service.rate) AS total
                                FROM service
                                INNER JOIN invoice
                                ON invoice.id = service.invoiceId 
                                WHERE invoice.approved = 1
                                GROUP BY invoice.id")->fetchAll();
    }

    public static function fetchNotApprovedInvoices() : array {
      return (new self)->query("SELECT
                                invoice.id AS invoiceid, invoice.company, DATE_FORMAT(invoice.date, '%D of %M - %Y') AS date, invoice.billedTo, invoice.approved AS invoiceApproved, service.id AS serviceid, service.name, service.hours, service.rate, service.approved AS serviceApproved, SUM(service.hours * service.rate) AS total
                                FROM service
                                INNER JOIN invoice
                                ON invoice.id = service.invoiceId
                                WHERE invoice.approved = 0
                                GROUP BY invoice.id")->fetchAll();
    }

    public static function fetchSingleInvoice(String $id) : object {
      return (new self)->query("SELECT
                                invoice.id AS invoiceid, invoice.company, DATE_FORMAT(invoice.date, '%D of %M - %Y') AS date, invoice.billedTo, invoice.approved AS invoiceApproved, service.id AS serviceid, service.name, service.hours, service.rate, service.approved AS serviceApproved, SUM(service.hours * service.rate) AS total
                                FROM service
                                INNER JOIN invoice
                                ON invoice.id = service.invoiceId
                                GROUP BY invoice.id
                                WHERE invoice.id = :ID", [':ID' => $id])->fetch();
    }

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

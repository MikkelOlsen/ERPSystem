<?php

class Invoice extends Database
{


    public static function getInvoice() : array {
      return (new self)->query("SELECT * FROM heroku_10c337ec6ca316c.estimations")->fetchAll();
    }

}

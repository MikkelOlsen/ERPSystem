<?php

class Log extends Database
{
  public static function fetchStatusLogs() : array {
      return (new self)->query("SELECT date, message
                                FROM log
                                WHERE error = 0")->fetchAll();
  }

  public static function fetchErrorLogs() : array {
    return (new self)->query("SELECT date, message
                              FROM log
                              WHERE error = 1")->fetchAll();
}

}

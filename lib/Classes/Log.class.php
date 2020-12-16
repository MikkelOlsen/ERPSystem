<?php

class Log extends Database
{
  /**
   * Undocumented function
   *
   * @return array
   */
  public static function fetchStatusLogs() : array {
      return (new self)->query("SELECT date, message
                                FROM log
                                WHERE error = 0")->fetchAll();
  }

  /**
   * Undocumented function
   *
   * @return array
   */
  public static function fetchErrorLogs() : array {
    return (new self)->query("SELECT date, message
                              FROM log
                              WHERE error = 1")->fetchAll();
}

public static function insertLog(string $message, int $error) : bool {
  try {
    (new self)->query("INSERT INTO log (message, error) VALUES (:MSG, :ERR)", [
      ':MSG' => $message,
      ':ERR' => $error
    ]);
    return true;
  } catch (PDOException $e) 
  {
      return false;
  }
}

}

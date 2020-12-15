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

}

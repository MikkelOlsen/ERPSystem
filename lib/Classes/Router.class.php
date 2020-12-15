<?php
/**
 * Routing Class
 */
class Router extends \PDO
{

  public static       $Params   = [],
                      $BASE     = null,
                      $View     = null,
                      $Title    = null,
                      $Layout   = null;

  private static      $RouteIndex    = null,
                      $Routes        = null,
                      $REQ_ROUTE     = null,
                      $DefaultRoute  = null,
                      $ViewFolder    = null,
                      $errorPagePath = null,
                      $currentRoute  = null;  

  /**
   * Validate that given keys all exists in the array
   * Method is called on L. 151 - Here we check all routes from Router config contains a path and a view key.
   *
   * @param array $routes
   * @param array $keys
   * @return boolean
   */
  public static function ValidateRoutes(array $routes, array $keys) : bool
  {
      $errors = 0;
      foreach($routes as $route)
      {
          if(!Helpers::array_key_exists_r($keys, $route))
          {
              $errors++;
          }
      }
      return ( $errors === 0 );
  }

  /**
   * Override class private variable ViewFolder
   *
   * @param string $viewfolder
   * @return void
   */
  public static function SetViewFoler(string $viewfolder) : void
    {
        self::$ViewFolder = $viewfolder;
    }

    /**
     * Return class private variable ViewFolder
     *
     * @return string
     */
    public static function GetViewFolder() : string
    {
        return self::$ViewFolder;
    }

    /**
     * Override class private variable DefaultRoute
     *
     * @param string $route
     * @return void
     */
    public static function SetDefaultRoute(string $route) : void
    {
        self::$DefaultRoute = $route;
    }

    /**
     * Override class private variable Layout
     *
     * @param string $layout
     * @return void
     */
    public static function SetDefaultLayout(string $layout) : void
    {
        self::$Layout = $layout;
    }

    /**
     * Override class private variable errorPagePath
     *
     * @param string $path
     * @return void
     */
    public static function SetErrorPath(string $path) : void
    {
        self::$errorPagePath = $path;
    }

    public static function Redirect(string $location) : void
    {
        ob_start();
        header('Location:' . rtrim(self::$BASE, '/') . $location);
        exit;
    }


   /**
   * This is the method that handles all rewrited URL data along with all initialization of URL handling.
   * It finds the required URL by removing the root from the complete URL entered in the browser.
   * the required URL is split into an array by "/" as a seperator
   *
   * @param string $url
   * @param array $routes
   * @return void
   */
  public static function init(string $url, array $routes) : void
  {
    echo 'URL ----> ' . $url;
    if(self::ValidateRoutes($routes, ['path', 'view'])){
    self::$Routes = $routes;
    $url = Filter::SanitizeURL($url);
    self::$BASE = substr($_SERVER['PHP_SELF'], 0, strpos($_SERVER['PHP_SELF'], 'index.php'));
    self::$REQ_ROUTE = '/'.str_replace(strtolower(self::$BASE), '', strtolower($url));
    $newPath = explode('/', rtrim(self::$REQ_ROUTE, '/'));
    $newPath = array_splice($newPath, 1, count($newPath)-1);
    $routePath = [];
    $match = false;
    

    foreach(self::$Routes as $routeIdx => $route) {

      $pathCount = count(explode('/', $route['path'])) -1;
      $Params = [];
      $path = NULL;

      for($pCnt = 0; $pCnt < $pathCount; $pCnt++){
        if(isset($newPath[$pCnt])) {
          $path .= '/'.$newPath[$pCnt];
        }
      }

      
      if(strtolower($route['path']) === strtolower($path)) {
        $routeExplode = explode('/', $route['path']);
        $routePath[] = array_splice($routeExplode, 1, count($routeExplode)-1);

   

    $counter = max($routePath);
    $routingPath = NULL;

    for($x = 0; $x < sizeof($counter); $x++) {
      $routingPath .= '/'.$counter[$x];
    }

    foreach(self::$Routes as $routeIndex => $singleRoute) {
      if(strtolower($routingPath) === strtolower($singleRoute['path'])) {
        self::$RouteIndex = $routeIndex;
        $match = true;
        $URLparams = array_slice($newPath, $x, count($newPath));
        self::$View = self::$ViewFolder . DS . $singleRoute['view'];

        if(array_key_exists('layout', $singleRoute) && !empty($singleRoute['layout'])) 
        {
          self::$Layout = $singleRoute['layout'];
        }
        if(array_key_exists('title', $singleRoute) && !empty($singleRoute['title'])) 
        {
          self::$Title = $singleRoute['title'];
        }
        if(array_key_exists('params', $singleRoute) && sizeof($singleRoute['params']) > 0)
        {
            for($ParamCnt = 0; $ParamCnt < count($URLparams); $ParamCnt++)
            {
                if(isset($singleRoute['params'][$ParamCnt]))
                {
                    self::$Params[$singleRoute['params'][$ParamCnt]] = $URLparams[$ParamCnt];
                }
                else
                {
                    self::$Params[] = $URLparams[$ParamCnt];
                }
            }
        }
      }
    }
  }
}

    if($match == false)  
    {
      if(!empty(self::$DefaultRoute) && self::$REQ_ROUTE === '/') 
      {
        foreach(self::$Routes as $route) 
        {
          if(self::$DefaultRoute == $route['path'])
          {
            self::Redirect($route['path']);
          }
        }
      }
      if(file_exists(self::$ViewFolder . 'Error' . DS . '404.view.php'))
      {
        self::Redirect(self::$errorPagePath . '/404' . $path); 
      }
      else
      {
          header("HTTP/1.0 404 Not Found");
          exit;
      }
    } else if($match == true)
    {
      self::$currentRoute = self::$Routes[self::$RouteIndex]['path'];
    } 
  }
}

public static function IsActive(string $route, string $activeCLass) : string
{
    return strtolower($route) === strtolower(self::$currentRoute) ? $activeCLass : '';
} 
}


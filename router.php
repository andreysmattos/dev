<?php defined('_JEXEC') or die;

class webcursoRouter extends JComponentRouterBase{
	
	public function build(&$query)	{
		$segments = array();
    if (isset($query['component']))
       {
                $segments[] = $query['component'];
                unset($query['component']);
       };
       if (isset($query['view']))
       {
                $segments[] = $query['view'];
                unset($query['view']);
       }
       if (isset($query['alias']))
       {
                $segments[] = $query['alias'];
                unset($query['alias']);
       };
       
       return $segments;
	}
	
	public function parse(&$segments){
		 $vars = array();
       switch($segments[0]){
               case 'webcategoria':
                       $vars['view'] = 'webcategoria';
                       $id = explode(':', $segments[1]);
                       $vars['id'] = (int) $id[0];
                       break;
               case 'webcurso':
                       $vars['view'] = 'webcurso';
                       $id = explode(':', $segments[1]);
                       $vars['id'] = (int) $id[0];
                       break;
       }
       return $vars;
	}
}

/**
 * webcurso router functions
 *
 * These functions are proxys for the new router interface
 * for old SEF extensions.
 *
 * @param   array  &$query  An array of URL arguments
 *
 * @return  array  The URL arguments to use to assemble the subsequent URL.
 *
 * @deprecated  4.0  Use Class based routers instead
 */
function webcursoBuildRoute(&$query){
	$router = new webcursoRouter;
	return $router->build($query);
}

/**
 * Parse the segments of a URL.
 *
 * This function is a proxy for the new router interface
 * for old SEF extensions.
 *
 * @param   array  $segments  The segments of the URL to parse.
 *
 * @return  array  The URL attributes to be used by the application.
 *
 * @since   3.3
 * @deprecated  4.0  Use Class based routers instead
 */
function webcursoParseRoute($segments){
	$router = new webcursoRouter;
	return $router->parse($segments);
}

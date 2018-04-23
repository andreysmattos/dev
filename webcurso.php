<?php
defined('_JEXEC') or die('Restricted access');
 
// Get an instance of the controller prefixed by HelloWorld
$controller = JControllerLegacy::getInstance('webcurso');
 
// Perform the Request task
$input = JFactory::getApplication()->input;
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
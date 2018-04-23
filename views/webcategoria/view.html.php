<?php defined('_JEXEC') or die('Restricted access');
 
class webcursoViewwebcategoria extends JViewLegacy{
	//protected $categories;	
	function display($tpl = null){		
		$app = JFactory::getApplication();
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		
		$oficina = new webcursoModelwebcategoria();
		$veroficina = $oficina->oficinas();
		$this->ofi = $veroficina;
		/*if ($veroficina) {
			$this->teste = 1;
		}*/

		// Check for errors.
		if (count($errors = $this->get('Errors'))){
			JError::raiseError(500, implode('<br />', $errors)); 
			return false;
		}
		// Display the template
		parent::display($tpl);
	}
}

<?php defined('_JEXEC') or die('Restricted access');
class webcursoViewwebcurso extends JViewLegacy{
	
	function display($tpl = null){

		

		$app = JFactory::getApplication();
		$this->items = $this->get('Items');
	
		$insere = new webcursoModelwebcurso();
		//$inserir = $insere->verify_email($_POST['email_aluno']);
		$inserir = $insere->getInsertQuery();



		if (count($errors = $this->get('Errors'))){
			JError::raiseError(500, implode('<br />', $errors)); 
			return false;
		}
		parent::display($tpl);		
	}
}
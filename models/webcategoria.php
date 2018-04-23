<?php defined('_JEXEC') or die('Restricted access');

class webcursoModelwebcategoria extends JModelList{	
 	protected function getListQuery(){
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->from($db->quoteName('#__inscricao','a'));
		$query->select('*')			  
			  ->order($db->quoteName('data_criacao'));
		$query->select($db->quoteName('a.nome', 'nome'));
		$query->select($db->quoteName('a.alias', 'url'));
		$query->select($db->quoteName('a.idInsc', 'id'));
		$query->select($db->quoteName('c.title', 'category_title'))
			->join('LEFT', $db->quoteName('#__categories', 'c')
				. ' ON ' . $db->quoteName('c.id') . ' = ' . $db->quoteName('a.catid'));	
		//$query->where("a.oficina = 'n'");		
		//Chama os campos adicionais do item de menu
		$jinput = JFactory::getApplication()->input;		
		$setarCategoria = $jinput->get('categoria','','int'); 
		if (!empty($setarCategoria) OR $setarCategoria != 0) {	
			$query->where('a.published = 1 AND catid = '.$setarCategoria);
		} else {
			$query->where('a.published = 1');
		}
		//condição se clicar o curso

		if (isset($_GET['curso']) AND !empty($_GET['curso'])){
			$query->where('a.published = 1 AND a.id = '.$_GET['curso']);
		}
		$results = $db->loadObjectList();
		return $query;
				
	}
	//Carrega a função que controla o LIMITE e o Inicio da paginação
	protected function populateState($ordering = null, $direction = null){
    	$this->setState('list.start', 0); // 0 = inicio
    	$this->setState('list.limit', 0); // 0 = Sem limite
    }
    public function oficinas(){
    	/*$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->from($db->quoteName('#__inscricao','a'));
		$query->select('*');
		$query->where("a.oficina = 's' AND a.published = 1");		
		$db->setQuery($query);
		$db->execute();
		$num_rows = $db->getNumRows();
		return $num_rows;*/
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->from($db->quoteName('#__inscricao','a'));
		$query->select('*')			  
			  ->order($db->quoteName('data_criacao'));
		$query->where("a.oficina = 's' AND a.published = 1");
		$vamos = $db->loadRowList();
		return $vamos;
    }
    
 }
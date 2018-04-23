<?php //defined('_JEXEC') or die('Restricted access');

class webcursoModelwebcurso extends JModelList{


	public function registra_cadastro_dados_pedido($id_curso, $nome, $email, $telefone, $senha1, $senha2, $endereco, $bairro, $cidade, $uf, $instituicao, $area)
	{
		jimport('joomla.user.helper');
		$data = array(
			"name"=>$nome,
			"username"=>$email,
			"password"=>$senha1,
			"password2"=>$senha2,
			"email"=>$email,
			"block"=>0,
			"groups"=>array("2")
		); 
		$user = new JUser;
		//Grava no database
		if(!$user->bind($data)) {
			echo json_encode(['status'=>false, 'msg'=>'erro_juser_bind', 'nome'=>$nome, 'email'=>$email, 'telefone'=>$telefone, 'senha1'=>'habilita_no_model', 'email'=>$email, 'data'=>'habilita_no_model', 'user'=>'habilita_no_model']);
			exit();
		}

		if (!$user->save()) {
			echo json_encode(['status'=>false, 'msg'=>'erro_juser_save']);
			exit();		
		}

		//isso aki serve apenas pra buscar o ID, e também já verifica se o cadastro foi feito mesmo
		if($id = $this->verify_email($email)){
			if($this->adiciona_dados_nova_tabela($id, $endereco, $bairro, $cidade, $uf, $instituicao, $area, $telefone))
			{
				if($this->registra_pedido($id, $id_curso)){
					echo json_encode(['status'=>true, 'msg'=>'joomla_tabela_nova_pedido_registrado']);
					exit();	
					
				} else {
					echo json_encode(['status'=>false, 'msg'=>'problema_registra_cadastro_dados_pedido_registra_pedido']);
					exit();
				}
			} else {


				echo json_encode(['status'=>false, 'msg'=>'problema_registra_cadastro_dados_pedido_adiciona_dados_nova_tabela']);
				exit();
			} 
		} else {
			echo json_encode(['status'=>false, 'msg'=>'problema_registra_cadastro_dados_pedido_verify_email']);
			exit();	
		}

	}


	public function adiciona_dados_nova_tabela($id_joomla, $endereco, $bairro, $cidade, $uf, $instituicao, $area, $telefone)
	{

		try {

			$db = JFactory::getDbo();

			$query = $db->getQuery(true);

			$columns = array(
				'id_joomla',
				'telefone',
				'uf',
				'cidade',
				'bairro',
				'endereco',
				'instituicao',
				'area'
			);

			$values = array($id_joomla, $db->quote($telefone), $db->quote($uf), $db->quote($cidade), $db->quote($bairro), $db->quote($endereco), $db->quote($instituicao), $db->quote($area));


			$query
			->insert($db->quoteName('#__usuarios_novo'))
			->columns($db->quoteName($columns))
			->values(implode(',', $values));


			$db->setQuery($query);



			if($r = $db->execute()){
				return true;
			}

			return false;


		} catch (Exception $e) {
			echo json_encode(['status'=>false, 'error'=>$e->getMessage(), 'dberror'=>$db->getErrorNum(),
				'query'=>$query->__toString()]);
			exit();

		}
	}


	// esse metodo só é chamado quando o usuario tem cadastro no joomla e precisa verificar se já adicionou os dados extras (area, instituicao, endereco, ect) na nossa nova tabela
	public function verifica_dados_adicionais($id_aluno)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->
		select('idUser')
		->from($db->quoteName('#__usuarios_novo','u'))
		->where("id_joomla='".$id_aluno."'");
		$db->setQuery($query);
		$count = $db->loadObject();

		if(!empty($count)){
			return $count->idUser;
		}

		return false;
	}


	/*	esse metodo verifica se o usuario já está ou não cadastrado no curso! */
	public function verifica_pedido($id_aluno, $id_curso){

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->
		select('*')
		->from($db->quoteName('#__pedidos','u'))
		->where("id_user='".$id_aluno."' AND id_insc = '". $id_curso . "'");
		$db->setQuery($query);
		$count = $db->loadObject();

		if(!empty($count)){
			return $count->idPedidos;
		}

		return false;

	}


	/*	esse metodo registra o pedido. LEMBRAR DE TIRAR A CHAVE ESTRANGEIRA DA TABELA ORIGINAL*/
	public function registra_pedido($id_aluno, $id_curso){


		$db = JFactory::getDbo();

		$query = $db->getQuery(true);

		$columns = array('id_user', 'id_insc');

		$values = array($id_aluno, $id_curso);


		$query
		->insert($db->quoteName('#__pedidos'))
		->columns($db->quoteName($columns))
		->values(implode(',', $values));


		$db->setQuery($query);



		if($r = $db->execute()){
			return true;
		}

		return false;



	}


	/* Verifica se existe um email na tabela do joomla.
		Caso existir retorna o ID do registro.
		Caso não existir retorna FALSE
	*/
		public static function verify_email($email)
		{

			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->
			select('id')
			->from($db->quoteName('#__users','u'))
			->where("username='".$email."'");
			$db->setQuery($query);
			$count = $db->loadObject();

			if(!empty($count)){
				return $count->id;
			}

			return false;
		}


		function getInsertQuery() {
			$db = JFactory::getDbo(); 
			$db2 = JFactory::getDbo(); 
			$query = $db->getQuery(true);
			$query2 = $db->getQuery(true);
			$hoje = date('Y-m-d H:i:s');		
			if (isset($_POST['enviar']) && isset($_POST['email_aluno'])){

				$query->select('COUNT(username)')->from($db->quoteName('#__users','u'))->where("username='".$_POST['email_aluno']."'");
				$db->setQuery($query);
				$count = $db->loadResult();

				if($_POST['senha1'] != $_POST['senha2']){
					echo "<div class='alert alert-warning'>As senhas não conferem.</strong></div>"; 
					return false;

				}

			//if(false){
				if($count < 1){
					self::CriarUser();
				//echo "<div class='alert alert-warning'>O e-mail ".$_POST['email_aluno']." já está cadastrado! Selecione a opção <strong>Já possuo cadastro.</strong></div>"; 					
				}
			/*	$query->from($db->quoteName('#__webcurso','a'));
				$query->select('a.title, a.preco')->where('a.id = '.$_POST['id_curso']);
				$db->setQuery($query);
				$row = $db->loadObjectList();
				*/

				#nossa tabela
				$db->setQuery(true);
				$query->insert('#__usuarios_insc')
				->columns('nome, email, telefone, uf, cidade, bairro, endereco, password')
				->values(
					$db->quote($_POST['nome_aluno']). ', ' . 
					$db->quote($_POST['email_aluno']). ', ' . 
					$db->quote($_POST['telefone']). ', ' . 
					$db->quote($_POST['uf']). ', ' . 
					$db->quote($_POST['cidade']). ', ' . 
					$db->quote($_POST['bairro']). ', ' . 
					$db->quote($_POST['endereco']). ', ' . 
					$db->quote($_POST['password']));		 			 
				$db->setQuery($query);
				$result = $db->execute();
				$id_inserido = $db->insertid();


					#tabela pedidos
				
				$db2->setQuery(true);
				$query2->insert('#__pedidos')
				->columns('id_user, id_insc')
				->values(
					$db2->quote($id_inserido). ', ' . 
					$db2->quote($_POST['id_curso']));		 			 
				$db2->setQuery($query2);
				$result = $db2->execute();
				$id_inserido2 = $db2->insertid();
				
				#nossa tabela

				self::EnviaEmail($id_inserido2); 


				/*
				$query->insert('#__webcurso_pedidos')
				->columns('id_curso, data_pedido, curso, nome_aluno, email_aluno, telefone, preco, forma_pagamento, status')
				->values(
					$db->quote($_POST['id_curso']). ', ' . 
					$db->quote($hoje). ', ' . 
					$db->quote($row[0]->title). ', ' . 
					$db->quote($_POST['nome_aluno']). ', ' . 
					$db->quote($_POST['email_aluno']). ', ' . 
					$db->quote($_POST['telefone']). ', ' . 
					$db->quote($row[0]->preco). ', ' .
					$db->quote($_POST['forma_pagamento']). ', ' .
					$db->quote("0"));			 			 
				$db->setQuery($query);
				$result = $db->execute();
				$id_inserido = $db->insertid();

				self::EnviaEmail($id_inserido); 	
				*/		 

		/*if ($_POST['cadastro'] == 1){
			if($count == 0){
				echo "<div class='alert alert-warning'>Você ainda não tem cadastro! Verique se o email digitado está correto ou selecione a opção <strong>Não possuo cadastro.</strong></div>";
			}else{
				$query->select('u.name, u.email')->where("u.username='".$_POST['email_aluno']."'");
				$db->setQuery($query);

				$query->select('a.title, a.preco')->from($db->quoteName('#__webcurso','a'))->where('a.id = '.$_POST['id_curso']);
				$db->setQuery($query);				 
				$row = $db->loadObjectList();

				$query->insert('#__webcurso_pedidos')
				->columns('id_curso, data_pedido, curso, nome_aluno, email_aluno, preco, forma_pagamento, status')
				->values(
					$db->quote($_POST['id_curso']). ', ' . 
					$db->quote($hoje). ', ' . 
					$db->quote($row[0]->title). ', ' . 
					$db->quote($row[0]->name). ', ' . 
					$db->quote($row[0]->email). ', ' . 
					$db->quote($row[0]->preco). ', ' .
					$db->quote($_POST['forma_pagamento']). ', ' .
					$db->quote("0"));			 			 
				$db->setQuery($query);
				$result = $db->execute();
				$id_inserido = $db->insertid();
				self::EnviaEmail($id_inserido);	 			 
			}		
			} *///cadastro			
		}
	}//function

	//Criar Usuário
	public static function CriarUser(){
		jimport('joomla.user.helper');
		$data = array(
			"name"=>$_POST['nome_aluno'],
			"username"=>$_POST['email_aluno'],
			"password"=>$_POST['senha1'],
			"password2"=>$_POST['senha2'],
			"email"=>$_POST['email_aluno'],
			"block"=>0,
			"groups"=>array("2")
		); 
		$user = new JUser;
		//Grava no database
		if(!$user->bind($data)) {
			throw new Exception("Erro: " . $user->getError());
		}
		if (!$user->save()) {
			throw new Exception("Erro: " . $user->getError());
		}
	}

	public static function EnviaEmail($pedido){
    	//E-mail para o ADM
		$mailer = JFactory::getMailer();
		$config = JFactory::getConfig();
		$sender = array( $config->get( 'mailfrom' ), $config->get( 'fromname' ));
		$mailer->setSender($sender);
		$user = JFactory::getUser();
		//$recipient = array( $config->get( 'mailfrom' ));
		//$mailer->addRecipient($recipient);
		$mailer->setSubject('Salão ICFUC');

		$db = JFactory::getDbo(); 
		$query = $db->getQuery(true);
		$query->from($db->quoteName('#__inscricao','a'))
		->select('a.nome')->where('a.idInsc = '.$_POST['id_curso']);
		$db->setQuery($query);
		$row = $db->loadObjectList();
		$curso = $row[0]->nome;

		$email = $_POST['email_aluno'];


		$nome = $_POST['nome_aluno'];


		$telefone = $_POST['telefone'];

		if($_POST['id_curso'] == 10){
			$key = 'icfuc2018';
		} elseif ($_POST['id_curso'] == 1) {
			$key = 'metodologia2018';
		}

		if(isset($key)){
			$msg_key = '<p>Utilize a Chave de inscrição abaixo:</p>

			<p> <strong style="font-size: 16px">'.$key.' </strong></p>';

			$body = '<p>Olá, </p>
			<p>você se inscreveu para o '.$curso.'. </p>

			<p>Para enviar seu trabalho acesse:
			https://www.salaoicfuc.com.br/academico/ </p>

			' . $msg_key;

		} else {
			$body = 'Você se inscreveu para o Salão de Iniciação Científica do IC/FUC. <br>Acompanhe as notícias em nosso site.';
		}
		
		

		

		
		/*$body  = '<div>'.$emailAdm.'</div>
		<h2>Segue dados abaixo:</h2>
		<p>Pedido: '.$pedido.'</p>
		<p>Nome: '.$nome.'<br/>
		E-mail: '.$email.'<br/>
		Telefone: '.$telefone.' <br/>
		Curso: '.$curso.' <br/>
		</p>
		'; 

		$mailer->isHtml(true);
		$mailer->Encoding = 'base64';
		$mailer->setBody($body);
		$send = $mailer->Send();
		if ( $send !== true ) {
			echo '<div class="alert alert-warning">Erro ao enviar o e-mail!</div> ';
		}

		*/
		//E-mail cliente / aluno
		$mailer->isHtml(true);
		$mailer->Encoding = 'base64';
		$recipient2 = array($email);
		$mailer->addRecipient($recipient2);
		$mailer->setBody($body);
		$send = $mailer->Send();
		if ( $send !== true ) {
			echo '<div class="alert alert-warning">Erro ao enviar o e-mail!</div> ';
		}
	}

	protected function getListQuery(){
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->from($db->quoteName('#__inscricao','a'));
		$query->select('*');		  
		$query->select($db->quoteName('a.nome', 'titulo'));
		$query->select($db->quoteName('a.idInsc', 'id'));
		$query->select($db->quoteName('c.title', 'category_title'))
		->join('LEFT', $db->quoteName('#__categories', 'c')
			. ' ON ' . $db->quoteName('c.id') . ' = ' . $db->quoteName('a.catid'));
		
		//Chama os campos adicionais do item de menu
		$jinput = JFactory::getApplication()->input;		
		$setarCurso = $jinput->get('curso','','int'); 
		if (!empty($setarCurso) OR $setarCurso != 0) {
			$query->where('a.published = 1 AND a.idInsc = '.$setarCurso);
		} else {
			$query->where('a.published = 1');
		}
		$results = $db->loadObjectList();
		return $query;			
	}
	
}

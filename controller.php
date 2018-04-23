<?php defined('_JEXEC') or die('Restricted access');

class webcursoController extends JControllerLegacy{

	//andrey
	public function ajax(){
		$op = filter_input(INPUT_POST, 'novo', FILTER_VALIDATE_INT);


		switch ($op) {
			case 0:
			$this->inicio();
			break;

			case 1:
			if(isset($_SESSION['id_aluno_joomla'])){
				$this->apenas_dados_novos($_SESSION['id_aluno_joomla']);
			} else {
				echo json_encode(['status'=>false, 'msg'=>'sem_id_na_session']);
				exit();
			}
			exit();
			break;


			case 2:

			$this->cadastro_novo();

			break;

			default:
					# code...
			break;
		}


		echo json_encode(['status'=>false, 'msg'=>'garantindo_que_n_vai_bugar', 'aux'=>$op]);
		exit();
		
	}



	public function cadastro_novo()
	{
		$model = $this->getModel('webcurso', 'webcursoModel', array('ignore_request' => true));
		//$id_curso, $nome, $email, $telefone, $senha1, $senha2, $endereco, $bairro, $cidade, $uf, $instituicao, $area
		$nome = filter_input(INPUT_POST, 'nome_aluno', FILTER_SANITIZE_SPECIAL_CHARS);
		$email = filter_input(INPUT_POST, 'email_aluno', FILTER_SANITIZE_SPECIAL_CHARS);
		$telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_SPECIAL_CHARS);
		$senha1 = filter_input(INPUT_POST, 'senha1');
		$senha2 = filter_input(INPUT_POST, 'senha2');
		$endereco = filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_SPECIAL_CHARS);
		$bairro = filter_input(INPUT_POST, 'bairro', FILTER_SANITIZE_SPECIAL_CHARS);
		$cidade = filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_SPECIAL_CHARS);
		$uf = filter_input(INPUT_POST, 'uf', FILTER_SANITIZE_SPECIAL_CHARS);
		$instituicao = filter_input(INPUT_POST, 'instituicao', FILTER_SANITIZE_SPECIAL_CHARS);
		$area = filter_input(INPUT_POST, 'area', FILTER_SANITIZE_SPECIAL_CHARS);

		$id_curso = filter_input(INPUT_POST, 'id_curso', FILTER_VALIDATE_INT);

		if(!$id_curso && $id_curso <= 0){
			echo json_encode(['status'=>false, 'msg'=>'id_curso_invalido']);
			exit();
		}


		if($senha1 !== $senha2){
			echo json_encode(['status'=>false, 'msg'=>'senhas_nao_conferem']);
			exit();
		}

		if(!$email){
			echo json_encode(['status'=>false, 'msg'=>'sem_email_no_input']);
			exit();
		}

		if(!$nome || !$senha1 || !$senha2 || !$endereco || !$bairro || !$cidade || !$uf || !$instituicao || !$area){
			echo json_encode(['status'=>false, 'msg'=>'informe_todos_dados']);
			exit();
		}

		$model->registra_cadastro_dados_pedido($id_curso, $nome, $email, $telefone, $senha1, $senha2, $endereco, $bairro, $cidade, $uf, $instituicao, $area);




		/*
		echo json_encode(['status'=>false, 'nome'=>$nome, 'email'=>$email, 'telefone'=>$telefone, 'senha1'=>$senha1, 'senha2'=>$senha2, 'endereco'=>$endereco, 'bairro'=>$bairro, 'cidade'=>$cidade, 'uf'=>$uf, 'instituicao'=>$instituicao, 'area'=>$area]);
		exit();
		*/

	}

	public function apenas_dados_novos($id_joomla)
	{
		$model = $this->getModel('webcurso', 'webcursoModel', array('ignore_request' => true));

		$endereco = filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_SPECIAL_CHARS);
		$bairro = filter_input(INPUT_POST, 'bairro', FILTER_SANITIZE_SPECIAL_CHARS);
		$cidade = filter_input(INPUT_POST, 'cidade', FILTER_SANITIZE_SPECIAL_CHARS);
		$uf = filter_input(INPUT_POST, 'uf', FILTER_SANITIZE_SPECIAL_CHARS);
		$instituicao = filter_input(INPUT_POST, 'instituicao', FILTER_SANITIZE_SPECIAL_CHARS);
		$area = filter_input(INPUT_POST, 'area', FILTER_SANITIZE_SPECIAL_CHARS);
		$telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_SPECIAL_CHARS);
		$id_joomla = (int) $id_joomla;


		if(!$endereco || !$bairro || !$cidade || !$uf || !$instituicao || !$area || !$id_joomla){
			echo json_encode(['status'=>false, 'msg'=>'informe_todos_dados']);
			exit();
		}


		/*
		echo json_encode(['status'=>false, 'endereco'=>$endereco, 'bairro'=>$bairro, 'cidade'=>$cidade, 'uf'=>$uf, 'instituicao'=>$instituicao, 'area'=>$area, 'telefone'=>$telefone ]);
		exit();
		*/

		if($model->adiciona_dados_nova_tabela($id_joomla, $endereco, $bairro, $cidade, $uf, $instituicao, $area, $telefone)){

			$id_curso = filter_input(INPUT_POST, 'id_curso', FILTER_VALIDATE_INT);

			if(!$id_curso && $id_curso <= 0){
				echo json_encode(['status'=>false, 'msg'=>'id_curso_invalido']);
				exit();
			}


			if($model->verifica_pedido($id_joomla, $id_curso)){

				echo json_encode(['status'=>false, 'msg'=>'usuario_ja_cadastrado_nesse_curso']);
				exit();
			}

			if($model->registra_pedido($id_joomla, $id_curso)){

				echo json_encode(['status'=>true, 'msg'=>'Email existe e curso foi registrado.']);
				
			}


			unset($_SESSION['id_aluno_joomla']);
			exit();

		}


	}


	public function inicio()
	{
		$model = $this->getModel('webcurso', 'webcursoModel', array('ignore_request' => true));


		if(!$email = filter_input(INPUT_POST,'email_aluno', FILTER_VALIDATE_EMAIL)){
			echo json_encode(['status'=>false, 'msg'=>'email_invalido']);
			exit();
		}




		if($id_aluno = $model->verify_email($email)){

			if(!$id_nova_tabela = $model->verifica_dados_adicionais($id_aluno)){
				$_SESSION['id_aluno_joomla'] = $id_aluno;
				echo json_encode(['status'=>false, 'msg'=>'sem_dados_adicionais']);
				exit();
			}

			$id_curso = filter_input(INPUT_POST, 'id_curso', FILTER_VALIDATE_INT);

			if(!$id_curso && $id_curso <= 0){
				echo json_encode(['status'=>false, 'msg'=>'id_curso_invalido']);
				exit();
			}

			if($model->verifica_pedido($id_aluno, $id_curso)){

				echo json_encode(['status'=>false, 'msg'=>'usuario_ja_cadastrado_nesse_curso']);
				exit();
			}


			if($model->registra_pedido($id_aluno, $id_curso)){

				echo json_encode(['status'=>true, 'msg'=>'Email existe e curso foi registrado.']);
				exit();
			}



		} else {
			//caso entrar aki, libera os outros campos
			// só entra aki se o email não tiver cadastrado no banco




			echo json_encode(['status'=>false, 'msg'=>'email_nao_existe_db']);
			exit();
		}


		echo json_encode(['status'=>false, 'msg'=>'garantindo_que_n_vai_bugar']);
		exit();
	}

}
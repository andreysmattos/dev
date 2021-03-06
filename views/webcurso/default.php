<?php defined('_JEXEC') or die('Restricted access'); ?>
<link rel="stylesheet" type="text/css" href="components/com_webcurso/css/style.css">
<link rel="stylesheet" type="text/css" href="components/com_webcurso/css/bootstrap.min.css">
<div class="webcurso">
	<?php echo($teste); ?>
	<?php if (!empty($this->items)) : ?>
		<?php foreach ($this->items as $i => $row): ?>
			<div class="webheader row">
				<div class="col-sm-9">
					<div class="webinformation col-sm-12">
						<div class="col-sm-9">
							<h1><?php echo $row->titulo; ?></h1>
							<div class="info">
								<i class="fa fa-graduation-cap"></i> Modalidade: <?php echo $row->modalidade; ?>
								| <i class="fa fa-clock-o"></i> Horas aula: <?php echo $row->horas_aula; ?>
							</div>
							<div>
								<i class="fa fa-tag"></i> <?php echo $row->category_title; ?>
								| <i class="fa fa-check"></i> Investimento: R$ <?php echo $row->preco; ?>
							</div>
						</div>
						<div class="webimagem">
							<img src="<?php echo $row->img; ?>" alt="<?php echo $row->titulo; ?>">
						</div>
					</div>

					<div class="webdescricao col-sm-12"><?php echo $row->descricao; ?></div>
				</div>


				<div class="col-sm-3">
					<div class="webinscri">
						<h3>Quero me inscrever:</h3>
						<form method="post" id="formulario_insc">
							<input type="hidden" name="id_curso" value="<?php echo $row->id;?>">
							<input style="display: none" class="registro" type="text" name="nome_aluno" placeholder="Nome Completo" />
							<input type="email" name="email_aluno" placeholder="Seu E-mail" required="required">
							<input style="display: none" class="registro sojoomla" type="text" name="telefone" placeholder="Seu Telefone" >
							<input class="registro" style="display: none" type="password" name="senha1" placeholder="Cadastre uma senha">
							<input class="registro" style="display: none" type="password" name="senha2" placeholder="Confirme a senha">
							
							<select name="uf" class="registro sojoomla" style="display: none">
								<option value="AC">Acre</option>
								<option value="AL">Alagoas</option>
								<option value="AP">Amapá</option>
								<option value="AM">Amazonas</option>
								<option value="BA">Bahia</option>
								<option value="CE">Ceará</option>
								<option value="DF">Distrito Federal</option>
								<option value="ES">Espírito Santo</option>
								<option value="GO">Goiás</option>
								<option value="MA">Maranhão</option>
								<option value="MT">Mato Grosso</option>
								<option value="MS">Mato Grosso do Sul</option>
								<option value="MG">Minas Gerais</option>
								<option value="PA">Pará</option>
								<option value="PB">Paraíba</option>
								<option value="PR">Paraná</option>
								<option value="PE">Pernambuco</option>
								<option value="PI">Piauí</option>
								<option value="RJ">Rio de Janeiro</option>
								<option value="RN">Rio Grande do Norte</option>
								<option value="RS">Rio Grande do Sul</option>
								<option value="RO">Rondônia</option>
								<option value="RR">Roraima</option>
								<option value="SC">Santa Catarina</option>
								<option value="SP">São Paulo</option>
								<option value="SE">Sergipe</option>
								<option value="TO">Tocantins</option>
							</select>
							<input style="display: none" class="registro sojoomla" type="text" name="cidade" placeholder="Cidade" />

							<input style="display: none" class="registro sojoomla" type="text" name="bairro" placeholder="Bairro" />

							<input style="display: none" class="registro sojoomla" type="text" name="endereco" placeholder="Endereco" />

							<input style="display: none" class="registro sojoomla" type="text" name="instituicao" placeholder="Instituicao" />

							<input style="display: none" class="registro sojoomla" type="text" name="area" placeholder="Área" />

							<input type="hidden" name="novo" id="novo" value="0" />

							<?php if(!empty($row->preco) AND $row->preco > 0){ ?>
							<select name="forma_pagamento" required="required">
								<?php foreach ($listar as $forma): ?>
									<option><?php echo $forma[0]; ?></option>
								<?php endforeach; ?>
							</select>
							<?php } else { ?>
							<input type="hidden" name="forma_pagamento" value="gratuito">		 
							<?php }; ?>
							<!--
							<label><input checked="checked" type="radio" value="1" name="cadastro" />
							Já Possuo Cadastro</label>
							<label><input type="radio" value="0" name="cadastro" />
							Não Possuo Cadastro</label>
						-->
						<input type="submit" class="btn btn-success" name="enviar" value="Inscreva-se" />
					</form>
				</div>
			</div>


		</div>	
	</div>

<?php endforeach; ?>
<?php endif; ?>
<script type="text/javascript">
	$(document).ready(function(){

		//Andrey
		jQuery('#formulario_insc').submit(function(){

			var dados = jQuery(this).serialize();

			var form_ajax = jQuery.ajax({
				method: 'post',
				url: 'https://www.salaoicfuc.com.br/components/com_webcurso/views/webcurso/tmpl/ajax_andrey.php',
				data: dados,
				dataType: 'json'
				
			});


			form_ajax.done(function(dados){
				alert('entro aki');
				console.log(dados);

				if(!dados.status){
					
					//jQuery('.registro').attr('required','required');
					//jQuery('.registro').val("");
					jQuery('input[type="submit"]').attr('id','validarnome');
			

					if(dados.acao == 'nossa_tabela'){
						jQuery('.sojoomla').show('slow');
						jQuery('input#novo').val(1);
					}

					if(dados.acao == 'joomla_tabela'){
						jQuery('.registro').show('slow');
						jQuery('input#novo').val(2);
					}

					if(dados.acao == 'password_errado'){
						alert('As senhas não conferem');
					}
				}


				if(dados.status){
					jQuery('.registro').val("");
					alert('pedido cadastrado com sucesso');
				}
			});

			return false;
		});
		//Andrey
/*
		jQuery('.registro').val('');

		jQuery('input[name="nome_aluno"]').focusout(function(){
			var nome = jQuery('input[name="nome_aluno"]').val();			
			var texto_menos_um = nome.substring(0,nome.length-1);
			var ultimoCarac = nome.charAt(nome.length-1);
		//Retira ultimo espaço
		if (ultimoCarac == " ") {
			jQuery('input[name="nome_aluno"]').val(texto_menos_um);
		}
		//verica quantos espaços " " tem no input
		var palavras = jQuery('input[name="nome_aluno"]').val().split(" ").length;

		if (palavras <= 1) {			
			jQuery('input[name="nome_aluno"]').after("<div class='aviso' style='position: absolute;background: #439aff;color: #fff;padding: 0px 5px;'>Informe seu Nome Completo</div>");
			jQuery(".aviso").fadeOut(3000);
		}
	})


		jQuery('input[name="cadastro"]').on('change', function(){
			var valor = jQuery(this).val();
			if (valor == "0"){
				jQuery('.registro').show('slow');
				jQuery('.registro').attr('required','required');
				jQuery('.registro').val("");
				jQuery('input[type="submit"]').attr('id','validarnome');
			}else{
				jQuery('.registro').hide('slow');
				jQuery('.registro').removeAttr('required','required');
				jQuery('.registro').val("");
				jQuery('input[type="submit"]').removeAttr('id','validarnome');
			} 
		}); 
		jQuery('input[type="submit"]').click(function(){
			var nome = jQuery('input[name="nome_aluno"]').val();
			var palavras = jQuery('input[name="nome_aluno"]').val().split(" ").length;
			if(nome == ""){
				return true;
			}
			else if (palavras <= 1) {			
				jQuery('input[name="nome_aluno"]').after("<div class='aviso' style='position: absolute;background: #439aff;color: #fff;padding: 0px 5px;'>Informe seu Nome Completo</div>");
				jQuery(".aviso").fadeOut(3000);
				return false;
			}

		});*/
	})
</script>
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
						<div class="webimagem col-sm-3">
							<img src="<?php echo $row->img; ?>" alt="<?php echo $row->titulo; ?>">
						</div>
						<div class="col-sm-9">
							<h1><?php echo $row->titulo; ?></h1>
							
						</div>
						
					</div>

					<div class="webdescricao col-sm-12"><?php echo $row->descricao; ?></div>
				</div>


				<div class="col-sm-3">
					<div class="webinscri">
					<h3>Inscreva-se:</h3>
					<form method="post" id="formulario_insc">
						<input type="hidden" name="id_curso" value="<?php echo $row->id;?>" />
						<input  class="registro" type="text" name="nome_aluno" placeholder="Nome Completo" required />

						<input type="email" name="email_aluno" placeholder="Seu E-mail" required="required" />

						<input required class="registro sojoomla" type="text" name="telefone" placeholder="Seu Telefone" />

						<input required class="registro"  type="password" name="senha1" placeholder="Cadastre uma senha" />

						<input required class="registro"  type="password" name="senha2" placeholder="Confirme a senha" />

						<input required class="registro sojoomla" type="text" name="endereco" placeholder="Endereço, Nº" />

						<input  class="registro sojoomla" type="text" name="bairro" placeholder="Bairro" />
							
						<input required class="registro sojoomla" type="text" name="cidade" placeholder="Cidade" />

						<select required name="uf" class="registro sojoomla">
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

							<input required class="registro sojoomla" type="text" name="instituicao" placeholder="Instituição" />

							<input required class="registro sojoomla" type="text" name="area" placeholder="Área do conhecimento" />
							<input type="hidden" name="novo" id="novo" value="0" />								
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
		jQuery('#formulario_insc').submit(function(){
			alert('Sua inscrição foi cadastrada com sucesso, em breve lhe enviaremos um e-mail com mais detalhes');
		});

		jQuery('input[name="senha2"]').focusout(function(){
			var senha1 = jQuery('input[name="senha1"]').val();
			var senha2 = jQuery('input[name="senha2"]').val();
			if (senha1 != senha2) {
				jQuery('input[name="senha1"]').after("<div class='aviso' style='position: absolute;background: #439aff;color: #fff;padding: 0px 5px;'>Senhas diferentes</div>");
				jQuery(".aviso").fadeOut(3000);
				jQuery('input[name="senha1"]').focus();		
			}
		});
		
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
	});
		
		jQuery('input[type="submit"]').click(function(){
			var senha1 = jQuery('input[name="senha1"]').val();
			var senha2 = jQuery('input[name="senha2"]').val();

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
			if (senha1 != senha2) {
				jQuery('input[name="senha1"]').after("<div class='aviso' style='position: absolute;background: #439aff;color: #fff;padding: 0px 5px;'>Senhas diferentes</div>");
				jQuery(".aviso").fadeOut(3000);
				jQuery('input[name="senha1"]').focus();
				return false;
			}

		});
	})
</script>
<?php defined('_JEXEC') or die('Restricted access'); ?>
<link rel="stylesheet" type="text/css" href="components/com_webcurso/css/style.css">
<link rel="stylesheet" type="text/css" href="components/com_webcurso/css/bootstrap.min.css">
<div class="webcategoria row">
<?php if (!empty($this->items)) : ?>
		<?php foreach ($this->items as $i => $row): ?>
			<div class="col-sm-4 col-md-4">
			<div class="weblista">
			    <div class="webimagem">
			    	<a href="<?php echo
					 JRoute::_('index.php?view=webcurso&alias='.$row->url.'&curso=' . $row->id); ?>" >
			    	<img src="<?php echo $row->img; ?>" alt="<?php echo $row->nome; ?>">
			    	</a>
			    </div>
			    <div class="webinformation">
				<h3><?php echo $row->nome; ?></h3>
				<p class="webinfo">
					<?php echo $row->descricao_curta; ?>					
				</p>
				<div>
					<a href="<?php echo
					 JRoute::_('index.php?view=webcurso&alias='.$row->url.'&curso=' . $row->id); ?>" class="btn btn-success">
					Inscreva-se</a>
				</div>
				</div>
			</div>
			</div>						
		<?php endforeach; ?>		
<?php endif; ?>
			<?php //print_r($veroficina); ?>
		<!--<?php if($this->teste){ ?>
			<div class="col-sm-3">
			<div class="weblista">
				<div class="webimagem" style="text-align: center;">
			    	<a href="/oficinas" >
			    		<img style="width: auto;text-align: center;" src="/images/site/classroom.png" alt="Oficinas">
			    	</a>
			    </div>
			    <div class="webinformation">
				<h3>Oficinas</h3>
				<p class="webinfo">
					Inscreva-se para uma de nossas oficinas, as vagas são limitadas!					
				</p>
				<div>
					<a class="btn btn-success" href="/oficinas" >
					Inscreva-se</a>
				</div>
				</div>
			</div>
			</div>
		<?php } ?>-->
</div>

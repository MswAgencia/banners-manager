<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Editando Banner</h1>
		<p>Edite as informações no formulário conforme necessário</p>
		<?php
			echo $this->Flash->render();

			echo $this->Form->create($banner, ['type' => 'file']);

			echo $this->Html->tag('legend', 'Informações Básicas');


			if($options['use_order_field'])
				echo $this->Form->input('sort_order', ['label' => 'Ordem', 'type' => 'number']);

			if($options['use_name'])
				echo $this->Form->input('name', ['label' => 'Nome']);

			if($options['use_link'])
				echo $this->Form->input('link', ['label' => 'Link']);

			if($options['use_description'])
				echo $this->Form->textarea('description', ['label' => 'Descrição']);
		?>
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<?= $this->Form->label('Imagem do Banner') ?>
					<?= $this->Form->file('image') ?>
				</div>
			</div>
			<div class="col-md-4 col-offset-4">
				<?= $this->Html->image($banner->image, ['class' => 'img-responsive']) ?>
			</div>
		</div>
		<?php
			echo $this->Form->textarea('text', ['label' => 'Texto do Banner']);

			echo $this->Form->select('position_id', $positionsList, ['label' => 'Posição do Banner']);

			echo $this->Form->checkbox('active', ['label' => 'Ativo']);

			echo $this->Form->submit('Editar', ['class' => 'btn btn-primary']);
      echo $this->Html->link('Voltar', '/interno/banners', ['class' => 'btn btn-default']);
			echo $this->Form->end();
		?>
	</div>
</div>

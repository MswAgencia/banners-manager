<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Novo Banner</h1>
		<p>Preencha o formulário para cadastrar um novo banner</p>
		<?php
			echo $this->Flash->render();

			echo $this->Form->create($banner, ['type' => 'file']);

			echo $this->Html->tag('legend', 'Informações Básicas');

			if($options['use_order_field'])
				echo $this->Form->input('sort_order', ['label' => 'Ordem', 'type' => 'number', 'value' => 1]);

			if($options['use_name'])
				echo $this->Form->input('name', ['label' => 'Nome']);

			if($options['use_link'])
				echo $this->Form->input('link', ['label' => 'Link']);

			if($options['use_description'])
				echo $this->Form->textarea('description', ['label' => 'Descrição']);

			echo '<div class="form-group">';
			echo $this->Form->label('Imagem do Banner');
			echo $this->Form->file('image');
			echo '</div>';

			echo $this->Form->textarea('text', ['label' => 'Texto do Banner']);

			echo $this->Form->select('position_id', $positionsList, ['label' => 'Posição do Banner']);

			echo $this->Form->checkbox('active', ['label' => 'Ativo']);

			echo $this->Form->submit('Cadastrar', ['class' => 'btn btn-primary']);
			echo $this->Form->end();
		?>
	</div>
</div>


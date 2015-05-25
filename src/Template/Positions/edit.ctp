<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Editando posição <?= $position->name ?></h1>
		<p>Edite as informações no formulário conforme necessário</p>
		<?php
			echo $this->Flash->render();

			echo $this->Form->create($position, ['type' => 'file']);

			echo $this->Html->tag('legend', 'Informações Básicas');

			echo $this->Form->input('name', ['label' => 'Nome']);

			echo $this->Form->select('type', ['image' => 'Imagem', 'text' => 'Texto'], ['label' => 'Tipo de Banner']);

			echo $this->Form->checkbox('active', ['label' => 'Ativo']);

			echo $this->Html->tag('legend', 'Tamanho da Imagem');
			
			echo $this->Html->tag('p', 'Quando usado o tipo de banner "Imagem", informe os valores abaixo.');

			echo $this->Form->select('mode', \AppCore\Lib\Utility\ArrayUtility::markValue(['resizeCrop' => 'Padrão', 'resize' => 'Somente Redimensionar'], $position->mode, '(atual)'), ['label' => 'Modo de Redimensionamento']);

			echo $this->Form->input('width', ['label' => 'Largura da Imagem', 'type' => 'number']);
			echo $this->Form->input('height', ['label' => 'Altura da Imagem', 'type' => 'number']);


			echo $this->Form->submit('Editar', ['class' => 'btn btn-primary']);
			echo $this->Form->end();
		?>
	</div>
</div>


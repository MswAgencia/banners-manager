<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Nova Posição de Banner</h1>
		<p>Preencha o formulário para cadastrar uma nova posição de banners</p>
		<?php
			echo $this->Flash->render();

			echo $this->Form->create($position, ['type' => 'file']);

			echo $this->Html->tag('legend', 'Informações Básicas');

			echo $this->Form->input('name', ['label' => 'Nome']);

			echo $this->Form->select('type', ['image' => 'Imagem', 'text' => 'Texto'], ['label' => 'Tipo de Banner']);

			echo $this->Form->checkbox('active', ['label' => 'Ativo']);

			echo $this->Html->tag('legend', 'Tamanho da Imagem');
			
			echo $this->Html->tag('p', 'Quando usado o tipo de banner "Imagem", informe os valores abaixo.');

			echo $this->Form->select('mode', ['resizeCrop' => 'Padrão', 'resize' => 'Somente Redimensionar'], ['label' => 'Modo de Redimensionamento']);

			echo $this->Form->input('width', ['label' => 'Largura da Imagem', 'type' => 'number']);
			echo $this->Form->input('height', ['label' => 'Altura da Imagem', 'type' => 'number']);


			echo $this->Form->submit('Cadastrar', ['class' => 'btn btn-primary']);
			echo $this->Form->end();
		?>
	</div>
</div>


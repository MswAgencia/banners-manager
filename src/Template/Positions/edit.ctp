<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Editando posição: <?= $position->name ?></h1>
		<p>Edite as informações no formulário conforme necessário</p>
			<?= $this->Flash->render() ?>

			<?= $this->Form->create($position, ['type' => 'file']) ?>

			<?= $this->Html->tag('legend', 'Informações Básicas') ?>

			<?= $this->Form->input('name', ['label' => 'Nome']) ?>

			<?= $this->Form->select('type', ['image' => 'Imagem', 'text' => 'Texto'], ['label' => 'Tipo de Banner']) ?>

			<?= $this->Form->checkbox('active', ['label' => 'Ativo']) ?>

			<?= $this->Html->tag('legend', 'Tamanho da Imagem') ?>

			<?= $this->Html->tag('p', 'Quando usado o tipo de banner "Imagem", informe os valores abaixo.') ?>

			<?= $this->Form->select('mode', ['resize_crop' => 'Redimensionar e Cortar', 'resize' => 'Somente Redimensionar'], $position->mode, ['label' => 'Modo de Redimensionamento']) ?>

			<?= $this->Form->input('width', ['label' => 'Largura da Imagem', 'type' => 'number']) ?>

      <?= $this->Form->input('height', ['label' => 'Altura da Imagem', 'type' => 'number']) ?>

			<?= $this->Form->submit('Editar', ['class' => 'btn btn-primary']) ?>

      <?= $this->Html->link('Voltar', '/interno/posicoes', ['class' => 'btn btn-default']) ?>

			<?= $this->Form->end() ?>
	</div>
</div>

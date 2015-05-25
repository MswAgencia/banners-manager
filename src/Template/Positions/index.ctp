<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Posições de Banner Cadastrados <?= $this->Html->link('Cadastrar', '/interno/banners/posicoes/novo', ['class' => 'btn btn-primary btn-lg']) ?></h1>
		<?php
			echo $this->Flash->render();

			echo $this->Html->tag('table', null, ['class' => 'table stripped table-bordered realties-table']);
			echo $this->Html->tableHeaders($tableHeaders);
			$cells = [];
			foreach($data as $position){
				$options = [];
				$options[] = $this->Html->link('Editar', '/interno/banners/posicoes/editar/' . $position->id, ['class' => 'btn btn-sm btn-primary']);
				$options[] = $this->Html->link('Excluir', '/interno/banners/posicoes/remover/' . $position->id, ['confirm' => 'Tem certeza que deseja excluir a posição?', 'class' => 'btn btn-sm btn-danger']);
				$cells[] = [$position->name, $position->getTypeName(), $position->getStatusAsString(), implode(' ', $options)];
			}

			if(!empty($cells))
				echo $this->Html->tableCells($cells);
			else
				echo $this->Flash->render('notice');

			echo $this->Html->tag('/table');
		?>
	</div>
</div>
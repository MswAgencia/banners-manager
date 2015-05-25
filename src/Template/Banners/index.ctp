<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Banners Cadastrados <?= $this->Html->link('Cadastrar', '/interno/banners/novo', ['class' => 'btn btn-primary btn-lg']) ?></h1>
		<?php
			echo $this->Flash->render();

			echo $this->Html->tag('table', null, ['class' => 'table stripped table-bordered realties-table']);
			

			echo $this->Html->tag('thead', $this->Html->tableHeaders($tableHeaders));
			$cells = [];
			foreach($data as $banner){
				$cell = [];
				$cell[] = $this->Html->image($banner->image, ['class' => 'img-responsive']);

				if($options['use_name'])
					$cell[] = $banner->name;

				if($options['use_link'])
					$cell[] = $banner->link;

				$cell[] = $banner->getStatusAsString();
				$cell[] = implode(' ', [
					$this->Html->link('Editar', '/interno/banners/editar/' . $banner->id, ['class' => 'btn btn-sm btn-primary']),

					$this->Html->link('Excluir', '/interno/banners/remover/' . $banner->id, ['class' => 'btn btn-sm btn-danger', 'confirm' => 'Tem certeza que deseja excluir o banner?'])
				]);
				$cells[] = $cell;
			}

			if(!empty($cells))
				echo $this->Html->tableCells($cells);
			else
				echo $this->Flash->render('notice');

			echo $this->Html->tag('/table');
		?>
	</div>
</div>
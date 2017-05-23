<?php
require_once 'consts.php';
require_once 'functions.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
	<title>Encargos &#8211; UEM</title>
	<meta charset="utf-8"/>
	<meta content="Luiz Joaquim Aderaldo Amichi" name="author"/>
	<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
	<link href="favicon.png" rel="shortcut icon" type="image/png"/>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"/>
</head>

<body>
	<div class="container">
		<div class="text-center my-5">
			<h1 class="display-5">Encargos</h1>
		</div>

		<form method="post">
			<label class="form-label" for="name">Nome</label>
			<div class="input-group mb-3">
				<input autofocus="autofocus" class="form-control" id="name" name="name" required="required" type="text"/>
				<button class="btn btn-outline-secondary" id="submit" type="submit">Pesquisar</button>
			</div>
		</form>

<?php if(request_method() == 'POST' && in_array('name', request_parameters())): ?>
		<table class="table table-hover mb-5">
			<thead class="table-light">
				<tr>
					<th>Nome</th>
					<th>Encargos</th>
				</tr>
			</thead>
			<tbody>
	<?php if($set_up_table = set_up_table()): ?>
		<?php foreach($set_up_table as $st): ?>
				<tr>
					<td><?= $st['nome'] ?></td>
					<td><a class="badge bg-primary" href="?teacher=<?= $st['id'] ?>">Visualizar</a></td>
				</tr>
		<?php endforeach; ?>
	<?php else: ?>
				<tr>
					<td class="text-center" colspan="3">Não foi encontrado nenhum registro.</td>
				</tr>
	<?php endif; ?>
			</tbody>
		</table>

<?php elseif(request_method() == 'GET' && in_array('teacher', request_parameters())): ?>
	<?php $teacher = load_all_data(); ?>

	<?php if(DISPLAY_LAYOUT == 'accordion'): ?>
		<div class="accordion mb-5">
			<div class="accordion" id="accordion">
				<div class="accordion-item">
					<h2 class="accordion-header" id="heading-one">
						<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-one" aria-expanded="true" aria-controls="collapse-one">
							Informações Gerais
						</button>
					</h2>
					<div id="collapse-one" class="accordion-collapse collapse show" aria-labelledby="heading-one" data-bs-parent="#accordion">
						<div class="accordion-body">
							<table class="table">
								<thead>
									<tr>
										<th>Nome</th>
										<th>Departamento</th>
										<th>Regime de Trabalho</th>
									</tr>
								</thead>
								<tbody>
		<?php foreach($teacher['general_information'] as $gi): ?>
									<tr>
										<td><?= $gi['nome'] ?></td>
										<td><?= $gi['departamento'] ?></td>
										<td><?= $gi['rt'] ?></td>
									</tr>
		<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<div class="accordion-item">
					<h2 class="accordion-header" id="heading-two">
						<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-two" aria-expanded="false" aria-controls="collapse-two">
							Encargos de Ensino
						</button>
					</h2>
					<div id="collapse-two" class="accordion-collapse collapse" aria-labelledby="heading-two" data-bs-parent="#accordion">
						<div class="accordion-body">
							<table class="table">
								<thead>
									<tr>
										<th>Código</th>
										<th>Disciplina</th>
										<th>Curso</th>
										<th>CH/S</th>
										<th>CH Anual</th>
										<th>Início</th>
										<th>Término</th>
										<th>Horários</th>
									</tr>
								</thead>
								<tbody>
		<?php foreach($teacher['teaching_charges'] as $tc): ?>
									<tr>
										<td><?= $tc['codigo'] ?></td>
										<td><?= $tc['nome'] ?></td>
										<td><?= $tc['curso'] ?></td>
										<td><?= $tc['chsemanal'] ?></td>
										<td><?= $tc['chtotal'] ?></td>
										<td><?= $tc['inicio'] ?></td>
										<td><?= $tc['termino'] ?></td>
										<td>
			<?php foreach($tc['horarios'] as $time): ?>
											<?= $time['dia'] . ': ' . $time['horainicio'] . '-' . $time['horafim'] ?>
											<br/>
			<?php endforeach; ?>
										</td>
									</tr>
		<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<div class="accordion-item">
					<h2 class="accordion-header" id="heading-three">
						<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-three" aria-expanded="false" aria-controls="collapse-three">
							Encargos de Orientação
						</button>
					</h2>
					<div id="collapse-three" class="accordion-collapse collapse" aria-labelledby="heading-three" data-bs-parent="#accordion">
						<div class="accordion-body">
							<table class="table">
								<thead>
									<tr>
										<th>Aluno</th>
										<th>Modalidade</th>
										<th>Início</th>
										<th>Término</th>
										<th>CH/S</th>
									</tr>
								</thead>
								<tbody>
		<?php foreach($teacher['guidance_charges'] as $gc): ?>
									<tr>
										<td><?= $gc['orientando'] ?></td>
										<td><?= $gc['modalidade'] ?></td>
										<td><?= $gc['inicio'] ?></td>
										<td><?= $gc['termino'] ?></td>
										<td><?= $gc['chsemanal'] ?></td>
									</tr>
		<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<div class="accordion-item">
					<h2 class="accordion-header" id="heading-four">
						<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-four" aria-expanded="false" aria-controls="collapse-four">
							Encargos de Projetos
						</button>
					</h2>
					<div id="collapse-four" class="accordion-collapse collapse" aria-labelledby="heading-four" data-bs-parent="#accordion">
						<div class="accordion-body">
							<table class="table">
								<thead>
									<tr>
										<th>Processo</th>
										<th>Título</th>
										<th>Modalidade</th>
										<th>Início</th>
										<th>Término</th>
										<th>CH/S</th>
									</tr>
								</thead>
								<tbody>
		<?php foreach($teacher['project_charges'] as $pc): ?>
									<tr>
										<td><?= $pc['processo'] ?></td>
										<td><?= $pc['titulo'] ?></td>
										<td><?= $pc['modalidade'] ?></td>
										<td><?= $pc['inicio'] ?></td>
										<td><?= $pc['termino'] ?></td>
										<td><?= $pc['chsemanal'] ?></td>
									</tr>
		<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<div class="accordion-item">
					<h2 class="accordion-header" id="heading-five">
						<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-five" aria-expanded="false" aria-controls="collapse-five">
							Encargos de Ocorrências Funcionais
						</button>
					</h2>
					<div id="collapse-five" class="accordion-collapse collapse" aria-labelledby="heading-five" data-bs-parent="#accordion">
						<div class="accordion-body">
							<table class="table">
								<thead>
									<tr>
										<th>Processo</th>
										<th>Descrição</th>
										<th>Natureza</th>
										<th>Início</th>
										<th>Término</th>
										<th>CH/S</th>
									</tr>
								</thead>
								<tbody>
		<?php foreach($teacher['function_charges'] as $fc): ?>
									<tr>
										<td><?= $fc['processo'] ?></td>
										<td><?= $fc['descricao'] ?></td>
										<td><?= $fc['natureza'] ?></td>
										<td><?= $fc['inicio'] ?></td>
										<td><?= $fc['termino'] ?></td>
										<td><?= $fc['chsemanal'] ?></td>
									</tr>
		<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php else: ?>

		<div class="list-group mb-5">
			<a href="javascript:void(0);" class="list-group-item list-group-item-action">
				<div class="d-flex w-100 justify-content-between">
					<h5 class="mb-1">Informações Gerais</h5>
				</div>
				<p class="mb-1">
					<table class="table">
						<thead>
							<tr>
								<th>Nome</th>
								<th>Departamento</th>
								<th>Regime de Trabalho</th>
							</tr>
						</thead>
						<tbody>
		<?php foreach($teacher['general_information'] as $gi): ?>
							<tr>
								<td><?= $gi['nome'] ?></td>
								<td><?= $gi['departamento'] ?></td>
								<td><?= $gi['rt'] ?></td>
							</tr>
		<?php endforeach; ?>
						</tbody>
					</table>
				</p>
			</a>

			<a href="javascript:void(0);" class="list-group-item list-group-item-action">
				<div class="d-flex w-100 justify-content-between">
					<h5 class="mb-1">Encargos de Ensino</h5>
				</div>
				<p class="mb-1">
					<table class="table">
						<thead>
							<tr>
								<th>Código</th>
								<th>Disciplina</th>
								<th>Curso</th>
								<th>CH/S</th>
								<th>CH Anual</th>
								<th>Início</th>
								<th>Término</th>
								<th>Horários</th>
							</tr>
						</thead>
						<tbody>
		<?php foreach($teacher['teaching_charges'] as $tc): ?>
							<tr>
								<td><?= $tc['codigo'] ?></td>
								<td><?= $tc['nome'] ?></td>
								<td><?= $tc['curso'] ?></td>
								<td><?= $tc['chsemanal'] ?></td>
								<td><?= $tc['chtotal'] ?></td>
								<td><?= $tc['inicio'] ?></td>
								<td><?= $tc['termino'] ?></td>
								<td>
			<?php foreach($tc['horarios'] as $time): ?>
									<?= $time['dia'] . ': ' . $time['horainicio'] . '-' . $time['horafim'] ?>
									<br/>
			<?php endforeach; ?>
								</td>
							</tr>
		<?php endforeach; ?>
						</tbody>
					</table>
				</p>
			</a>

			<a href="javascript:void(0);" class="list-group-item list-group-item-action">
				<div class="d-flex w-100 justify-content-between">
					<h5 class="mb-1">Encargos de Orientação</h5>
				</div>
				<p class="mb-1">
					<table class="table">
						<thead>
							<tr>
								<th>Aluno</th>
								<th>Modalidade</th>
								<th>Início</th>
								<th>Término</th>
								<th>CH/S</th>
							</tr>
						</thead>
						<tbody>
		<?php foreach($teacher['guidance_charges'] as $gc): ?>
							<tr>
								<td><?= $gc['orientando'] ?></td>
								<td><?= $gc['modalidade'] ?></td>
								<td><?= $gc['inicio'] ?></td>
								<td><?= $gc['termino'] ?></td>
								<td><?= $gc['chsemanal'] ?></td>
							</tr>
		<?php endforeach; ?>
						</tbody>
					</table>
				</p>
			</a>

			<a href="javascript:void(0);" class="list-group-item list-group-item-action">
				<div class="d-flex w-100 justify-content-between">
					<h5 class="mb-1">Encargos de Projetos</h5>
				</div>
				<p class="mb-1">
					<table class="table">
						<thead>
							<tr>
								<th>Processo</th>
								<th>Título</th>
								<th>Modalidade</th>
								<th>Início</th>
								<th>Término</th>
								<th>CH/S</th>
							</tr>
						</thead>
						<tbody>
		<?php foreach($teacher['project_charges'] as $pc): ?>
							<tr>
								<td><?= $pc['processo'] ?></td>
								<td><?= $pc['titulo'] ?></td>
								<td><?= $pc['modalidade'] ?></td>
								<td><?= $pc['inicio'] ?></td>
								<td><?= $pc['termino'] ?></td>
								<td><?= $pc['chsemanal'] ?></td>
							</tr>
		<?php endforeach; ?>
						</tbody>
					</table>
				</p>
			</a>

			<a href="javascript:void(0);" class="list-group-item list-group-item-action">
				<div class="d-flex w-100 justify-content-between">
					<h5 class="mb-1">Encargos de Ocorrências Funcionais</h5>
				</div>
				<p class="mb-1">
					<table class="table">
						<thead>
							<tr>
								<th>Processo</th>
								<th>Descrição</th>
								<th>Natureza</th>
								<th>Início</th>
								<th>Término</th>
								<th>CH/S</th>
							</tr>
						</thead>
						<tbody>
		<?php foreach($teacher['function_charges'] as $fc): ?>
							<tr>
								<td><?= $fc['processo'] ?></td>
								<td><?= $fc['descricao'] ?></td>
								<td><?= $fc['natureza'] ?></td>
								<td><?= $fc['inicio'] ?></td>
								<td><?= $fc['termino'] ?></td>
								<td><?= $fc['chsemanal'] ?></td>
							</tr>
		<?php endforeach; ?>
						</tbody>
					</table>
				</p>
			</a>
		</div>
	<?php endif; ?>
<?php endif; ?>

	</div>

	<footer>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	</footer>
</body>

</html>
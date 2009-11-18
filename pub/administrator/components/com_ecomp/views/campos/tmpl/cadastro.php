<? defined('_JEXEC') or die('Acesso restrito'); ?>
<form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
	<div class="col100">
		<fieldset class="adminform">

			<legend><?php echo JText::_( 'Detalhes' ); ?></legend>
			<table class="admintable">
				<tr>
					<td width="100" align="right" class="key">
						<label for="greeting">Nome:</label>
					</td>
					<td>
						<input class="text_area" type="text" name="nome"
						size="100" maxlength="100" value="<?= @$this->row->nome?>" />
					</td>
				</tr>
				<tr>
					<td width="100" align="right" class="key">
						<label for="greeting">Alias:</label>
					</td>
					<td>
						<input class="text_area" type="text" name="alias"
						size="100" maxlength="100" value="<?= @$this->row->alias ?>" />
					</td>
				</tr>


				<tr>
					<td width="100" align="right" class="key">
						<label for="greeting">Componente:</label>
					</td>
					<td>
							<?
							$componente = new JCRUD(ECOMP_TABLE_COMPONENTES);

							if(!@$this->row->idcomponente)
							{
								echo '<select name="idcomponente">';
								$c = $componente->busca_por_sql("SELECT * FROM @tabela@ WHERE trashed != 1 ORDER BY nome ASC");

								foreach($c as $comp)
								{
									$select = @$this->row->idcomponente == $comp->id ? ' selected="selected"' : '';
									echo "<option value=\"{$comp->id}\"{$select}>{$comp->nome}</option>";
								}
								echo '</select>';
							}
							else
							{
								$componente = $componente->busca_por_id($this->row->idcomponente);
								echo $componente->nome;
							}
							?>

					</td>
				</tr>
				<tr>
					<td width="100" align="right" class="key">
						<label for="greeting">Tipo do campo:</label>
					</td>
					<td>
						<?
						if(!@$this->row->id)
						{
							$tipo = new JCRUD(ECOMP_TABLE_TIPOS);

							echo '<select name="idtipo">';
							$tipos = $tipo->busca_tudo("nome ASC");

							foreach($tipos as $tipo)
								echo "<option value=\"{$tipo->id}\">{$tipo->nome}</option>";
							echo '</select>';
						}
						else
						{
							$tipo = new JCRUD(ECOMP_TABLE_TIPOS, array( 'id' => $this->row->idtipo ));
							echo $tipo->nome;
						}
						?>
					</td>
				</tr>
				<tr>
					<td width="100" align="right" class="key">
						<label for="greeting"><?= JText::_( 'Ordem' ); ?>:</label>
					</td>
					<td>
						<input class="text_area" type="text" name="ordering"
						size="5" maxlength="11" value="<?= @$this->row->ordering ?>" />
					</td>
				</tr>
				<tr>
					<td width="100" align="right" class="key">
						<label for="greeting"><?= JText::_( 'Publicado' ); ?>:</label>
					</td>
					<td>
						<?= $this->util('cadastro.published'); ?>
					</td>
				</tr>
				<tr>
					<td width="100" align="right" valign="top" class="key">
						<label for="greeting">Parâmetros:</label>
					</td>
					<td>
						<textarea name="params" cols="57" rows="2" class="text_area"><?= @$this->row->params ?></textarea>
						<p>Os parâmetros devem ser inserido no formato: var1=valor&var2=valor&var3=valor...</p>
						<p class="left">
							<table>
								<?php

									$tipos = new JCRUD(ECOMP_TABLE_TIPOS);
									$tipos = $tipos->busca_tudo("nome ASC");

									foreach($tipos as $tipo)
									{
										echo "<tr><td style=\"background: #F6F6F6;\">{$tipo->nome}</td><td style=\"background: #F6F6F6;\">{$tipo->params}</td></tr>";
									}
								?>
							</table>
						</p>
					</td>
				</tr>
			</table>
		</fieldset>
	</div>

	<div class="clr"></div>

	<?= $this->util('cadastro.hiddens')?>

</form>

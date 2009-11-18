<?
defined('_JEXEC') or die('Acesso restrito');

require_once(ECOMP_PATH_CLASS.DS.'ecomp.listas.class.php');
require_once(ECOMP_PATH_CLASS.DS.'ebasic.util.php');

$date_scripts = array();

$idcomponente = JRequest::getVar('idcomponente', 0);
?>
<form action="index.php" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
	<div class="col100">
		<fieldset class="adminform">

			<legend><?php echo JText::_( 'Detalhes' ); ?></legend>
			<table class="admintable">
				<?
				$campos = new JCRUD(ECOMP_TABLE_CAMPOS);
				$campos = $campos->busca("WHERE idcomponente = '{$idcomponente}' AND published = '1' AND trashed != '1' ORDER BY ordering, nome ASC");
				foreach($campos as $campo)
				{
					$tipo = new JCRUD(ECOMP_TABLE_TIPOS, array('id' => $campo->idtipo));

					$alias = $campo->alias;
					$name  = "dados[{$campo->id}][{$alias}]";

					parse_str($tipo->params, $params_padrao);
					parse_str($campo->params, $params_novos);

					$params = array_merge($params_padrao, $params_novos);
				?>
				<tr>
					<td width="100" align="right" class="key" valign="top" >
						<label for="greeting"><?= $campo->nome ?></label>
					</td>
					<td>
						<?
						// texto simples
						if($campo->idtipo == 1)
						{
							echo sprintf('<input class="text_area" type="text" name="%s" size="%s" maxlength="%s" value="%s" />',
								$name,
								$params['size'],
								$params['maxlength'],
								$this->row->id ? htmlspecialchars(@$this->row->$alias) : htmlspecialchars($params['value'])
							);
						}

						// Texto longo
						if($campo->idtipo == 2)
						{
							echo sprintf('<textarea name="%s" cols="%s" rows="%s">%s</textarea>',
								$name,
								$params['cols'],
								$params['rows'],
								@$this->row->$alias
							);
						}

						// HTML
						if($campo->idtipo == 3)
						{
							$editor =& JFactory::getEditor();
							$params_editor = array( 'smilies' => '0', 'style' => '0', 'layer' => '0', 'table' => '0', 'clear_entities' => '0');
							$value  = @$this->row->$alias;
                            echo $editor->display($name, $value, $params['width'], $params['height'], '60', '20', false, $params_editor);
						}

						// Upload
						if($campo->idtipo == 4)
						{
							echo sprintf('<input type="file" name="%s" /> Tamanho máximo: %s',
								$name,
								ini_get('upload_max_filesize')
							);
						}

						// Boolean
						if($campo->idtipo == 5)
						{
							$value = @$this->row->$alias;
							echo sprintf('<input type="radio" name="%s" value="0" %s />Não<input type="radio" name="%s" value="1" %s />Sim',
								$name,
								!$value ? 'checked="checked"' : '',
								$name,
								$value ? 'checked="checked"' : ''
							);
						}

						// Data
						if($campo->idtipo == 6)
						{
							$date_scripts[] = "myCal{$campo->id} = new Calendar({ date{$campo->id}: 'd/m/Y' });\n";
							echo sprintf('<input class="text_area datas" type="text" name="%s" size="12" maxlength="10" value="%s" />',
								$name,
								 eUtil::converteData(htmlspecialchars(@$this->row->$alias))
							);
						}

						// Data / Hora
						if($campo->idtipo == 7)
						{
							echo sprintf('<input class="text_area" type="text" name="%s" size="100" maxlength="100" value="%s" />',
								$name,
								htmlspecialchars(@$this->row->$alias)
							);
						}

						// Relacionamento
						if($campo->idtipo == 8)
						{

							$campo = new JCRUD(ECOMP_TABLE_CAMPOS, array('id' => $params['idcampo']));
							$componente = new JCRUD(ECOMP_TABLE_COMPONENTES, array('id' => $params['idcomponente']));


							if($campo->id && $componente->id)
							{
								echo '<select name="'.$name.'">';

								$rel = new JCRUD(ECOMP_TABLE_COMPONENTES.'_'.$componente->alias);
								$rels = $rel->busca("WHERE published = '1' ORDER BY ordering, {$campo->alias} ASC");

								foreach($rels as $rel)
								{
									$campo_alias = $campo->alias;
									echo sprintf('<option value="%s"%s>%s</option>',
										$rel->id,
										(@$this->row->$alias == $rel->id ? ' selected="selected"' : ''),
										$rel->$campo_alias
									);
								}

								echo '</select>';
							}
							else
								echo "Parâmetros inválidos!";
						}

						// Imagens da galeria
						if($campo->idtipo == 9)
						{
							echo '<select name="'.$name.'">';

							$params['idcadastro'] = $params['idcadastro'] ? $params['idcadastro'] : @$this->row->id;
							$params['idcomponente'] = $params['idcomponente'] ? $params['idcomponente'] : $idcomponente;

							$rel = new JCRUD(ECOMP_TABLE_CADASTROS_IMAGENS);
							$rels = $rel->busca("WHERE idcomponente = '{$params['idcomponente']}' AND idcadastro = '{$params['idcadastro']}' AND published = '1' ORDER BY ordering, legenda ASC");

							foreach($rels as $rel)
							{
								echo sprintf('<option value="%s"%s>%s</option>',
									$rel->id,
									(@$this->row->$alias == $rel->id ? ' selected="selected"' : ''),
									$rel->id . ' - '.($rel->legenda ? $rel->legenda : 'Sem legenda' )
								);
							}

							echo '</select>';
						}

						// combo simples
						if($campo->idtipo == 10)
						{
							$itens = explode('|', $params['itens']);

							echo '<select name="'.$name.'">';

							foreach($itens as $item)
							{
								list($valor, $texto) = explode(';', $item);
								echo sprintf('<option value="%s"%s>%s</option>',
									$valor,
									(@$this->row->$alias == $valor ? ' selected="selected"' : ''),
									$texto
								);
							}

							echo '</select>';
						}

						// Upload de imagem
						if($campo->idtipo == 11)
						{
							echo sprintf('<input type="file" name="%s" /> Tamanho máximo: %s',
								$name,
								ini_get('upload_max_filesize')
							);
						}

						// Número inteiro
						if($campo->idtipo == 12)
						{
							echo sprintf('<input class="text_area" type="text" name="%s" size="100" maxlength="100" value="%s" />',
								$name,
								htmlspecialchars(@$this->row->$alias)
							);
						}

						?>
					</td>
				</tr>
				<? } ?>
				<tr>
					<td width="100" align="right" class="key">
						<label for="greeting">Ordem:</label>
					</td>
					<td>
						<input class="text_area" type="text" name="ordering"
						size="5" maxlength="11" value="<?= @$this->row->ordering ?>" />
					</td>
				</tr>

				<tr>
					<td width="100" align="right" class="key">
						<label for="greeting">Publicado:</label>
					</td>
					<td>
						<?= $this->util('cadastro.published'); ?>
					</td>
				</tr>

				<tr>
					<td width="100" align="right" valign="top" class="key">
						<label for="greeting"></label>
					</td>
					<td>
						<table>
							<tr>
								<td align="center"><strong>Categorias</strong></td>
								<td align="center"><strong>Tags</strong></td>
							</tr>
							<tr>
								<td><?
									$lista = new ecompListas();
									$lista->getListaCategorias(@$this->row->id);
									?>
								</td>
								<td><?
									$lista = new ecompListas();
									$lista->getListaTags(@$this->row->id);
									?>
								</td>
							</tr>
						</table>
					</td>
				</tr>


			</table>
		</fieldset>
	</div>

	<div class="clr"></div>

	<input type="hidden" name="idcomponente" value="<?= $idcomponente ?>" />
	<?= $this->util('cadastro.hiddens')?>

</form>
<?php
if(count($date_scripts))
{
	$doc =& JFactory::getDocument();
	$doc->addScript('http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js');
	$doc->addScript(ECOMP_URL_MEDIA.'js/jquery.datepicker.js');
	$doc->addStyleSheet(ECOMP_URL_MEDIA.'js/jquery.datepicker.css');
	$doc->addScriptDeclaration("jQuery.noConflict(); jQuery(function($){ $('.datas').datepicker(); }); ");
}
?>

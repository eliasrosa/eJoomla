<?
defined('_JEXEC') or die('Acesso restrito');

if(!$this->row->id)
{
	$this->row->name = null;
	$this->row->subject = 'Contato do site: [Assunto]';
	$this->row->to = null;
	$this->row->from = '[Nome] <[E-mail]>';
	$this->row->replyto = '[Nome] <[E-mail]>';
	$this->row->cc = null;
	$this->row->co = null;
	$this->row->message = '[Mensagem]';
	$this->row->charset = 'utf-8';
	$this->row->type = 'text';
	$this->row->published = 1;
	$this->row->trashed = 0;
	$this->row->form = "
<p>Seu nome (obrigatório)<br/>
[text name=\"Nome\" rel=\"text_\"]</p>

<p>Seu e-mail (obrigatório)<br/>
[text name=\"E-mail\" rel=\"email_\"]</p>

<p>Assunto (obrigatório)<br/>
[text name=\"Assunto\" rel=\"text_\"]</p>

<p>Mensagem (obrigatório)<br/>
[textarea name=\"Mensagem\" rel=\"text_\"]</p>

[submit value=\"Enviar\" class=\"submit\"]
";
}

?>

<form action="index.php" method="post" name="adminForm" id="adminForm">
	<div class="col100">
		<fieldset class="adminform">
		  <legend><?php echo JText::_( 'Detalhes' ); ?></legend>
			<table width="100%" class="admintable">
				<tr>
					<td width="97" align="right" nowrap="nowrap" class="key">
						<label for="greeting"><?= JText::_( 'Nome' ); ?></label>
					</td>
					<td width="995">
						<input name="name" type="text" class="text_area" id="name" value="<?= $this->row->name?>"
						size="70" maxlength="100" />
					</td>
				</tr>
				<tr>
					<td align="right" nowrap="nowrap" class="key">
						<label for="greeting"><?= JText::_( 'Assunto' ); ?></label>
					</td>
					<td>
						<input name="subject" type="text" class="text_area" id="subject" value="<?= $this->row->subject?>"
						size="70" maxlength="255" />
					</td>
				</tr>
				<tr>
					<td align="right" nowrap="nowrap" class="key">
						<label for="greeting"><?= JText::_( 'Para:' ); ?></label>
					</td>
					<td>
						<input name="to" type="text" class="text_area" id="to" value="<?= $this->row->to ?>"
						size="70" maxlength="255" />
					</td>
				</tr>
				<tr>
				  <td align="right" class="key"><label for="greeting26">
				    <?= JText::_( 'From' ); ?>
				    </label></td>
				  <td><input name="from" type="text" class="text_area" id="from" value="<?= $this->row->from ?>"
						size="70" maxlength="255" /></td>
			  </tr>
				<tr>
				  <td align="right" class="key"><label for="greeting29">
				    <?= JText::_( 'Reply To' ); ?>
				    </label></td>
				  <td><input name="replyto" type="text" class="text_area" id="replyto" value="<?= $this->row->replyto ?>"
						size="70" maxlength="255" /></td>
			  </tr>
				<tr>
				  <td align="right" class="key"><label for="greeting25">
				    <?= JText::_( 'CC' ); ?>
				    </label></td>
				  <td><input name="cc" type="text" class="text_area" id="cc" value="<?= $this->row->cc ?>"
						size="70" maxlength="255" /></td>
			  </tr>
				<tr>
				  <td align="right" class="key"><label for="greeting24">
				    <?= JText::_( 'CO' ); ?>
				    </label></td>
				  <td><input name="co" type="text" class="text_area" id="co" value="<?= $this->row->co ?>"
						size="70" maxlength="255" /></td>
			  </tr>
				<tr>
					<td align="right" nowrap="nowrap" class="key">
						<label for="greeting"><?= JText::_( 'Formulário' ); ?></label>
					</td>
					<td>
						<textarea name="form" cols="85" rows="15" id="form"><?= stripslashes($this->row->form) ?></textarea>
					</td>
				</tr>
				<tr>
				  <td align="right" class="key"><label for="greeting13">
				    <?= JText::_( 'Mensagem' ); ?>
				    </label></td>
				  <td><textarea name="message" cols="85" rows="15" id="message"><?= stripslashes($this->row->message) ?></textarea></td>
			  </tr>
				<tr>
				  <td align="right" class="key"><label for="greeting28">
				    <?= JText::_( 'Publicado' ); ?>
				    </label></td>
				  <td><?= $this->util('cadastro.published'); ?></td>
			  </tr>
				<tr>
				  <td align="right" class="key"><?= JText::_( 'Tipo' ); ?></td>
				  <td>
			        <select name="type" id="type">
				        <option value="text" <?= $this->row->type == 'text' ? 'selected="selected"' : ''; ?>>Texto</option>
				        <option value="text/html" <?= $this->row->type == 'text/html' ? 'selected="selected"' : ''; ?>>HTML</option>
			          </select>
                    </td>
			  </tr>
				<tr>
				  <td align="right" class="key"><?= JText::_( 'Charset' ); ?></td>
				  <td>
                  	<select name="charset" id="charset">
				        <option value="utf-8" <?= $this->row->charset == 'utf-8' ? 'selected="selected"' : ''; ?>>UTF-8</option>
				        <option value="iso-8859-1" <?= $this->row->charset == 'iso-8859-1' ? 'selected="selected"' : ''; ?>>ISO-8859-1</option>
			          </select> <?= JText::_( 'Recomendado UTF-8' ); ?>
                  </td>
			  </tr>
			</table>
		</fieldset>
	</div>

	<div class="clr"></div>

	<?= $this->util('cadastro.hiddens')?>

</form>
<?
class createForm
{
	var
		$html,
		$listaCampos,
		$nCampos = 0,
		$campos = array(
			'text'     => '<input type="text" %attr% />',
			'textarea' => '<textarea %attr% ></textarea>',
			'submit'   => '<input type="submit" %attr% />',
			'button'   => '<input type="buttom" %attr% />',
			'reset'    => '<input type="reset" %attr% />',
			'checkbox' => '<input type="checkbox" %attr% />',
			'radio'    => '<input type="radio" %attr% />',
			//'file'     => '<input type="file" %attr% />',
			'hidden'   => '<input type="hidden" %attr% />',
			'password' => '<input type="password" %attr% />',
			'image'    => '<input type="image" %attr% />',
		);

	function __construct($html)
	{
		$this->html = $html;
	}

	function gets($tipo, $input)
	{
		$exp = '#\['.$tipo.'(\*|) (.+?)\]#';
		$retorno = array();
		preg_match_all($exp, $this->html, $resultado);
		for($i=0;$i<=count($resultado[0])-1;$i++)
		{
			$campo = array();
			$campo['code']    = $resultado[0][$i];

			// options
			parse_str($resultado[2][$i], $campo['attr']);

			// full
			$campo['options'] = $resultado[2][$i];

			// coloca os attr
			$campo['html'] = str_replace('%attr%', stripslashes($campo['options']), $input);

			//replace code pelo input
			$this->html = str_replace($campo['code'], $campo['html'], $this->html);

			$retorno[$this->nCampos]= $campo;
			$this->nCampos++;
		}

		return $retorno;

	}

	function buscaCampos()
	{
		$resultado = array();
		foreach($this->campos as $tipo=>$input)
		{
			$resultado = array_merge($resultado, $this->gets($tipo, $input));
		}
	}

	function ini($id)
	{
		$this->buscaCampos();

		//enctype="multipart/form-data"
		$this->html = '<form id="eformmail_'.$id.'" action="?option=com_eformmail&token='.md5('eformmail::'.$id).'" method="post" name="eFormMail" class="eFormMail">'.
					  '<input type="hidden" name="eformmail_id" class="hidden" value="'.$id.'" />'.
					  '<input type="hidden" name="eformmail_upload" class="false" value="0" />'.
					  $this->html.'</form>';

		return $this->html;
	}

}
?>

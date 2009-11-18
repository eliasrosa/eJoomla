<?php
// evitar acesso direto
defined('_JEXEC') or die('Acesso restrito');

class eBasicView extends JView
{
	var $tpl,
		$row,
		$eBasic,
		$comTitulo = '',
		$comIcone  = 'generic.png';

    function display($tpl = null)
    {
		$this->eBasic =& new eBasic();

		// Cadastro
		if($this->eBasic->task == 'edit' || $this->eBasic->task == 'add') $this->_cadastro();

		// Listagem
		if(!$this->eBasic->task || $this->eBasic->task == 'list') $this->_listagem();

		// Listagem
		if($this->eBasic->task == 'listTrash') $this->_lixeira();

		// Carrega os campos hidden do formulário de listagem
        $this->assignRef('util', $this->util);

		//carrega o $tpl
		$this->tpl = $tpl;
    }

	function _listagem($toolbar = true)
	{
		JToolBarHelper::title( JText::_($this->comTitulo), $this->comIcone);

		if($toolbar)
		{
			JToolBarHelper::custom('listTrash', 'trash', 'trash', 'Lixeira', false, false);
			JToolBarHelper::divider();
			JToolBarHelper::publishList();
			JToolBarHelper::unpublishList();
			JToolBarHelper::deleteListX('Os registros selecionados serão movidos para a lixeira, deseja continuar?', 'moveTrash');
			JToolBarHelper::editListX();
			JToolBarHelper::addNewX();
		}

        // Pega dados do modelo
        $itens =& $this->get('Listagem');

		// Carrega os resultado da busca
        $this->assignRef('itens', $itens);

        parent::display($this->tpl);
	}

	function _cadastro($toolbar = true)
	{
		// desabilita o menu principal
		JRequest::setVar( 'hidemainmenu', 1);

		// pegar a mensagem
		$row =& $this->get('Cadastro');

		if($row->id < 1) $texto = JText::_('Novo');
		else $texto = JText::_('Editar');

		JToolBarHelper::title(JText::_($this->comTitulo).': [ '.$texto.' ]');

		if($toolbar)
		{
			JToolBarHelper::save();
			JToolBarHelper::cancel();
		}

		$this->row = $row;

		$this->assignRef('row', $row);

		parent::display($this->tpl);
	}

	function _lixeira($toolbar = true)
	{
        // desabilita o menu principal
		JRequest::setVar( 'hidemainmenu', 1);

		JToolBarHelper::title( JText::_($this->comTitulo). ': ['.JText::_('Trash').']', $this->comIcone);

		if($toolbar)
		{
			JToolBarHelper::deleteListX('Os registros selecionados serão removidos definitivamente, deseja continuar?');
			JToolBarHelper::custom('unTrash', 'save', 'save', 'Restaurar', true, false);
			JToolBarHelper::custom('list', 'forward', 'forward', 'Voltar', false, false);
		}

        // Pega dados do modelo
        $itens =& $this->get('Lixeira');

		// Carrega os resultado da busca
        $this->assignRef('itens', $itens);

        parent::display($this->tpl);
	}

	function util($cmd, $params = array())
	{
		$html = '';

		if($cmd == 'listagem.hiddens')
		{
			$html = "<input type=\"hidden\" name=\"option\" value=\"{$this->eBasic->option}\" />".
					"<input type=\"hidden\" name=\"view\" value=\"{$this->eBasic->view}\" />".
					"<input type=\"hidden\" name=\"task\" value=\"\" />".
					"<input type=\"hidden\" name=\"boxchecked\" value=\"0\" />";

		}


		// cria uma link para edição
		if($cmd == 'listagem.link')
		{
			// extrai as variaveis
			extract($params);
			
			// apaga params inuteis
			unset($params['nome'], $params['id']);
			
			// titulo
			$titulo = isset($titulo) ? $titulo : '';
			
			// extrai os parametros padroes
			$defaut = array( 'option' => $this->eBasic->option, 'view' => $this->eBasic->view, 'task' => 'edit', 'cid' => array($id));
			
			
			$params = array_merge($defaut, $params);
			
			
			$u =& JURI::getInstance('');

			// cria o href do link
			$link = JRoute::_('?'.$u->buildQuery($params));

			// cria o html
			$html = "<a title=\"{$titulo}\" href=\"{$link}\">{$nome}</a>";
		}


		if($cmd == 'cadastro.hiddens')
		{
			$html = "<input type=\"hidden\" name=\"option\" value=\"{$this->eBasic->option}\" />".
					"<input type=\"hidden\" name=\"view\" value=\"{$this->eBasic->view}\" />".
					"<input type=\"hidden\" name=\"task\" value=\"\" />".
					"<input type=\"hidden\" name=\"id\" value=\"{$this->row->id}\" />";
		}


		if($cmd == 'cadastro.published')
		{
			$put[] = JHTML::_('select.option',  '0', JText::_( 'Não' ));
			$put[] = JHTML::_('select.option',  '1', JText::_( 'Sim' ));

			$html = JHTML::_('select.radiolist',  $put, 'published', '', 'value', 'text', $this->row->published );
		}

		return $html;
	}
}
?>

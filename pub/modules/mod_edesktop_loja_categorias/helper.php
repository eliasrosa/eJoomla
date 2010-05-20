<?php
defined('_JEXEC') or die( "Acesso Restrito" );

class modEdesktopLojaCategoriasHelper
{
	public function montaMenu($idpai = 0, $Itemid = 0)
	{
		jimport('edesktop.programas.produtos.categorias');
		
		$cats = new edesktop_produtos_categorias();
		$cats = $cats->busca_por_idpai($idpai);		
		$m = '';
		
		if(count($cats))
		{
			$class = ($idpai != 0) ? '' : ' class="menu"';
			$m .= "<ul{$class}>";
			
			foreach($cats as $cat)
			{
				$s = modEdesktopLojaCategoriasHelper::montaMenu($cat->id, $Itemid);
				$class = ($s == '') ? '' : ' class="pai"';
				$href = JROUTE::_("index.php?option=com_edesktop&view=loja&layout=categoria&Itemid={$Itemid}&id={$cat->id}");

				$m .= "<li{$class}><a href=\"{$href}\">{$cat->nome}</a>{$s}</li>";
			}
						
			$m .= "</ul>";
		}
			
		return $m;
	}
}
?>


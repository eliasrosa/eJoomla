<?
JHTML::script('jquery.cycle.all.min.js', $edBanners->url['js'], false);
echo "<script type=\"text/javascript\">$(function(){ $('#{$tagID} .corpo .imagens').cycle({$banner->params}); });</script>";

echo "<div class=\"imagens\" style=\"width: {$banner->largura}px; height: {$banner->altura}px; overflow: hidden;\">";
foreach($slides as $s)
{
	$link = $s->url ? JRoute::_($s->url) : 'javascript:void(0);';
	$target = $s->target ? ' target="' .$s->target. '"' : '';

	echo "<a href=\"{$link}\"{$target} style=\"background: url([eimage src='{$s->arquivo}' width='{$banner->largura}' height='{$banner->altura}' fit='outside']) center center; width:{$banner->largura}px; height:{$banner->altura}px; display: block;\"></a>";
}
echo '</div>';

echo '<div class="nav"></div>';

?>
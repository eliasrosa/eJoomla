<?php

/**
 * JosEdesktopProdutos
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Produto extends BaseJosEdesktopProdutos
{
   public function setUp()
    {
        parent::setUp();
			
		$this->hasOne('Fabricante', array(
			'local' => 'idfabricante',
			'foreign' => 'idfabricante'
		));

		$this->hasMany('Imagem as Imagens', array(
			'local' => 'idproduto',
			'foreign' => 'idproduto'
		));

		$this->hasMany('Texto as Textos', array(
			'local' => 'idproduto',
			'foreign' => 'idproduto'
		));

		$this->hasMany('Categoria as Categorias', array(
			'local' => 'idproduto',
			'foreign' => 'idcategoria',
			'refClass' => 'CategoriaRel'
		));
		
		Doctrine::getTable('Produto')->addRecordListener(new ProdutoHydrationListener());
		
   }

}

class ProdutoHydrationListener extends Doctrine_Record_Listener
{
    public function preHydrate(Doctrine_Event $event)
    {
		$data = $event->data;

		$img = Doctrine_Query::create()
					->from('Imagem')
					->where('idproduto = ?', $data['idproduto'])
					->andWhere('status = ?', 1)
					->orderBy('destaque DESC')
					->limit(1);

		$img = $img->fetchOne();
        
        if(!$img)
		{
			$img = new stdClass();
			
			jimport('edesktop.programas.produtos');
			$img->idimagem = '';
			$img->idproduto = '';
			$img->nome = '';
			$img->destaque = '';
			$img->status = '';
			$img->url = edProdutos::getUrl('404');
		}
       
		$data['imagem'] = $img;
       
        $event->data = $data;
    }
}

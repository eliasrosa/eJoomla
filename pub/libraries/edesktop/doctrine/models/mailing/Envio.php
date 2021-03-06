<?php

/**
 * JosEdesktopMailingEnvios
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Envio extends BaseJosEdesktopMailingEnvios
{
	public function setUp()
	{
		parent::setUp();

		$this->hasOne('Email', array(
			'local' => 'idemail',
			'foreign' => 'id'
		));

		$this->hasOne('Contato', array(
			'local' => 'idcontato',
			'foreign' => 'id'
		));

		$this->hasOne('User', array(
			'local' => 'idusuario',
			'foreign' => 'id'
		));

	}

}
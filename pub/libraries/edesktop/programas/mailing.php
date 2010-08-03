<?
jimport('edesktop.programas.base');
Doctrine_Core::loadModels(dirname(__FILE__) .DS. 'mailing' .DS);

class edMailing extends eDesktoBase
{

	public function enviar_email($contato, $idemail)
	{
		$email = $this->busca_email_ativo_id($idemail);		
		if(!$email)
			return $retorno = array(
				'retorno' => false,
				'msg' => 'E-mail não encontrado!',
				'tipo' => 'error'
			);

		$subject = $email->assunto;
		$message = $this->createHtml($email, $contato);
		$from    = "{$email->Remetente->nome} <{$email->Remetente->email}>";

		$headers = 'MIME-Version: 1.0' . "\r\n" .
				   'Content-type: text/html; charset=uft-8' . "\r\n" .
				   'From: ' . $from . "\r\n" .
				   'Reply-To: ' . $from . "\r\n" .
				   'X-Mailer: PHP/' . phpversion() . "\r\n" .
				   'eDesktop: Mailing/1.0' . "\r\n";


		if(@mail($contato, $subject, $message, $headers))
		{
			$dados = array( 'nome' => '', 'email' => $contato, 'status' => 1);
			$contato = $this->salva_contato($dados);
			
			if($contato['retorno'])
				$retorno = array(
					'retorno' => true,
					'msg' => 'E-mail enviado com sucesso!\nO contato '. $dados['email'] .' foi cadastrado com sucesso!'
				);
			else
				$retorno = array(
					'retorno' => true,
					'msg' => 'E-mail enviado com sucesso!'
				);
		}
		else
		{
				$retorno = array(
					'retorno' => false,
					'msg' => 'Houve um erro ao enviar o e-mail!',
					'tipo' => 'error'
				);
		}	
			
		return $retorno;
	}


	public function createHtml(Email $email, $contato)
	{
		$html = file_get_contents($email->file_url);

		preg_match_all('#<img.*?src="(.+?)".*?/>#', $html, $result);
		
		for($i=0; $i < count($result[0]); $i++)
		{
			$img = $result[0][$i];
			$file = $result[1][$i];
			
			$fileNew = $email->base_url .'/'. $file;

			$imgNew = str_replace($file, $fileNew, $img);
			$html = str_replace($img, $imgNew, $html);
		}
		
		$u =& JURI::getInstance();
		$host = $u->getScheme() .'://'. $u->getHost();
		
		$sid = $this->getSID($email->id, $contato);
		
		preg_match('#<body.*?>#', $html, $result);
		$link = $host . JROUTE::_('index.php?option=com_edesktop&view=mailing&layout=exibir&id=' .$email->id. '&e=' .$contato. '&sid=' .$sid. '&Itemid=200');
		$linkTopo = $result[0]. '<center><font size="1" color="#000000" face="Arial">Caso não consiga visualizar este e-mail corretamente, <a href="' .$link. '" style="color:#0000ff;">clique aqui!</a></font></center><br />'."\n";
		$html = str_replace($result[0], $linkTopo, $html);
			
		return $html;	
	}

	public function getSID($id, $contato)
	{
		return sha1(md5("{$id}::{$id}::{$contato}"));
	}

	public function salva_contato($dados)
	{
		$dql = Doctrine_Query::create()
			->from('Contato c')
			->where('c.email = ?', $dados['email']);
		
		$dql = $dql->execute();

		if(!count($dql))
		{
			$c = new Contato();
			$c->nome = $dados['nome'];
			$c->email = $dados['email'];
			$c->status = $dados['status'];	
			$c->save();

			return array(
				'retorno' => true,
				'msg' => 'Contato cadastrado com sucesso!',
				'obj' => $c
			);
		}
		else
		{
			return array(
				'retorno' => false,
				'msg' => 'Esse contato já está cadastrado!',
				'obj' => $dql,
				'tipo' => 'error'
				
			);
		}
	}



	public function busca_todos_emails_ativos()
	{
		$dql = Doctrine_Query::create()
			->from('Email e')
			->innerJoin('e.Remetente r WITH r.status = 1')
			->where('e.status = 1');
			
		return $dql->execute();
	}


	public function busca_email_ativo_id($id)
	{
		$id = util::int($id, 0);
	
		$dql = Doctrine_Query::create()
			->from('Email e')
			->innerJoin('e.Remetente r WITH r.status = 1')
			->where('e.status = 1')
			->andWhere('e.id = ?', $id);
			
		return $dql->fetchOne();
	}

}
?>
<?
class process
{
	private 
		$session = array(),
		$processos = array();
	
	
	public function __construct()
	{
		$this->session =& JFactory::getSession();
		$this->load_session();
	}


	private function load_session()
	{
		$this->processos = $this->session->get('eDesktop.process', array());		
	}
	

	private function save_session()
	{
		$this->session->set('eDesktop.process', $this->processos);		
	}


	private function next_processID()
	{
		return count($this->processos) + 1000;
	}


	public function add()
	{
		$programa = JRequest::getvar('programa', false);
		if($programa)
		{
			$processID = $this->next_processID();
			
			$dados = array(
				'id' => $processID,
				'programa' => $programa,
				'criado'  => date("d/m/Y H:i:s")
			);
			
			$this->processos[$processID] = $dados;
			$this->save_session();
			
			$this->get($processID);
		}
		else
		{
			echo "Programa inválido";
		}
	}


	public function get($processID = 0)
	{
		if(!$processID)
			$processID = JRequest::getInt('processID');
		
		if($processID && isset($this->processos[$processID]))
		{	
			$process = $this->processos[$processID];

			jimport('edesktop.programa');		
			
			$programa = new programa();				
			$programa = $programa->get_config($process['programa']);
			
			$dados = array_merge($process, $programa);
								
			echo json_encode($dados);
		}
		else
		{
			echo "Processo não encontrado: #$processID";
		}
	}


	public function remove()
	{
		$processID = JRequest::getInt('processID');
		if($processID && isset($this->processos[$processID]))
		{	
			unset($this->processos[$processID]);
			$this->save_session();
		}
		else
		{
			echo "Processo não encontrado: #$processID";
		}
	}	
	
}



?>

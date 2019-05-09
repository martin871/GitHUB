<?php
/**
 * @Author Martin Ucan May
 */
class Peticiones
{	
	public $url = 'https://api.github.com/search/repositories?q=';
	public $search = '';
	public $total = 0;	
	public $page = 0;

	function __construct()
	{}

	/**
	* Devuelve el listado  de repositorios
	*
	* @return string
	*/
	function getHtml(){
		$html = $license = "";
		$obj = $this->getAPI();
		$this->total = count($obj['items']);
		if($this->total == 0)
			return $html;

	  	$indice = ($this->page==1)?0:($this->page - 1)*10;		
		$array = array_slice($obj['items'], $indice, 10);
		foreach ($array as $value) {
			
			if(is_array($value['license'])){
				$license = $value['license']['name'];
			}

			$html .= '<div class="row col-md-8 border-bottom mx-auto">
	                    <div class="col-md-2">
	                    	<img src="'.$value['owner']['avatar_url'].'" class="img-thumbnail" />
	                    </div>
	                    <div class="col-md-8">
	                    	<div class="col-md-8">
	                    	<h5>
	                    		<a href="#" data-toggle="modal" onclick="comentarioRepositorio(this);" data-target="#exampleModalScrollable" data-repos="'.$value['full_name'].'" data-license="'.$license.'"><em>'.$value['full_name'].'</em></a>
	                    	</h5>
	                        <small class="d-block mb-3 text-muted">'.$value['description'].'</small>
	                        </div>
							
	                        <small class="d-block mb-3 text-muted"><span class="badge badge-info">'.$license.'</span> Update on '.date('F j, Y', strtotime($value['updated_at'])).'</small>
	                    </div>
                        <div class="col-md-2">
                          <small class="d-block mb-3 text-muted">'.($value['language']==null?"":$value['language']).'</small>
                        </div>
	                    <hr>
	                 </div>';
		 }

		return $html;			
	}

	/**
	* Configuracion para la conexion con la API de GitHub
	*
	* @return JSON: devuelve todos los repositorios
	*/
	function getAPI(){
		$curl = curl_init();
		
		curl_setopt_array($curl, [
		    CURLOPT_RETURNTRANSFER => 1,
		    CURLOPT_URL => $this->url.=$this->search,
		    CURLOPT_USERAGENT => 'Codular Sample cURL Request',
		    CURLOPT_SSL_VERIFYPEER => false
		]);
		
		$resp = curl_exec($curl);
		
		curl_close($curl);

		return json_decode($resp, true);
	}

	/**
	* Paginacion
	*
	* @return string: devuelve la paginacion	
	*/
	function paginacion(){
		$html = "";		
		$final = $inicio = 0;
		if($this->total == 0)
			return $html;

		$tPages = ceil($this->total  / 10);
		$pag = $tPages < 4?$tPages:4;
		$l = floor($pag / 2);

		if(($this->page - $l)>=1){
			$inicio = $this->page - $l;
		}else{
			$inicio = 1;
			$final = $final + abs($this->page - $l);
		}

		if(($this->page + $l)<=$tPages){
			$final += $this->page +  $l  ;
		}else{
			$final = $tPages;
			$inicio -= (($this->page +  $l ) - $tPages);
		}
		
		$html .= '<ul class="pagination justify-content-end col-md-8">';
		
			$html .= $this->page>1?'<li class="page-item"><a class="page-link" href="index.php?q=laravel&page='.($this->page-1).'">Previous</a></li>':'';

			for ($i=$inicio; $i <= $final; $i++) { 
				$html .= '<li class="page-item '.($this->page==$i?'disabled':'').'">
							<a class="page-link" href="'.($this->page!=$i?'index.php?q=laravel&page='.$i:'').'" >'.$i.'</a>
						  </li>';
			}
			$html .= ($this->page < $tPages)?'<li class="page-item"><a class="page-link" href="index.php?q=laravel&page='.($this->page+1).'">Next</a></li>':'';
		
		$html .= '</ul>';

		return $html;
	}
}
<?php
/**
     * Constructor de la clase AutomataFD
     * @param string $estadoInicial El estado inicial del autómata
     * @param array $estadosFinales Un array de estados finales del autómata
     * @param int $cantidadFinales La cantidad de estados finales
     * @param array $transiciones Un array de transiciones del autómata
     */
class AutomataFD{
	private $estadoInicial;
	private $estadosFinales;
	private $cantidadFinales;
	private $transiciones;

	public function __construct($estadoInicial, $estadosFinales, $cantidadFinales, $transiciones){
		$this->estadoInicial = $estadoInicial;
		$this->estadosFinales = $estadosFinales;
		$this->cantidadFinales = $cantidadFinales;
		$this->transiciones = $transiciones;
	}
	public function getestadoInicial(){
		return $this->estadoInicial;
	}

	public function getestadosFinales(){
		return $this->estadosFinales;
	}
	
	public function getcantidadFinales(){
		return $this->cantidadFinales;
	}
	public function gettransiciones(){
		return $this->transiciones;
	}
	

}
function pivote($transiciones, $estadoActual, $letra){
    $i = 0;
    $esTransicion = function($i) use ($transiciones, $estadoActual, $letra) {
        return ($estadoActual != $transiciones[$i * 3] || $letra != $transiciones[$i * 3+1]);
    };

    while ($esTransicion($i)) {
        $i++;
    }

    return $transiciones[$i * 3 + 2];
}



function esFinal($autom, $ultimoEstado){
	return in_array($ultimoEstado, $autom->getestadosFinales());
}


echo "Implementacion de un automata finito determinista\n";

$json = file_get_contents("automata.json");

//echo $json;
$info = json_decode($json, true);
$autom = new AutomataFD($info['estadoInicial'],
							$info['estadosFinales'], 
							$info['cantidadFinales'],
							$info['transiciones']);

echo "Automata finito determinista encontrado: \n";
echo "Estado inicial: ".$autom->getestadoInicial()."\n";
echo "Estados finales: ";
array_map(function($num) { echo $num; }, $autom->getestadosFinales());
echo "\nCantidad de estados finales: ".$autom->getcantidadFinales()."\n";
echo "Transiciones: ";
array_map(function($num) { echo $num . ","; }, $autom->gettransiciones());

echo"\nIngrese la palabra a evaluar: \n";
$palabra = trim(fgets(STDIN));


$estadoActual = $autom->getestadoInicial();
for($i = 0; $i < strlen($palabra); $i++){	
	$estadoActual = pivote($autom->gettransiciones(), $estadoActual, $palabra[$i]);
}

if(esFinal($autom, $estadoActual)){
	echo "La palabra es aceptada por el automata\n";
}else{
	echo "La palabra no es aceptada por el automata\n";
}







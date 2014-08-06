<style type="text/css">
* {
	font-size: 12px;
	
}
.divImage{
	border:1px solid white; width:48%;float:left;
}
IMG.centrer {
	 display: block;
    margin-left: auto;
    margin-right: auto
}
</style>
<?php
include_once("class.php");

$weather = new wMeteo();
$code 	 = $weather->getCityCode('Laon, France'); //changez la ville ici
$days	 = $weather->getWeather($code, 3); // 3 est le nom de jour sur laquel la méteo s'affichagera max 10 jours)

//affiche le tableau de données
// echo "<pre>";
// print_r($days);
// echo "</pre>";


//debut du tableau
echo '<table cellpadding="4" cellspacing="1" border="1">
<tr>';

//premiere ligne du tableau (optionnelle)
echo '<tr>
      <td align="center">actuel</td>
      <td colspan="3" align="center">previsions</td>
    </tr>';

//pour chaque jour
foreach ($days as $day => $value)
{
 	echo '<td>'; //une nouvelle ligne 

 	if ($day == "actuel") {

 		echo "Temp ".$value["temperature"]." °C<br>"; 
 		echo "T ressentie ".$value["temperatureRessentie"]." °C<br>"; 
 		echo "Humidite ".$value["humidite"]." %<br>"; 
 		echo "Indice UV ".$value["uv"]["i"].""; 

 	} else {

	 	echo "<strong>".$value["jour"]."</strong><br>"; //affiche le jour
	    echo "temperature Max : ".$value["TempMax"]." °C<br>"; 
	    echo "temperature Min : ".$value["TempMin"]." °C<br>";

	    $parties = $value["partie"];
	    //pour chaque partie de la journée
	    foreach ($parties as $p => $value)
		{

			echo '<div class="divImage">
			<img class="centrer" src="./pic_meteo/'.$value["icon"].'" title="'.$value["t"].'"/>
			</div>';

		}

 	}
 	
    echo '</td>'; 
}

//fin du tableau
echo '</tr>
</table>';
?>
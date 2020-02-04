<?php
$string = file_get_contents("dictionnaire.txt", FILE_USE_INCLUDE_PATH);
$dico = explode("\r\n", $string);

$nbMot = count($dico);
$Q = 0;



echo "<h4>Combien de mots contient ce dictionnaire ? </h4>";
echo count($dico);

echo "<h4>Combien de mots font exactement 15 caractères ?</h4>";
echo count(array_filter($dico, function($x){
        return strlen($x) == 15;
    }));

echo '<h4>Combien de mots contiennent la lettre « w » ?</h4>';
$nbWord = 0;
foreach($dico as $w){
    if (stristr($w, 'w')){
        $nbWord++;
    };
} echo $nbWord . "<br>";

echo '<h4>Combien de mots finissent par la lettre « q » ?</h4>';

for ($i =0; $i < $nbMot; $i++){
    if (substr($dico[$i],-1,1) =='q'){
        $Q++;
    }
}

echo "Il y a " .$Q." mot finissant par Q <br><br>";


$string = file_get_contents("films.json", FILE_USE_INCLUDE_PATH);
$brut = json_decode($string, true);
$top = $brut["feed"]["entry"]; # liste de films

echo "<h4>Afficher le top10 des films sous cette forme :</h4>";

foreach ($top as $key => $value):
    if($key < 10):
        echo $key+1 ." : ".$value ['im:name']['label']."<br>";
    endif;
    endforeach;

echo "<h4>Quel est le classement du film « Gravity » ?</h4>";

foreach ($top as $key => $value):
    $film = $value['im:name']['label'];
    if($film == 'Gravity'):
        echo "<br>".$film." est classé n°".$key."<br>";
    endif;
endforeach;

echo "<h4>Quel est le réalisateur du film « The LEGO Movie » ?</h4>";

foreach ($top as $key => $value):
    $film = $value['im:name']['label'];
    $reali = $value['im:artist']['label'];
    if($film == 'The LEGO Movie'):
        echo "<br>".$reali." est le réalisateur de ".$film."<br>";
    endif;
endforeach;

echo "<h4>Combien de films sont sortis avant 2000 ?</h4>";

$vieu = 0;
foreach ($top as $key => $value):
    $date = $value['im:releaseDate']['label'];
    if($date < 2000):
        $vieu++;
    endif;
endforeach;
echo "<br>Il y a ".$vieu." films sortis avant 2000";

echo "<h4>Quel est le film le plus récent ? Le plus vieux ?</h4>";

foreach ($top as $key => $value){
    $filmYoungOld[$value ['im:name'] ['label']] = substr($value ['im:releaseDate']['label'], 0, 10) . "<br>";
}
foreach ($filmYoungOld as $key => $value){
    if ($value == max($filmYoungOld)){
        echo  "Nom du film le plus récent : " . $key . ", date de Sortie : " . max($filmYoungOld) . "<br>";
    }
    if ($value == min($filmYoungOld)){
        echo "Nom du film le plus vieux : " . $key . ", date de Sortie : " . min($filmYoungOld)."<br>" ;
    }
}


echo "<h4>Quelle est la catégorie de films la plus représentée ?</h4>";

foreach ($top as $key => $value){
    $array[] = $value['category']['attributes']['label'];
    $arrayCount = array_count_values($array);

}
foreach ($arrayCount as $key => $value){
    if($value == max($arrayCount)){
        echo $key."<br>";
    }
}


echo "<h4>Quel est le réalisateur le plus présent dans le top 100 ?</h4>";

foreach ($top as $key => $value){
    $director[] = $value['im:artist']['label'];
    $arrayCount = array_count_values($director);
}

foreach ($arrayCount as $key => $value){
    if ($value == max($arrayCount)){
        echo $key."<br>";
    }
}

echo "<h4>Combien cela coûterait-il d'acheter le top10 sur iTunes ? de le louer ?</h4>";

$num = 0;
foreach ($top as $key => $value){
    if($key < 10){
        $num += $value['im:price']['attributes']['amount'];
    }
}
echo "Pour acheter le top10, il vous faudrait : $num €<br>";

echo "<h4>Quel est le mois ayant vu le plus de sorties au cinéma ?</h4>";

foreach ($top as $key => $value){
    $array = explode (" ", $value['im:releaseDate']['attributes']['label']);//explode = "explose" une string de plusieurs mots à chaques espaces " " pour en faire un array.
    $mois[] = $array[0];
    $arrayCount = array_count_values($mois);
}
foreach ($arrayCount as $key => $value){
    if ($value == max($arrayCount)){
        echo "Le mois avec le plus de sortie est : " . $key . " : " . $value . " sorties" . "<br>";
    }
}

echo "<h4>Quels sont les 10 meilleurs films à voir en ayant un budget limité ?</h4>";

foreach ($top as $key => $value){
    $film = $value['im:name']['label'];
    $prix = $value['im:price']['attributes']['amount'];
    if($prix < 8 && $film < 10){
        echo "Les meilleurs films à prix limité sont : $film à $prix <br>";
    }
}


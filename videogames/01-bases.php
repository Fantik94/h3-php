<?php

    //variables
    $myVar = 'value';
    $myNumber = 30;
    $myBool = true;

    //var_dump déboguer
    //var_dump($myVar, $myBool);

    // echo: afficher une chaise de caractères
    //concaténation: utilisation du point ou de doubles guillemets
    //echo '<h1>' .$myVar . ' ' . $myNumber. '</h1>';

    //echo "<h2>$myVar $myNumber</h2>";

    //functions
    function myFunction(string $name, int $age = 10):void
    {
        echo "<p>Hello $name ! </p>";
        echo "<p>$age years old</p>";
    }

    //myFunction('world', 20);

    myFunction(age: 5, name: 'Toto');

    function display(string $message):string
    {
        return "<p>
            <em>$message</em>
        </p>";
    }

    $message = display('Coucou');
    echo $message;

    echo display('Coucou');

    $myArray = [ 'value', true, 20, []];

    echo "<p>$myArray[0] $myArray[2]</p>";

    array_push($myArray, 'new value');

    echo '<pre>'; var_dump($myArray); echo '</pre>';

    $myAssocArray = [
        'key0' => 'value0',
        'key1' => true,
        'key2' => 20,
        'key3' => ['Coucou',
        ],

    ];

    echo "<h1> {$myAssocArray['key2']} {$myAssocArray['key3'][0]}</h1>";

    echo 'il y a entrées '.count($myAssocArray).' dans le tableau';

    $newArray = array_filter($myArray, fn($value) => $value == 20);
    var_dump($newArray);


    //conditions
    $temperature = 15;

    if($temperature < 8){
        echo 'il fait froid';
    }elseif ($temperature > 0 && $temperature < 10){
        echo 'il fait tempéré';
    } else {
        echo 'il fait chaud';
    }

    echo "<p>". $temperature < 8 ? 'il fait froid': 'il fait chaud' . "</p>";

    $newArray = ['value0', 'value1', 'value2'];
    $html = '<ul>';

    for($i = 0; $i < count($newArray); $i++){
        $html .= "<li>$newArray[$i]</li>";
    }

    $html .= '</ul>';

    echo $html;


    $countries = [
        'france' => 'fr',
        'italie' => 'it',
        'allemage' => 'de',
        'espagne' => 'es',
    ];

    $html = '<ol>';
    foreach($countries as $country => $code){
        $html .= "<li>$country : $code</li>";
    }
    $html .= '</ol>';
    echo $html;

    $test = isset( $var);
    var_dump($test);

    $test2;
    var_dump(empty($test2));

    $test3 = 'value';
    echo $test3 ?? '<p>no value</p>';
    echo $test4 ?? '<p>no value</p>';



    //Exo 1
    $date = 21;
    $mois = "juin";
    $number = 1234.56;
    echo "Le" . " $date" . " $mois" . " est le premier jour de l'été";
  
    $nombre_format_francais = number_format($number, 2, ',', ' ');
    echo "\n" . $nombre_format_francais;



    //Exo 2
    function mettre_en_forme($phrase, $balise) {
        switch ($balise) {
          case 'b':
            $balise_html = 'strong';
            break;
          case 'i':
            $balise_html = 'em';
            break;
          case 's':
            $balise_html = 's';
            break;
          case 'u':
            $balise_html = 'u';
            break;
          default:
            $balise_html = 'span';
        }
        return '<' . $balise_html . '>' . $phrase . '</' . $balise_html . '>';
    }
    
    $texte = "phrase";
    $balise = "s";
    $texte_formate = mettre_en_forme($texte, $balise);
    echo $texte_formate;
?>
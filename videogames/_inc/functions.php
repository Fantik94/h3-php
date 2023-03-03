<?php

function processContactForm(): void
{
    if( isSubmitted() && isValid() ){
        echo 'formulaire soumis et validé';
    }
}

//tester la soumission de formulaire
function isSubmitted(): bool
{
    //submit est le name du bouton de validation
    return isset( $_POST['submit'] );
}

//récupérer la saisie
function getValues(): array
{
    return $_POST;
}

function isValid():bool
{
    $constraints = [
        'email' => [
            'isValide' => isNotBlank(getValues()['email']),
            'error' => "L'email est invalide",
        ],

        'subject' => [
            'isValide' => isNotBlank(getValues()['subject']),
            'error' => "Le sujet est obligatoire",
        ],

        'message' => [
            'isValide' => isNotBlank(getValues()['message']),
            'error' => "Le message est obligatoire",
        ],
    ];

    return checkConstraints($constraints);
}

function checkConstraints(array $constraints):bool
{
    $GLOBALS['errors'] = [];

    $valid = true;

    foreach($constraints as $name => $value){

        var_dump($value['isValide']);

        if(!$value['isValide']){

            array_push($GLOBALS['errors'], $value['error']);

            $valid = false;

        }
    }

    return $valid;
}

function getErrors():array|null
{
    return $GLOBALS['errors'] ?? null;
}

function isNotBlank(string | null | array $value):bool{
    return !empty($value);
}

function dbConnection():PDO{
    $connection = new PDO('mysql: host=127.0.0.1; dbname=project', 'root', '', [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    return $connection;
}

//insertion d'un contact
function insertContact(array $data):void
{
    $db = dbConnection();

    //requête SQL
    $sql = '
        INSERT INTO project.contact
        VALUE (
            NULL,
            :email,
            :subject,
            :message
        );
    ';

    //préparation (sécurisation de la requête)
    $query = $db->prepare( $sql );

    $query->execute();
}
<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Messages de langue pour la validation
    |--------------------------------------------------------------------------
    |
    | Les lignes de langue suivantes contiennent les messages d'erreur par défaut utilisés par
    | la classe de validateur. Certaines de ces règles ont plusieurs versions telles
    | que les règles de taille. N'hésitez pas à ajuster chacun de ces messages ici.
    |
    */

    'accepted' => ':attribute doit être accepté.',
    'accepted_if' => ':attribute doit être accepté lorsque :other est :value.',
    'active_url' => ':attribute n\'est pas une URL valide.',
    'after' => ':attribute doit être une date postérieure à :date.',
    'after_or_equal' => ':attribute doit être une date postérieure ou égale à :date.',
    'alpha' => ':attribute doit contenir uniquement des lettres.',
    'alpha_dash' => ':attribute doit contenir uniquement des lettres, des chiffres, des tirets et des underscores.',
    'alpha_num' => ':attribute doit contenir uniquement des lettres et des chiffres.',
    'array' => ':attribute doit être un tableau.',
    'before' => ':attribute doit être une date antérieure à :date.',
    'before_or_equal' => ':attribute doit être une date antérieure ou égale à :date.',
    'between' => [
        'numeric' => ':attribute doit être compris entre :min et :max.',
        'file' => ':attribute doit être compris entre :min et :max kilo-octets.',
        'string' => ':attribute doit avoir entre :min et :max caractères.',
        'array' => ':attribute doit avoir entre :min et :max éléments.',
    ],
    'boolean' => 'Le champ :attribute doit être vrai ou faux.',
    'confirmed' => 'La confirmation de :attribute ne correspond pas.',
    'current_password' => 'Le mot de passe est incorrect.',
    'date' => ':attribute n\'est pas une date valide.',
    'date_equals' => ':attribute doit être une date égale à :date.',
    'date_format' => ':attribute ne correspond pas au format :format.',
    'declined' => ':attribute doit être refusé.',
    'declined_if' => ':attribute doit être refusé lorsque :other est :value.',
    'different' => ':attribute et :other doivent être différents.',
    'digits' => ':attribute doit avoir :digits chiffres.',
    'digits_between' => ':attribute doit avoir entre :min et :max chiffres.',
    'dimensions' => ':attribute a des dimensions d\'image non valides.',
    'distinct' => 'Le champ :attribute a une valeur en double.',
    'email' => ':attribute doit être une adresse e-mail valide.',
    'ends_with' => ':attribute doit se terminer par l\'un des éléments suivants : :values.',
    'enum' => ':attribute sélectionné est invalide.',
    'exists' => ':attribute sélectionné est invalide.',
    'file' => ':attribute doit être un fichier.',
    'filled' => 'Le champ :attribute doit avoir une valeur.',
    'gt' => [
        'numeric' => ':attribute doit être supérieur à :value.',
        'file' => ':attribute doit être supérieur à :value kilo-octets.',
        'string' => ':attribute doit être supérieur à :value caractères.',
        'array' => ':attribute doit avoir plus de :value éléments.',
    ],
    'gte' => [
        'numeric' => ':attribute doit être supérieur ou égal à :value.',
        'file' => ':attribute doit être supérieur ou égal à :value kilo-octets.',
        'string' => ':attribute doit être supérieur ou égal à :value caractères.',
        'array' => ':attribute doit avoir :value éléments ou plus.',
    ],
    'image' => ':attribute doit être une image.',
    'in' => ':attribute sélectionné est invalide.',
    'in_array' => 'Le champ :attribute n\'existe pas dans :other.',
    'integer' => ':attribute doit être un entier.',
    'ip' => ':attribute doit être une adresse IP valide.',
    'ipv4' => ':attribute doit être une adresse IPv4 valide.',
    'ipv6' => ':attribute doit être une adresse IPv6 valide.',
    'json' => ':attribute doit être une chaîne JSON valide.',
    'lt' => [
        'numeric' => ':attribute doit être inférieur à :value.',
        'file' => ':attribute doit être inférieur à :value kilo-octets.',
        'string' => ':attribute doit être inférieur à :value caractères.',
        'array' => ':attribute doit avoir moins de :value éléments.',
    ],
    'lte' => [
        'numeric' => ':attribute doit être inférieur ou égal à :value.',
        'file' => ':attribute doit être inférieur ou égal à :value kilo-octets.',
        'string' => ':attribute doit être inférieur ou égal à :value caractères.',
        'array' => ':attribute ne doit pas avoir plus de :value éléments.',
    ],
    'mac_address' => ':attribute doit être une adresse MAC valide.',
    'max' => [
        'numeric' => ':attribute ne doit pas être supérieur à :max.',
        'file' => ':attribute ne doit pas être supérieur à :max kilo-octets.',
        'string' => ':attribute ne doit pas être supérieur à :max caractères.',
        'array' => ':attribute ne doit pas avoir plus de :max éléments.',
    ],
    'mimes' => ':attribute doit être un fichier de type : :values.',
    'mimetypes' => ':attribute doit être un fichier de type : :values.',
    'min' => [
        'numeric' => ':attribute doit être au moins :min.',
        'file' => ':attribute doit être au moins de :min kilo-octets.',
        'string' => ':attribute doit avoir au moins :min caractères.',
        'array' => ':attribute doit avoir au moins :min éléments.',
    ],
    'multiple_of' => ':attribute doit être un multiple de :value.',
    'not_in' => ':attribute sélectionné est invalide.',
    'not_regex' => 'Le format de :attribute est invalide.',
    'numeric' => ':attribute doit être un nombre.',
    'password' => 'Le mot de passe est incorrect.',
    'present' => 'Le champ :attribute doit être présent.',
    'prohibited' => 'Le champ :attribute est interdit.',
    'prohibited_if' => 'Le champ :attribute est interdit lorsque :other est :value.',
    'prohibited_unless' => 'Le champ :attribute est interdit sauf si :other est dans :values.',
    'prohibits' => 'Le champ :attribute interdit à :other d\'être présent.',
    'regex' => 'Le format de :attribute est invalide.',
    'required' => 'Le champ :attribute est requis.',
    'required_array_keys' => 'Le champ :attribute doit contenir des entrées pour :values.',
    'required_if' => 'Le champ :attribute est requis lorsque :other est :value.',
    'required_unless' => 'Le champ :attribute est requis sauf si :other est dans :values.',
    'required_with' => 'Le champ :attribute est requis lorsque :values est présent.',
    'required_with_all' => 'Le champ :attribute est requis lorsque :values sont présents.',
    'required_without' => 'Le champ :attribute est requis lorsque :values n\'est pas présent.',
    'required_without_all' => 'Le champ :attribute est requis lorsque aucun des :values n\'est présent.',
    'same' => ':attribute et :other doivent correspondre.',
    'size' => [
        'numeric' => ':attribute doit être :size.',
        'file' => ':attribute doit être de :size kilo-octets.',
        'string' => ':attribute doit être de :size caractères.',
        'array' => ':attribute doit contenir :size éléments.',
    ],
    'starts_with' => ':attribute doit commencer par l\'un des éléments suivants : :values.',
    'string' => ':attribute doit être une chaîne de caractères.',
    'timezone' => ':attribute doit être un fuseau horaire valide.',
    'unique' => ':attribute a déjà été pris.',
    'uploaded' => ':attribute n\'a pas pu être téléchargé.',
    'url' => ':attribute doit être une URL valide.',
    'uuid' => ':attribute doit être un UUID valide.',

    /*
    |--------------------------------------------------------------------------
    | Messages de validation personnalisés
    |--------------------------------------------------------------------------
    |
    | Ici, vous pouvez spécifier des messages de validation personnalisés pour les attributs en utilisant la
    | convention "attribut.rule" pour nommer les lignes. Cela nous permet de
    | spécifier rapidement une ligne de langue personnalisée spécifique à une règle d'attribut donnée.
    |
    */

    'custom' => [
        'email.required' => 'L\'adresse e-mail est requise.',
        'email.unique' => 'L\'email a déjà été utilisé.',

        'phone.unique' => 'Le numéro de téléphone a déjà été pris.',

        'password_confirmation.same' => 'Le mot de passe de confirmation ne correspond pas.',
        'password_confirmation.required' => 'Le champ de confirmation du mot de passe est requis.',
        'password.required' => 'Le champ de mot de passe est requis.',
        'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
        'password.max' => 'Le mot de passe ne doit pas dépasser 255 caractères.',
        'password.regex' => 'Le mot de passe doit contenir au moins une lettre majuscule, une lettre minuscule, un chiffre et un caractère spécial.',
        'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',

        'firstname.required' => 'Le prénom est requis.',
        'lastname.required' => 'Le nom de famille est requis.',
        'birthday.required' => 'La date de naissance est requise.',
        'title.required' => 'Le titre est requis.',
        'content.required' => 'Le contenu est requis.',
        'description.required' => 'La description est requise.',
        'date.required' => 'La date est requise.',

        'attribute-name' => [
            'rule-name' => 'message-personnalisé',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Attributs de validation personnalisés
    |--------------------------------------------------------------------------
    |
    | Les lignes de langue suivantes sont utilisées pour échanger notre espace réservé d'attribut
    | avec quelque chose de plus convivial pour le lecteur, tel que "Adresse e-mail" au lieu de "email".
    | Cela nous aide simplement à rendre notre message plus expressif.
    |
    */

    'attributes' => [
        'firstname' => 'Prénom',
        'lastname' => 'Nom de famille',
        'email' => 'Adresse e-mail',
        'password' => 'Mot de passe',
        'password_confirmation' => 'Confirmation du mot de passe',
        'phone' => 'Téléphone',
        'birthdate' => 'Date de naissance',
        'title' => 'Titre',
        'content' => 'Contenu',
        'description' => 'Description',
        'date' => 'Date',
    ],

];

<?php

public function unityjson(){

    //Consulta a la bbdd
    $rowset = $this->db->query("SELECT * FROM noticias WHERE activo=1 ORDER BY fecha DESC");

    //Asigno resultados a un array de instancias del modelo
    $noticias = array();
    while ($row = $rowset->fetch(\PDO::FETCH_OBJ)){
        array_push($noticias,new Noticia($row));
    }

    //Compongo el array con la info que necesita la API
    $array_noticias = array();
    foreach ($noticias as $row){
        $array_noticias[] = [
            'titulo' => $row->titulo,
            'entradilla' => $row->entradilla,
            'texto' => $row->texto,
            'autor' => $row->autor,
            'fecha' => date("d/m/Y", strtotime($row->fecha)),
            'enlace' => $_SESSION['home']."noticia/".$row->slug,
            'imagen' => $_SESSION['public']."img/".$row->imagen
        ];
    }

    //Muestro en formato JSON con opciones para tildes y caracteres de escape
    echo json_encode($array_noticias,
        JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

}

public function unitypost(){

    $usuario = filter_input(INPUT_POST, "usuario", FILTER_SANITIZE_SPECIAL_CHARS);
    $clave = filter_input(INPUT_POST, "clave", FILTER_SANITIZE_SPECIAL_CHARS);
    echo "POST: El usuario es $usuario y la clave es $clave";

}

public function unityget(){

    $usuario = filter_input(INPUT_GET, "usuario", FILTER_SANITIZE_SPECIAL_CHARS);
    $clave = filter_input(INPUT_GET, "clave", FILTER_SANITIZE_SPECIAL_CHARS);
    echo "GET: El usuario es $usuario y la clave es $clave";

}
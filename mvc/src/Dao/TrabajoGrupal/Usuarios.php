<?php

namespace Dao\TrabajoGrupal;


class Usuarios extends \Dao\Table{
    public static function readAllUsuarios($filter = ''){
        $sqlstr = "SELECT * from usuario where usercod like :filter;";
        $params = array('filter' => '%'.$filter.'%');
        return self::obtenerRegistros($sqlstr, $params);
    }
}
<?php

namespace Dao\Students;

use Dao\Table;

class Students extends Table
{
    public static function getStudents(
        string $partialName = "",
        int $edad = 0,
        string $orderBy = "",
        bool $orderDescending = false,
        int $page = 0,
        int $itemsPerPage = 10
    ) {
        $sqlstr = "SELECT id_estudiante, nombre, apellido, edad, especialidad FROM EstudianteCienciasComputacionales";
        $sqlstrCount = "SELECT COUNT(*) as count FROM EstudianteCienciasComputacionales";
        $conditions = [];
        $params = [];

        if ($partialName != "") {
            $conditions[] = "(nombre LIKE :partialName OR apellido LIKE :partialName)"; 
            $params["partialName"] = "%" . $partialName . "%";
        }
        if ($edad > 0) {
            $conditions[] = "edad = :edad";
            $params["edad"] = $edad;
        }

        if (count($conditions) > 0) {
            $sqlstr .= " WHERE " . implode(" AND ", $conditions);
            $sqlstrCount .= " WHERE " . implode(" AND ", $conditions);
        }

        if (!in_array($orderBy, ["id_estudiante", "nombre", "apellido", "edad", "especialidad", ""])) {
            throw new \Exception("Error Processing Request OrderBy has invalid value");
        }
        if ($orderBy != "") {
            $sqlstr .= " ORDER BY " . $orderBy;
            if ($orderDescending) {
                $sqlstr .= " DESC";
            }
        }

        $numeroDeRegistros = self::obtenerUnRegistro($sqlstrCount, $params)["count"];
        $pagesCount = ceil($numeroDeRegistros / $itemsPerPage);
        if ($page > $pagesCount - 1) {
            $page = $pagesCount - 1;
        }
        $sqlstr .= " LIMIT " . $page * $itemsPerPage . ", " . $itemsPerPage;

        $registros = self::obtenerRegistros($sqlstr, $params);
        return ["students" => $registros, "total" => $numeroDeRegistros, "page" => $page, "itemsPerPage" => $itemsPerPage];
    }

    public static function getStudentById(int $studentId)
    {
        $sqlstr = "SELECT id_estudiante, nombre, apellido, edad, especialidad FROM EstudianteCienciasComputacionales WHERE id_estudiante = :id_estudiante";
        $params = ["id_estudiante" => $studentId];
        return self::obtenerUnRegistro($sqlstr, $params);
    }

    public static function insertStudent(
        string $nombre,
        string $apellido,
        int $edad,
        string $especialidad
    ) {
        $sqlstr = "INSERT INTO EstudianteCienciasComputacionales (nombre, apellido, edad, especialidad) VALUES (:nombre, :apellido, :edad, :especialidad)";
        $params = [
            "nombre" => $nombre,
            "apellido" => $apellido,
            "edad" => $edad,
            "especialidad" => $especialidad
        ];
        return self::executeNonQuery($sqlstr, $params);
    }

    public static function updateStudent(
        int $id_estudiante,
        string $nombre,
        string $apellido,
        int $edad,
        string $especialidad
    ) {
        $sqlstr = "UPDATE EstudianteCienciasComputacionales SET nombre = :nombre, apellido = :apellido, edad = :edad, especialidad = :especialidad WHERE id_estudiante = :id_estudiante";
        $params = [
            "id_estudiante" => $id_estudiante,
            "nombre" => $nombre,
            "apellido" => $apellido,
            "edad" => $edad,
            "especialidad" => $especialidad
        ];
        return self::executeNonQuery($sqlstr, $params);
    }

    public static function deleteStudent(int $id_estudiante)
    {
        $sqlstr = "DELETE FROM EstudianteCienciasComputacionales WHERE id_estudiante = :id_estudiante";
        $params = ["id_estudiante" => $id_estudiante];
        return self::executeNonQuery($sqlstr, $params);
    }
}


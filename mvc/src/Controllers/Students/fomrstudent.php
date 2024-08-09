<?php

namespace Controllers\Students;

use Controllers\PublicController;
use Dao\Students\Students as DaoStudents;
use Views\Renderer;

class FormStudent extends PublicController
{
    private $viewData = array();
    private $mode = 'INS';
    private $studentId = 0;
    private $student = array();

    public function run():void
    {
        $this->init();
        if ($this->isPostBack()) {
            $this->handlePost();
        }
        $this->processView();
        Renderer::render('students/formstudent', $this->viewData);
    }

    private function init()
    {
        if (isset($_GET["mode"])) {
            $this->mode = $_GET["mode"];
        }
        if (isset($_GET["id"])) {
            $this->studentId = intval($_GET["id"]);
        }
        if ($this->mode == 'UPD' && $this->studentId == 0) {
            $this->mode = 'INS';
        }
        if ($this->mode == 'UPD') {
            $this->student = DaoStudents::getStudentById($this->studentId);
            if (!$this->student) {
                $this->mode = 'INS';
            }
        }
        $this->viewData["mode"] = $this->mode;
        $this->viewData["student"] = $this->student;
    }

    private function handlePost()
    {
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $edad = intval($_POST["edad"]);
        $especialidad = $_POST["especialidad"];
        if ($this->mode == 'INS') {
            $result = DaoStudents::insertStudent($nombre, $apellido, $edad, $especialidad);
            if ($result) {
                \Utilities\Site::redirectToWithMsg('index.php?page=Students_Students', 'Estudiante registrado exitosamente!');
            }
        } else {
            $result = DaoStudents::updateStudent($this->studentId, $nombre, $apellido, $edad, $especialidad);
            if ($result) {
                \Utilities\Site::redirectToWithMsg('index.php?page=Students_Students', 'Estudiante actualizado exitosamente!');
            }
        }
    }

    private function processView()
    {
        if ($this->mode == 'INS') {
            $this->viewData["modedsc"] = "Nuevo Estudiante";
        } else {
            $this->viewData["modedsc"] = "Editando " . $this->student["nombre"] . " " . $this->student["apellido"];
        }
    }
}

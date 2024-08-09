<?php

namespace Controllers\Students;

use Controllers\PublicController;
use Utilities\Context;
use Utilities\Paging;
use Dao\Students\Students as DaoStudents;
use Views\Renderer;

class Students extends PublicController
{
    private $partialName = "";
    private $edad = 0; 
    private $orderBy = "";
    private $orderDescending = false;
    private $pageNumber = 1;
    private $itemsPerPage = 10;
    private $viewData = [];
    private $students = [];
    private $studentsCount = 0;
    private $pages = 0;

    public function run(): void
    {
        $this->getParamsFromContext();
        $this->getParams();
        $tmpStudents = DaoStudents::getStudents(
            $this->partialName,
            $this->edad,
            $this->orderBy,
            $this->orderDescending,
            $this->pageNumber - 1,
            $this->itemsPerPage
        );
        $this->students = $tmpStudents["students"];
        $this->studentsCount = $tmpStudents["total"];
        $this->pages = $this->studentsCount > 0 ? ceil($this->studentsCount / $this->itemsPerPage) : 1;
        if ($this->pageNumber > $this->pages) {
            $this->pageNumber = $this->pages;
        }
        $this->setParamsToContext();
        $this->setParamsToDataView();
        Renderer::render("students/students", $this->viewData); // Vista para estudiantes
    }

    private function getParams(): void
    {
        $this->partialName = isset($_GET["partialName"]) ? $_GET["partialName"] : $this->partialName;
        $this->edad = isset($_GET["edad"]) ? intval($_GET["edad"]) : $this->edad;
        $this->orderBy = isset($_GET["orderBy"]) && in_array($_GET["orderBy"], ["id_estudiante", "nombre", "apellido", "edad", "especialidad", "clear"]) ? $_GET["orderBy"] : $this->orderBy;
        if ($this->orderBy === "clear") {
            $this->orderBy = "";
        }
        $this->orderDescending = isset($_GET["orderDescending"]) ? boolval($_GET["orderDescending"]) : $this->orderDescending;
        $this->pageNumber = isset($_GET["pageNum"]) ? intval($_GET["pageNum"]) : $this->pageNumber;
        $this->itemsPerPage = isset($_GET["itemsPerPage"]) ? intval($_GET["itemsPerPage"]) : $this->itemsPerPage;
    }

    private function getParamsFromContext(): void
    {
        $this->partialName = Context::getContextByKey("students_partialName");
        $this->edad = intval(Context::getContextByKey("students_edad"));
        $this->orderBy = Context::getContextByKey("students_orderBy");
        $this->orderDescending = boolval(Context::getContextByKey("students_orderDescending"));
        $this->pageNumber = intval(Context::getContextByKey("students_page"));
        $this->itemsPerPage = intval(Context::getContextByKey("students_itemsPerPage"));
        if ($this->pageNumber < 1) $this->pageNumber = 1;
        if ($this->itemsPerPage < 1) $this->itemsPerPage = 10;
    }

    private function setParamsToContext(): void
    {
        Context::setContext("students_partialName", $this->partialName, true);
        Context::setContext("students_edad", $this->edad, true);
        Context::setContext("students_orderBy", $this->orderBy, true);
        Context::setContext("students_orderDescending", $this->orderDescending, true);
        Context::setContext("students_page", $this->pageNumber, true);
        Context::setContext("students_itemsPerPage", $this->itemsPerPage, true);
    }

    private function setParamsToDataView(): void
    {
        $this->viewData["partialName"] = $this->partialName;
        $this->viewData["edad"] = $this->edad;
        $this->viewData["orderBy"] = $this->orderBy;
        $this->viewData["orderDescending"] = $this->orderDescending;
        $this->viewData["pageNum"] = $this->pageNumber;
        $this->viewData["itemsPerPage"] = $this->itemsPerPage;
        $this->viewData["studentsCount"] = $this->studentsCount;
        $this->viewData["pages"] = $this->pages;
        $this->viewData["students"] = $this->students;

        if ($this->orderBy !== "") {
            $orderByKey = "Order" . ucfirst($this->orderBy);
            $orderByKeyNoOrder = "OrderBy" . ucfirst($this->orderBy);
            $this->viewData[$orderByKeyNoOrder] = true;
            if ($this->orderDescending) {
                $orderByKey .= "Desc";
            }
            $this->viewData[$orderByKey] = true;
        }


        $pagination = Paging::getPagination(
            $this->studentsCount,
            $this->itemsPerPage,
            $this->pageNumber,
            "index.php?page=Students_Students",
            "Students_Students"
        );
        $this->viewData["pagination"] = $pagination;
    }

}

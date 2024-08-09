<?php

namespace Controllers\Invoices;

use Controllers\PublicController;
use Views\Renderer;
use Dao\Invoices\Invoices as InvoicesDao;
use Utilities\Site;
use Utilities\Validators;

class Invoice extends PublicController
{
    private $viewData = [];
    private $mode = "DSP";
    private $modeDescriptions = [
        "DSP" => "Detalle de Factura %s",
        "INS" => "Nueva Factura",
        "UPD" => "Editar Factura %s",
        "DEL" => "Eliminar Factura %s"
    ];
    private $readonly = "";
    private $showCommitBtn = true;
    private $invoice = [
        "InvoiceID" => 0,
        "InvoiceDate" => "",
        "OrderID" => 0,
        "Amount" => 0,
        "Status" => ""
    ];

    public function run(): void
    {
        try {
            $this->getData();
            if ($this->isPostBack()) {
                if ($this->validateData()) {
                    $this->handlePostAction();
                }
            }
            $this->setViewData();
            Renderer::render("invoices/invoice", $this->viewData);
        } catch (\Exception $ex) {
            Site::redirectToWithMsg(
                "index.php?page=Invoices_Invoices", // Ajusta la página de redirección
                $ex->getMessage()
            );
        }
    }

    private function getData()
    {
        $this->mode = $_GET["mode"] ?? "NOF";
        if (isset($this->modeDescriptions[$this->mode])) {
            $this->readonly = $this->mode === "DEL" ? "readonly" : "";
            $this->showCommitBtn = $this->mode !== "DSP";
            if ($this->mode !== "INS") {
                $this->invoice = InvoicesDao::getInvoiceById(intval($_GET["InvoiceID"])); 
                if (!$this->invoice) {
                    throw new \Exception("No se encontró la Factura", 1);
                }
            }
        } else {
            throw new \Exception("Formulario cargado en modalidad invalida", 1);
        }
    }

    private function validateData()
    {
        $errors = [];

        $this->invoice["InvoiceID"] = intval($_POST["InvoiceID"] ?? "");
        $this->invoice["InvoiceDate"] = strval($_POST["InvoiceDate"] ?? "");
        $this->invoice["OrderID"] = intval($_POST["OrderID"] ?? "");
        $this->invoice["Amount"] = floatval($_POST["Amount"] ?? "");
        $this->invoice["Status"] = strval($_POST["Status"] ?? "");

        if (Validators::IsEmpty($this->invoice["InvoiceDate"])) {
            $errors["InvoiceDate_error"] = "La fecha de la factura es requerida";
        }

        if (count($errors) > 0) {
            foreach ($errors as $key => $value) {
                $this->invoice[$key] = $value;
            }
            return false;
        }
        return true;
    }

    private function handlePostAction()
    {
        switch ($this->mode) {
            case "INS":
                $this->handleInsert();
                break;
            case "UPD":
                $this->handleUpdate();
                break;
            case "DEL":
                $this->handleDelete();
                break;
            default:
                throw new \Exception("Modo invalido", 1);
                break;
        }
    }


    private function setViewData(): void
    {
        $this->viewData["mode"] = $this->mode;
        $this->viewData["FormTitle"] = sprintf(
            $this->modeDescriptions[$this->mode],
            $this->invoice["InvoiceID"]
        );
        $this->viewData["showCommitBtn"] = $this->showCommitBtn;
        $this->viewData["readonly"] = $this->readonly;


        $this->viewData["invoice"] = $this->invoice;
    }
}
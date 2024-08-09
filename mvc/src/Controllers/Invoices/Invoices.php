<?php

namespace Controllers\Invoices;

use Controllers\PublicController;
use Utilities\Context;
use Utilities\Paging;
use Dao\Invoices\Invoices as DaoInvoices;
use Views\Renderer;

class Invoices extends PublicController
{
    private $partialOrderID = "";
    private $status = "";
    private $orderBy = "";
    private $orderDescending = false;
    private $pageNumber = 1;
    private $itemsPerPage = 10;
    private $viewData = [];
    private $invoices = [];
    private $invoicesCount = 0;
    private $pages = 0;

    public function run(): void
    {
        $this->getParamsFromContext();
        $this->getParams();

        $tmpInvoices = DaoInvoices::getInvoices(
            $this->partialOrderID,
            $this->status,
            $this->orderBy,
            $this->orderDescending,
            $this->pageNumber - 1, 
            $this->itemsPerPage
        );

        $this->invoices = $tmpInvoices["invoices"];
        $this->invoicesCount = $tmpInvoices["total"];
        $this->pages = $this->invoicesCount > 0 ? ceil($this->invoicesCount / $this->itemsPerPage) : 1;
        if ($this->pageNumber > $this->pages) {
            $this->pageNumber = $this->pages;
        }

        $this->setParamsToContext();
        $this->setParamsToDataView();
        Renderer::render("invoices/invoices", $this->viewData); 
    }

    private function getParams(): void
    {
        $this->partialOrderID = isset($_GET["partialOrderID"]) ? $_GET["partialOrderID"] : $this->partialOrderID;
        $this->status = isset($_GET["status"]) ? $_GET["status"] : $this->status;
        $this->orderBy = isset($_GET["orderBy"]) && in_array($_GET["orderBy"], ["InvoiceID", "InvoiceDate", "OrderID", "Amount", "Status", "clear"]) 
                        ? $_GET["orderBy"] 
                        : $this->orderBy;

        if ($this->orderBy === "clear") {
            $this->orderBy = "";
        }

        $this->orderDescending = isset($_GET["orderDescending"]) ? boolval($_GET["orderDescending"]) : $this->orderDescending;
        $this->pageNumber = isset($_GET["pageNum"]) ? intval($_GET["pageNum"]) : $this->pageNumber;
        $this->itemsPerPage = isset($_GET["itemsPerPage"]) ? intval($_GET["itemsPerPage"]) : $this->itemsPerPage;
    }

    private function getParamsFromContext(): void
    {
        $this->partialOrderID = Context::getContextByKey("invoices_partialOrderID");
        $this->status = Context::getContextByKey("invoices_status");
        $this->orderBy = Context::getContextByKey("invoices_orderBy");
        $this->orderDescending = boolval(Context::getContextByKey("invoices_orderDescending"));
        $this->pageNumber = intval(Context::getContextByKey("invoices_page"));
        $this->itemsPerPage = intval(Context::getContextByKey("invoices_itemsPerPage"));

        if ($this->pageNumber < 1) $this->pageNumber = 1;
        if ($this->itemsPerPage < 1) $this->itemsPerPage = 10;
    }

    private function setParamsToContext(): void
    {
        Context::setContext("invoices_partialOrderID", $this->partialOrderID, true);
        Context::setContext("invoices_status", $this->status, true);
        Context::setContext("invoices_orderBy", $this->orderBy, true);
        Context::setContext("invoices_orderDescending", $this->orderDescending, true);
        Context::setContext("invoices_page", $this->pageNumber, true);
        Context::setContext("invoices_itemsPerPage", $this->itemsPerPage, true);
    }

    private function setParamsToDataView(): void
    {
        $this->viewData["partialOrderID"] = $this->partialOrderID;
        $this->viewData["status"] = $this->status;
        $this->viewData["orderBy"] = $this->orderBy;
        $this->viewData["orderDescending"] = $this->orderDescending;
        $this->viewData["pageNum"] = $this->pageNumber;
        $this->viewData["itemsPerPage"] = $this->itemsPerPage;
        $this->viewData["invoicesCount"] = $this->invoicesCount;
        $this->viewData["pages"] = $this->pages;
        $this->viewData["invoices"] = $this->invoices;

        if ($this->orderBy !== "") {
            $orderByKey = "Order" . ucfirst($this->orderBy);
            $orderByKeyNoOrder = "OrderBy" . ucfirst($this->orderBy);
            $this->viewData[$orderByKeyNoOrder] = true;
            if ($this->orderDescending) {
                $orderByKey .= "Desc";
            }
            $this->viewData[$orderByKey] = true;
        }

        $statusKey = "status_" . ($this->status === "" ? "ALL" : $this->status);
        $this->viewData[$statusKey] = "selected";

        $pagination = Paging::getPagination(
            $this->invoicesCount,
            $this->itemsPerPage,
            $this->pageNumber,
            "index.php?page=Invoices_Invoices",
            "Invoices_Invoices"
        );
        $this->viewData["pagination"] = $pagination;
    }
}

?>
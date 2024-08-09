<?php
namespace Dao\Invoices;
use Dao\Table;

class Invoices extends Table {
    

    public static function getInvoices(
        string $partialOrderID = "", 
        string $status = "",         
        string $orderBy = "",        
        bool $orderDescending = false, 
        int $page = 0,               
        int $itemsPerPage = 10        
    ) {
        $sqlstr = "SELECT 
                        InvoiceID, 
                        InvoiceDate, 
                        OrderID, 
                        Amount, 
                        Status FROM Invoices";
        $sqlstrCount = "SELECT COUNT(*) as count FROM Invoices";
        $conditions = [];
        $params = [];

        if ($partialOrderID != "") {
            $conditions[] = "OrderID LIKE :partialOrderID";
            $params["partialOrderID"] = "%" . $partialOrderID . "%";
        }

        if ($status != "") {
            $conditions[] = "Status = :status";
            $params["status"] = $status;
        }

        if (count($conditions) > 0) {
            $sqlstr .= " WHERE " . implode(" AND ", $conditions);
            $sqlstrCount .= " WHERE " . implode(" AND ", $conditions);
        }

        if (!in_array($orderBy, ["InvoiceID", "InvoiceDate", "OrderID", "Amount", "Status", ""])) {
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
        return ["invoices" => $registros, "total" => $numeroDeRegistros, "page" => $page, "itemsPerPage" => $itemsPerPage];
    }

    public static function getInvoiceById(int $invoiceId)
    {
        $sqlstr = "SELECT InvoiceID, InvoiceDate, OrderID, Amount, Status FROM Invoices WHERE InvoiceID = :invoiceId";
        $params = ["invoiceId" => $invoiceId];
        return self::obtenerUnRegistro($sqlstr, $params);
    }

    public static function insertInvoice(
        string $invoiceDate,
        int $orderId,
        float $amount,
        string $status
    ) {
        $sqlstr = "INSERT INTO Invoices (InvoiceDate, OrderID, Amount, Status) 
                   VALUES (:invoiceDate, :orderId, :amount, :status)";
        $params = [
            "invoiceDate" => $invoiceDate,
            "orderId" => $orderId,
            "amount" => $amount,
            "status" => $status
        ];
        return self::executeNonQuery($sqlstr, $params);
    }

    public static function updateInvoice(
        int $invoiceId,
        string $invoiceDate,
        int $orderId,
        float $amount,
        string $status
    ) {
        $sqlstr = "UPDATE Invoices 
                   SET InvoiceDate = :invoiceDate, OrderID = :orderId, Amount = :amount, Status = :status 
                   WHERE InvoiceID = :invoiceId";
        $params = [
            "invoiceId" => $invoiceId,
            "invoiceDate" => $invoiceDate,
            "orderId" => $orderId,
            "amount" => $amount,
            "status" => $status
        ];
        return self::executeNonQuery($sqlstr, $params);
    }

    public static function deleteInvoice(int $invoiceId)
    {
        $sqlstr = "DELETE FROM Invoices WHERE InvoiceID = :invoiceId";
        $params = ["invoiceId" => $invoiceId];
        return self::executeNonQuery($sqlstr, $params);
    }
}

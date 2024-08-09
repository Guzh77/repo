<h1>Trabajar con Facturas</h1>

<section class="grid">
    <div class="row">
        <form class="col-12 col-m-8" action="index.php" method="get">
            <div class="flex align-center">
                <div class="col-8 row">
                    <input type="hidden" name="page" value="Invoices_Invoices">
                    <label class="col-3" for="partialOrderID">ID Pedido</label>
                    <input class="col-9" type="text" name="partialOrderID" id="partialOrderID" value="{{partialOrderID}}" />
                    <label class="col-3" for="status">Estado</label>
                    <select class="col-9" name="status" id="status">
                        <option value="" {{status_ALL}}>Todos</option> 
                        <option value="Pagada" {{status_Pagada}}>Pagada</option>
                        <option value="Pendiente" {{status_Pendiente}}>Pendiente</option>
                        <option value="Cancelada" {{status_Cancelada}}>Cancelada</option>
                    </select>
                </div>
                <div class="col-4 align-end">
                    <button type="submit">Filtrar</button>
                </div>
            </div>
        </form>
    </div>
</section>

<section class="WWList">
    <table>
        <thead>
            <tr>
                <th>
                    {{ifnot OrderByInvoiceID}}
                    <a href="index.php?page=Invoices_Invoices&orderBy=InvoiceID&orderDescending=0">ID <i class="fas fa-sort"></i></a>
                    {{endifnot OrderByInvoiceID}}
                    {{if OrderInvoiceIDDesc}}
                    <a href="index.php?page=Invoices_Invoices&orderBy=clear&orderDescending=0">ID <i class="fas fa-sort-down"></i></a>
                    {{endif OrderInvoiceIDDesc}}
                    {{if OrderInvoiceID}}
                    <a href="index.php?page=Invoices_Invoices&orderBy=InvoiceID&orderDescending=1">ID <i class="fas fa-sort-up"></i></a>
                    {{endif OrderInvoiceID}}
                </th>
                <th>
                    {{ifnot OrderByInvoiceDate}}
                    <a href="index.php?page=Invoices_Invoices&orderBy=InvoiceDate&orderDescending=0">Fecha <i class="fas fa-sort"></i></a>
                    {{endifnot OrderByInvoiceDate}}
                    {{if OrderInvoiceDateDesc}}
                    <a href="index.php?page=Invoices_Invoices&orderBy=clear&orderDescending=0">Fecha <i class="fas fa-sort-down"></i></a>
                    {{endif OrderInvoiceDateDesc}}
                    {{if OrderInvoiceDate}}
                    <a href="index.php?page=Invoices_Invoices&orderBy=InvoiceDate&orderDescending=1">Fecha <i class="fas fa-sort-up"></i></a>
                    {{endif OrderInvoiceDate}}
                </th>
                <th>
                    {{ifnot OrderByOrderID}}
                    <a href="index.php?page=Invoices_Invoices&orderBy=OrderID&orderDescending=0">Pedido <i class="fas fa-sort"></i></a>
                    {{endifnot OrderByOrderID}}
                    {{if OrderOrderIDDesc}}
                    <a href="index.php?page=Invoices_Invoices&orderBy=clear&orderDescending=0">Pedido <i class="fas fa-sort-down"></i></a>
                    {{endif OrderOrderIDDesc}}
                    {{if OrderOrderID}}
                    <a href="index.php?page=Invoices_Invoices&orderBy=OrderID&orderDescending=1">Pedido <i class="fas fa-sort-up"></i></a>
                    {{endif OrderOrderID}}
                </th>
                <th>
                    {{ifnot OrderByAmount}}
                    <a href="index.php?page=Invoices_Invoices&orderBy=Amount&orderDescending=0">Monto <i class="fas fa-sort"></i></a>
                    {{endifnot OrderByAmount}}
                    {{if OrderAmountDesc}}
                    <a href="index.php?page=Invoices_Invoices&orderBy=clear&orderDescending=0">Monto <i class="fas fa-sort-down"></i></a>
                    {{endif OrderAmountDesc}}
                    {{if OrderAmount}}
                    <a href="index.php?page=Invoices_Invoices&orderBy=Amount&orderDescending=1">Monto <i class="fas fa-sort-up"></i></a>
                    {{endif OrderAmount}}
                </th>
                <th>
                    {{ifnot OrderByStatus}}
                    <a href="index.php?page=Invoices_Invoices&orderBy=Status&orderDescending=0">Estado <i class="fas fa-sort"></i></a>
                    {{endifnot OrderByStatus}}
                    {{if OrderStatusDesc}}
                    <a href="index.php?page=Invoices_Invoices&orderBy=clear&orderDescending=0">Estado <i class="fas fa-sort-down"></i></a>
                    {{endif OrderStatusDesc}}
                    {{if OrderStatus}}
                    <a href="index.php?page=Invoices_Invoices&orderBy=Status&orderDescending=1">Estado <i class="fas fa-sort-up"></i></a>
                    {{endif OrderStatus}}
                </th>
                <th><a href="index.php?page=Invoices_Invoice&mode=INS">Nuevo</a></th> 
            </tr>
        </thead>
        <tbody>
            {{foreach invoices}}
            <tr>
                <td>{{InvoiceID}}</td>
                <td>{{InvoiceDate}}</td>
                <td>{{OrderID}}</td>
                <td class="right">{{Amount}}</td> 
                <td class="center">{{Status}}</td> 
                <td class="center">
                    <a href="index.php?page=Invoices_Invoice&mode=UPD&InvoiceID={{InvoiceID}}">Editar</a>
                    &nbsp;
                    <a href="index.php?page=Invoices_Invoice&mode=DEL&InvoiceID={{InvoiceID}}">Eliminar</a>
                </td>
            </tr>
            {{endfor invoices}}
        </tbody>
    </table>
    {{pagination}}
</section>


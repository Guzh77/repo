<section class="container-m row px-4 py-4">
    <h1>{{FormTitle}}</h1>
</section>
<section class="container-m row px-4 py-4">
    {{with invoice}}
    <form action="index.php?page=Invoices_Invoice&mode={{~mode}}&InvoiceID={{InvoiceID}}" method="POST" class="col-12 col-m-8 offset-m-2">
        <div class="row my-2 align-center">
            <label class="col-12 col-m-3" for="InvoiceIDD">Código</label>
            <input class="col-12 col-m-9" readonly disabled type="text" name="InvoiceIDD" id="InvoiceIDD" placehoder="Código" value="{{InvoiceID}}" />
            <input type="hidden" name="mode" value="{{~mode}}" />
            <input type="hidden" name="InvoiceID" value="{{InvoiceID}}" />
        </div>
        <div class="row my-2 align-center">
            <label class="col-12 col-m-3" for="InvoiceDate">Fecha</label>
            <input class="col-12 col-m-9" {{~readonly}} type="date" name="InvoiceDate" id="InvoiceDate" placehoder="Fecha de la Factura" value="{{InvoiceDate}}" />
            {{if InvoiceDate_error}}
            <div class="col-12 col-m-9 offset-m-3 error">
                {{InvoiceDate_error}}
            </div>
            {{endif InvoiceDate_error}}
        </div>
        <div class="row my-2 align-center">
            <label class="col-12 col-m-3" for="OrderID">Pedido</label>
            <input class="col-12 col-m-9" {{~readonly}} type="number" name="OrderID" id="OrderID" placehoder="ID del Pedido" value="{{OrderID}}" />
            {{if OrderID_error}} 
            <div class="col-12 col-m-9 offset-m-3 error">
                {{OrderID_error}}
            </div>
            {{endif OrderID_error}}
        </div>
        <div class="row my-2 align-center">
            <label class="col-12 col-m-3" for="Amount">Monto</label>
            <input class="col-12 col-m-9" {{~readonly}} type="number" name="Amount" id="Amount" placehoder="Monto de la Factura" value="{{Amount}}" />
            {{if Amount_error}}
            <div class="col-12 col-m-9 offset-m-3 error">
                {{Amount_error}}
            </div>
            {{endif Amount_error}}
        </div>
        <div class="row my-2 align-center">
            <label class="col-12 col-m-3" for="Status">Estado</label>
            <input class="col-12 col-m-9" {{~readonly}} type="text" name="Status" id="Status" placehoder="Estado de la Factura" value="{{Status}}" />
            {{if Status_error}}
            <div class="col-12 col-m-9 offset-m-3 error">
                {{Status_error}}
            </div>
            {{endif Status_error}}
        </div>
        {{endwith invoice}}
        <div class="row my-4 align-center flex-end">
            {{if showCommitBtn}}
            <button class="primary col-12 col-m-2" type="submit" name="btnConfirmar">Confirmar</button>
            &nbsp;
            {{endif showCommitBtn}}
            <button class="col-12 col-m-2"type="button" id="btnCancelar">
                {{if showCommitBtn}}
                Cancelar
                {{endif showCommitBtn}}
                {{ifnot showCommitBtn}}
                Regresar
                {{endifnot showCommitBtn}}
            </button>
        </div>
    </form>
</section>

<

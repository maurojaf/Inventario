<?php
require_once 'php_action/db_connect.php';
require_once 'includes/header.php';

if($_GET['o'] == 'add') {
// add order
	echo "<div class='div-request div-hide'>add</div>";
} else if($_GET['o'] == 'manord') {
	echo "<div class='div-request div-hide'>manord</div>";
} else if($_GET['o'] == 'editOrd') {
	echo "<div class='div-request div-hide'>editOrd</div>";
} // /else manage order


?>

<ol class="breadcrumb">
  <li><a href="dashboard.php">Home</a></li>
  <li>Ventas</li>
  <li class="active">
  	<?php if($_GET['o'] == 'add') { ?>
  		Vender
		<?php } else if($_GET['o'] == 'manord') { ?>
			Administrar ventas
		<?php } // /else manage order ?>
  </li>
</ol>


<h4>
	<i class='glyphicon glyphicon-circle-arrow-right'></i>
	<?php if($_GET['o'] == 'add') {
		echo "Vender";
	} else if($_GET['o'] == 'manord') {
		echo "Administrar Ventas";
	} else if($_GET['o'] == 'editOrd') {
		echo "Editar Venta";
	}
	?>
</h4>



<div class="panel panel-default">
	<div class="panel-heading">

		<?php if($_GET['o'] == 'add') { ?>
  		<i class="glyphicon glyphicon-plus-sign"></i>	Vender
		<?php } else if($_GET['o'] == 'manord') { ?>
			<i class="glyphicon glyphicon-edit"></i> Administrar Ventas
		<?php } else if($_GET['o'] == 'editOrd') { ?>
			<i class="glyphicon glyphicon-edit"></i> Editar Venta
		<?php } ?>

	</div> <!--/panel-->
	<div class="panel-body">

		<?php if($_GET['o'] == 'add') {
			// add order
			?>

			<div class="success-messages"></div> <!--/success-messages-->

  		<form class="form-horizontal" method="POST" action="php_action/createOrder.php" id="createOrderForm" >

				<input type="hidden" class="form-control" id="userSeller" name="userSeller" value="<?php echo $_SESSION['userId'] ?>" />

			  <div class="form-group">
			    <label for="orderDate" class="col-sm-2 control-label">Fecha</label>
			    <div class="col-sm-2">
			      <input type="text" class="form-control" id="orderDate" value="<?php echo date('d/m/Y'); ?>" disabled="disabled" name="orderDate" autocomplete="off" />
			    </div>
			  </div> 
			  <!-- <div class="form-group">
			    <label for="clientName" class="col-sm-2 control-label">Nombre cliente</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" id="clientName" name="clientName" placeholder="Nombre del Cliente" autocomplete="off" />
			    </div>
			  </div> 
			  <div class="form-group">
			    <label for="clientContact" class="col-sm-2 control-label">Numero de Contacto</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" id="clientContact" name="clientContact" placeholder="Numero de Contacto" autocomplete="off" />
			    </div>
			  </div>  -->


<hr style="color: #0056b2;" /> <!--Separador-->

<div class="page-header">
  <h1><small>Ingreso de Productos</small></h1>


				<div class="form-group">
					<label class="col-sm-2 control-label">Codigo de Barras</label>
					<div class="col-xs-3">
						<input type="text" class="form-control" id="barCode" placeholder="Ingresar Codigo">
					</div>

					<label class="col-sm-2 control-label">Nombre del Producto</label>
					<div class="col-xs-3">
						<input type="text" class="form-control" id="productName" placeholder="Buscar por Nombre">
					</div>

				</div>


			  <table class="table" id="productTable">
			  	<thead>
			  		<tr>
						  <th style="width:12%;">Codigo de Barra</th>
			  			<th style="width:38%;">Nombre Producto</th>
			  			<th style="width:10%;">Precio Unitario</th>
			  			<th style="width:15%;">Cantidad</th>
			  			<th style="width:15%;">Total</th>
			  			<th style="width:10%;"></th>
			  		</tr>
			  	</thead>

			  	<tbody>


			  	</tbody>
			  </table>

				</div>

			  <div class="col-md-6">

					

					<?php

						$profileId = $_SESSION['profile'];
						$sql = "SELECT allow_discount_sale FROM profile WHERE profile_id = $profileId;";
						$result = $connect->query($sql);
						$allowDiscount = $result->fetch_array();

						if ($allowDiscount['allow_discount_sale']){
							//echo "<script>console.log( 'Debug Objects: " . "SI" . "' );</script>";
					?>

					<!-- Solo para los perfiles que tienen permitido realizar descsuentos -->
					<div class="form-group">
				    <label for="subTotal" class="col-sm-3 control-label">Monto</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="subTotal" name="subTotal" disabled="true" value="0" />
				      <input type="hidden" class="form-control" id="subTotalValue" name="subTotalValue"  value="0" />
				    </div>
				  </div> <!--/form-group-->

					<div class="form-group">
						<label for="discount" class="col-sm-3 control-label">Descuento</label>
						<div class="col-sm-2">
							<input type="text" maxlength="3" value="0" class="form-control" id="discount" name="discount" onkeyup="discountFunc()" onchange="discountFunc()" autocomplete="off" />
						</div>
						<label class="col-sm-0 control-label">%</label>
					</div> <!--/form-group	-->

					
					<?php


						} else {
							//echo "<script>console.log( 'Debug Objects: " . "NO" . "' );</script>";
						}

					?>
					
					<div class="form-group">
						<label for="grandTotal" class="col-sm-3 control-label">Monto Final</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="grandTotal" name="grandTotal" disabled="true" value="0" />
							<input type="hidden" class="form-control" id="grandTotalValue" name="grandTotalValue" />
						</div>
					</div> <!--/form-group-->

			  </div> <!--/col-md-6-->

			  <div class="col-md-6">
			  	<div class="form-group">
				    <label for="paid" class="col-sm-3 control-label">Monto a Pagar</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="paid" name="paid" autocomplete="off" onkeyup="calcularVuelto()" value="0" />
				    </div>
				  </div> <!--/form-group-->
				  <div class="form-group">
				    <label for="due" class="col-sm-3 control-label">Vuelto</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="due" name="due" disabled="true" value="0" />
				      <input type="hidden" class="form-control" id="dueValue" name="dueValue" />
				    </div>
				  </div> <!--/form-group-->
				  <div class="form-group">
				    <label for="clientContact" class="col-sm-3 control-label">Estado del Pago</label>
				    <div class="col-sm-9">
				      <select class="form-control" disabled name="paymentStatus" id="paymentStatus">
				      	<option value="">~~SELECT~~</option>
				      	<option value="1">Pago Total</option>
				      	<option value="2">Pago por Adelantado</option>
				      	<option value="3">No pagado</option>
				      </select>
							<input type="hidden" name="paymentStatusValue" id="paymentStatusValue" />
				    </div>
				  </div> <!--/form-group-->
			  </div> <!--/col-md-6-->


			  <div class="form-group submitButtonFooter">
			    <div class="col-sm-offset-2 col-sm-10">
			    <!--<button type="button" class="btn btn-default" onclick="addRow()" id="addRowBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-plus-sign"></i> Agregar Producto </button>-->

			      <button type="submit" id="createOrderBtn" disabled data-loading-text="Loading..." class="btn btn-success"><i class="glyphicon glyphicon-ok-sign"></i> Finalizar Pago</button>

			      <button type="reset" class="btn btn-default" onclick="resetOrderForm()"><i class="glyphicon glyphicon-erase"></i> Limpiar</button>
			    </div>
			  </div>
			</form>
		<?php } else if($_GET['o'] == 'manord') {
			// manage order
			?>

			<div id="success-messages"></div>

			<table class="table" id="manageOrderTable">
				<thead>
					<tr>
						<th>#</th>
						<th>Fecha de Venta</th>
						<th>Monto</th>
						<th>Cantidad Vendida</th>
						<th>Nombre Vendedor</th>
						<th>Opciones</th>
					</tr>
				</thead>
			</table>

		<?php
		// /else manage order
		} else if($_GET['o'] == 'editOrd') {
			// get order
			?>

			<div class="success-messages"></div> <!--/success-messages-->

  		<form class="form-horizontal" method="POST" action="php_action/editOrder.php" id="editOrderForm">

  			<?php $orderId = $_GET['i'];

  			$sql = "SELECT orders.order_id, orders.order_date, orders.client_name, orders.client_contact, orders.grand_total, orders.paid, orders.due, orders.payment_type, orders.payment_status FROM orders
					WHERE orders.order_id = {$orderId}";

				$result = $connect->query($sql);
				$data = $result->fetch_row();
  			?>

			  <div class="form-group">
			    <label for="orderDate" class="col-sm-2 control-label">Fecha</label>
			    <div class="col-sm-10">
						<input type="text" class="form-control" id="orderDate" name="orderDate" autocomplete="off" value="<?php echo $data[1] ?>" disabled="disabled" />
			    </div>
			  </div> <!--/form-group-->
			  <div class="form-group">
			    <label for="clientName" class="col-sm-2 control-label">Nombre Cliente</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" id="clientName" name="clientName" placeholder="Mombre del Cliente" autocomplete="off" value="<?php echo $data[2] ?>" />
			    </div>
			  </div> <!--/form-group-->
			  <div class="form-group">
			    <label for="clientContact" class="col-sm-2 control-label">Numero de Contacto</label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" id="clientContact" name="clientContact" placeholder="Numero de Contacto" autocomplete="off" value="<?php echo $data[3] ?>" />
			    </div>
			  </div> <!--/form-group-->

			  <table class="table" id="productTable">
			  	<thead>
			  		<tr>
			  			<th style="width:40%;">Producto</th>
			  			<th style="width:20%;">Precio</th>
			  			<th style="width:15%;">Cantidad</th>
			  			<th style="width:15%;">Total</th>
			  			<th style="width:10%;"></th>
			  		</tr>
			  	</thead>
			  	<tbody>
			  		<?php

			  		$orderItemSql = "SELECT order_item.order_item_id, order_item.order_id, order_item.product_id, order_item.quantity, order_item.rate, order_item.total FROM order_item WHERE order_item.order_id = {$orderId}";
						$orderItemResult = $connect->query($orderItemSql);
						// $orderItemData = $orderItemResult->fetch_all();

						// print_r($orderItemData);
			  		$arrayNumber = 0;
			  		// for($x = 1; $x <= count($orderItemData); $x++) {
			  		$x = 1;
			  		while($orderItemData = $orderItemResult->fetch_array()) {
			  			// print_r($orderItemData); ?>
			  			<tr id="row<?php echo $x; ?>" class="<?php echo $arrayNumber; ?>">
			  				<td style="margin-left:20px;">
			  					<div class="form-group">

			  					<select class="form-control" name="productName[]" id="productName<?php echo $x; ?>" onchange="getProductData(<?php echo $x; ?>)" >
			  						<option value="">~~SELECT~~</option>
			  						<?php
			  							$productSql = "SELECT * FROM product WHERE active = 1 AND status = 1 AND quantity != 0";
			  							$productData = $connect->query($productSql);

			  							while($row = $productData->fetch_array()) {
			  								$selected = "";
			  								if($row['product_id'] == $orderItemData['product_id']) {
			  									$selected = "selected";
			  								} else {
			  									$selected = "";
			  								}

			  								echo "<option value='".$row['product_id']."' id='changeProduct".$row['product_id']."' ".$selected." >".$row['product_name']."</option>";
										 	} // /while

			  						?>
		  						</select>
			  					</div>
			  				</td>
			  				<td style="padding-left:20px;">
			  					<input type="text" name="rate[]" id="rate<?php echo $x; ?>" autocomplete="off" disabled="true" class="form-control" value="<?php echo $orderItemData['rate']; ?>" />
			  					<input type="hidden" name="rateValue[]" id="rateValue<?php echo $x; ?>" autocomplete="off" class="form-control" value="<?php echo $orderItemData['rate']; ?>" />
			  				</td>
			  				<td style="padding-left:20px;">
			  					<div class="form-group">
			  					<input type="number" name="quantity[]" id="quantity<?php echo $x; ?>" onkeyup="getTotal(<?php echo $x ?>)" autocomplete="off" class="form-control" min="1" value="<?php echo $orderItemData['quantity']; ?>" />
			  					</div>
			  				</td>
			  				<td style="padding-left:20px;">
			  					<input type="text" name="total[]" id="total<?php echo $x; ?>" autocomplete="off" class="form-control" disabled="true" value="<?php echo $orderItemData['total']; ?>"/>
			  					<input type="hidden" name="totalValue[]" id="totalValue<?php echo $x; ?>" autocomplete="off" class="form-control" value="<?php echo $orderItemData['total']; ?>"/>
			  				</td>
			  				<td>

			  					<button class="btn btn-default removeProductRowBtn" type="button" id="removeProductRowBtn" onclick="removeProductRow(<?php echo $x; ?>)"><i class="glyphicon glyphicon-trash"></i></button>
			  				</td>
			  			</tr>
		  			<?php
		  			$arrayNumber++;
		  			$x++;
			  		} // /for
			  		?>
			  	</tbody>
			  </table>

			  <div class="col-md-6">
			  	<!--<div class="form-group">
				    <label for="subTotal" class="col-sm-3 control-label">Monto</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="subTotal" name="subTotal" disabled="true" value="<?php echo $data[4] ?>" />
				      <input type="hidden" class="form-control" id="subTotalValue" name="subTotalValue" value="<?php echo $data[4] ?>" />
				    </div>
				  </div> /form-group-->
		  		<!--<div class="form-group">
				    <label for="discount" class="col-sm-3 control-label">Descuento</label>
				    <div class="col-sm-2">
				      <input type="text" maxlength="3" class="form-control" id="discount" name="discount" onkeyup="discountFunc()" onchange="discountFunc()" autocomplete="off" value="<?php echo $data[5] ?>" />
				    </div>
						<label class="col-sm-0 control-label">%</label>
				  </div> /form-group-->

				  <div class="form-group">
				    <label for="totalAmount" class="col-sm-3 control-label">Monto Total</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="totalAmount" name="totalAmount" disabled="true" value="<?php echo $data[6] ?>" />
				      <input type="hidden" class="form-control" id="totalAmountValue" name="totalAmountValue" value="<?php echo $data[6] ?>"  />
				    </div>
				  </div> <!--/form-group-->


			  </div> <!--/col-md-6-->

			  <div class="col-md-6">
			  	<div class="form-group">
				    <label for="paid" class="col-sm-3 control-label">Monto a Pagar</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="paid" name="paid" autocomplete="off" onkeyup="calcularVuelto()" value="<?php echo $data[7] ?>"  />
				    </div>
				  </div> <!--/form-group-->
				  <div class="form-group">
				    <label for="due" class="col-sm-3 control-label">Vuelto</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="due" name="due" disabled="true" value="<?php echo $data[8] ?>"  />
				      <input type="hidden" class="form-control" id="dueValue" name="dueValue" value="<?php echo $data[8] ?>"  />
				    </div>
				  </div> <!--/form-group-->

				  <div class="form-group">
				    <label for="clientContact" class="col-sm-3 control-label">Estado del Pago</label>
				    <div class="col-sm-9">
				      <select class="form-control" disabled name="paymentStatus" id="paymentStatus">
				      	<option value="">~~SELECT~~</option>
				      	<option value="1" <?php if($data[10] == 1) {
				      		echo "selected";
				      	} ?>  >Pago Completo</option>
				      	<option value="2" <?php if($data[10] == 2) {
				      		echo "selected";
				      	} ?> >Pago Adelantado</option>
				      	<option value="3" <?php if($data[10] == 3) {
				      		echo "selected";
				      	} ?> >No Pagado</option>
				      </select>
				    </div>
				  </div> <!--/form-group-->
			  </div> <!--/col-md-6-->


			  <div class="form-group editButtonFooter">
			    <div class="col-sm-offset-2 col-sm-10">
			    <!--<button type="button" class="btn btn-default" onclick="addRow()" id="addRowBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-plus-sign"></i> Agregar Producto </button>-->

			    <input type="hidden" name="orderId" id="orderId" value="<?php echo $_GET['i']; ?>" />

			    <button type="submit" id="editOrderBtn" data-loading-text="Loading..."  class="btn btn-success"><i class="glyphicon glyphicon-ok-sign"></i> Finalizar Pago</button>

			    </div>
			  </div>
			</form>

			<?php
		} // /get order else  ?>


	</div> <!--/panel-->
</div> <!--/panel-->


<!-- edit order -->
<div class="modal fade" tabindex="-1" role="dialog" id="paymentOrderModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-edit"></i> Edit Payment</h4>
      </div>

      <div class="modal-body form-horizontal" style="max-height:500px; overflow:auto;" >

      	<div class="paymentOrderMessages"></div>


			  <div class="form-group">
			    <label for="due" class="col-sm-3 control-label">Due Amount</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" id="due" name="due" disabled="true" />
			    </div>
			  </div> <!--/form-group-->
			  <div class="form-group">
			    <label for="payAmount" class="col-sm-3 control-label">Pay Amount</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" id="payAmount" name="payAmount"/>
			    </div>
			  </div> <!--/form-group-->
			  <div class="form-group">
			    <label for="clientContact" class="col-sm-3 control-label">Payment Type</label>
			    <div class="col-sm-9">
			      <select class="form-control" name="paymentType" id="paymentType" >
			      	<option value="">~~SELECT~~</option>
			      	<option value="1">Cheque</option>
			      	<option value="2">Cash</option>
			      	<option value="3">Credit Card</option>
			      </select>
			    </div>
			  </div> <!--/form-group-->
			  <div class="form-group">
			    <label for="clientContact" class="col-sm-3 control-label">Payment Status</label>
			    <div class="col-sm-9">
			      <select class="form-control" name="paymentStatus" id="paymentStatus">
			      	<option value="">~~SELECT~~</option>
			      	<option value="1">Pago Completo</option>
			      	<option value="2">Pago Adelantado</option>
			      	<option value="3">No Pagado</option>
			      </select>
			    </div>
			  </div> <!--/form-group-->

      </div> <!--/modal-body-->
      <div class="modal-footer">
      	<button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>
        <button type="button" class="btn btn-primary" id="updatePaymentOrderBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-ok-sign"></i> Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /edit order-->

<!-- remove order -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeOrderModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i> Eliminar Venta</h4>
      </div>
      <div class="modal-body">

      	<div class="removeOrderMessages"></div>

        <p>Realmente desea Eliminar la Venta ?</p>
      </div>
      <div class="modal-footer removeProductFooter">
        <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Cerrar</button>
        <button type="button" class="btn btn-primary" id="removeOrderBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-ok-sign"></i> Eliminar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /remove order-->


<script src="custom/js/order.js?ver=20170324"></script>

<?php require_once 'includes/footer.php'; ?>



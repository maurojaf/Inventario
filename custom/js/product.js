var manageProductTable;


$(document).ready(function() {

    $("#expirationDate").datetimepicker({
        format: 'dd/mm/yyyy',
        language: 'es',
        minView: 2,
        autoclose: true,
        weekStart: 1
    });

    // top nav bar 
    $('#navProduct').addClass('active');
    // manage product data table
    manageProductTable = $('#manageProductTable').DataTable({
        "language": {
            "lengthMenu": "Mostrar _MENU_ filas por paginas",
            "zeroRecords": "No se encontraron registros coincidentes",
            "info": "Mostrando pagina _PAGE_ de _PAGES_",
            "infoEmpty": "Sin registros disponibles",
            "infoFiltered": "(Se filtraron _MAX_ registros)",
            "sSearch": "Buscar:",
            "paginate": {
                "previous": "Anterior",
                "next": "Siguiente"
            }
        },
        'ajax': 'php_action/fetchProduct.php',
        'bSort': true,
        'order': []
    });

    //prueba par gits
    // add product modal btn clicked 
    $("#addProductModalBtn").unbind('click').bind('click', function() {
        // // product form reset
        $("#submitProductForm")[0].reset();

        // remove text-error 
        $(".text-danger").remove();
        // remove from-group error
        $(".form-group").removeClass('has-error').removeClass('has-success');

        $("#productImage").fileinput({
            language: "es",
            overwriteInitial: true,
            maxFileSize: 2500,
            showClose: false,
            showCaption: false,
            browseLabel: '',
            removeLabel: '',
            browseIcon: '<i class="glyphicon glyphicon-folder-open"></i>',
            removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
            elErrorContainer: '#kv-avatar-errors-1',
            msgErrorClass: 'alert alert-block alert-danger',
            //defaultPreviewContent: '<img src="assests/images/photo_default.png" alt="Profile Image" style="width:100%;">',
            layoutTemplates: { main2: '{preview} {remove} {browse}' },
            allowedFileExtensions: ["jpg", "png", "gif", "JPG", "PNG", "GIF"]
        });

        // submit product form
        $("#submitProductForm").unbind('submit').bind('submit', function() {

            $('.form-group').removeClass('has-error').removeClass('has-success');
            $('.text-danger').remove();

            // form validation
            var productImage = $("#productImage").val();
            var productName = $("#productName").val();
            var quantity = $("#quantity").val();
            var rate = $("#rate").val();
            var brandName = $("#brandName").val();
            var categoryName = $("#categoryName").val();
            var productStatus = $("#productStatus").val();
            var descuento = $("#descuento");
            var expirationDate = $("#expirationDate");

            if (productImage == "") {
                //do nothingrd
            }

            if (productName == "") {
                $("#productName").after('<p class="text-danger">Nombre Requerido</p>');
                $('#productName').closest('.form-group').addClass('has-error');
            } else {
                // remov error text field
                $("#productName").find('.text-danger').remove();
                // success out for form 
                $("#productName").closest('.form-group').addClass('has-success');
            } // /else

            if (quantity == "") {
                $("#quantity").after('<p class="text-danger">Cantidad es Obligatoria</p>');
                $('#quantity').closest('.form-group').addClass('has-error');
            } else {
                // remov error text field
                $("#quantity").find('.text-danger').remove();
                // success out for form 
                $("#quantity").closest('.form-group').addClass('has-success');
            } // /else

            if (rate == "") {
                $("#rate").after('<p class="text-danger">Precio es Obligatorio</p>');
                $('#rate').closest('.form-group').addClass('has-error');
            } else {
                // remov error text field
                $("#rate").find('.text-danger').remove();
                // success out for form 
                $("#rate").closest('.form-group').addClass('has-success');
            } // /else

            // if (brandName == "") {
            //     $("#brandName").after('<p class="text-danger">Marca es Obligatoria</p>');
            //     $('#brandName').closest('.form-group').addClass('has-error');
            // } else {
            //     // remov error text field
            //     $("#brandName").find('.text-danger').remove();
            //     // success out for form 
            //     $("#brandName").closest('.form-group').addClass('has-success');
            // }

            // if (categoryName == "") {
            //     $("#categoryName").after('<p class="text-danger">Categoria es Obligatoria</p>');
            //     $('#categoryName').closest('.form-group').addClass('has-error');
            // } else {
            //     // remov error text field
            //     $("#categoryName").find('.text-danger').remove();
            //     // success out for form 
            //     $("#categoryName").closest('.form-group').addClass('has-success');
            // }

            // if (productStatus == "") {
            //     $("#productStatus").after('<p class="text-danger">Estado es Obligatorio</p>');
            //     $('#productStatus').closest('.form-group').addClass('has-error');
            // } else {
            //     // remov error text field
            //     $("#productStatus").find('.text-danger').remove();
            //     // success out for form 
            //     $("#productStatus").closest('.form-group').addClass('has-success');
            // }

            if (productName && quantity && rate) {
                // submit loading button
                $("#createProductBtn").button('loading');

                var form = $(this);
                var formData = new FormData(this);

                console.log(formData);

                $.ajax({
                    url: form.attr('action'),
                    type: form.attr('method'),
                    data: formData,
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {

                            if (response.success == true) {
                                // submit loading button
                                $("#createProductBtn").button('reset');

                                $("#submitProductForm")[0].reset();

                                $("html, body, div.modal, div.modal-content, div.modal-body").animate({ scrollTop: '0' }, 100);

                                // shows a successful message after operation
                                $('#add-product-messages').html('<div class="alert alert-success">' +
                                    '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                                    '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> ' + response.messages +
                                    '</div>');

                                // remove the mesages
                                $(".alert-success").delay(500).show(10, function() {
                                    $(this).delay(3000).hide(10, function() {
                                        $(this).remove();
                                    });
                                }); // /.alert

                                // reload the manage student table
                                manageProductTable.ajax.reload(null, true);

                                // remove text-error 
                                $(".text-danger").remove();
                                // remove from-group error
                                $(".form-group").removeClass('has-error').removeClass('has-success');

                            } // /if response.success

                        } //success function
                        //error: AjaxFailed
                }); // /ajax function
            } // /if validation is ok 					

            return false;
        }); // /submit product form

    }); // /add product modal btn clicked


    // remove product 	

}); // document.ready fucntion

function editProduct(productId = null) {

    if (productId) {

        $("#editExpirationDate").datetimepicker({
            format: 'dd/mm/yyyy',
            language: 'es',
            minView: 2,
            autoclose: true,
            weekStart: 1
        });


        $("#productId").remove();
        // remove text-error 
        $(".text-danger").remove();
        // remove from-group error
        $(".form-group").removeClass('has-error').removeClass('has-success');
        // modal spinner
        $('.div-loading').removeClass('div-hide');
        // modal div
        $('.div-result').addClass('div-hide');

        $.ajax({
            url: 'php_action/fetchSelectedProduct.php',
            type: 'post',
            data: { productId: productId, productName: "", barCode: "" },
            dataType: 'json',
            success: function(response) {

                // modal spinner
                $('.div-loading').addClass('div-hide');
                // modal div
                $('.div-result').removeClass('div-hide');

                $("#getProductImage").attr('src', 'stock/' + response.product_image);

                $("#editProductImage").fileinput({
                    language: "es"
                });

                // product id 
                $(".editProductFooter").append('<input type="hidden" name="productId" id="productId" value="' + response.product_id + '" />');
                $(".editProductPhotoFooter").append('<input type="hidden" name="productId" id="productId" value="' + response.product_id + '" />');


                // Codigo de Barras
                $("#editBarCode").val(response.bar_code);

                // Nombre del Producto
                $("#editProductName").val(response.product_name);

                // Cantidad
                $("#editQuantity").val(response.quantity);

                // Precio
                $("#editRate").val(response.rate);

                $("#editDescuento").val(response.discount);

                // Fecha de Expiracion
                if (response.expiration_date === null) {
                    $("#editExpirationDate").val("");
                } else {
                    $("#editExpirationDate").val($.datepicker.formatDate('dd/mm/yy', new Date(response.expiration_date + " ")));
                }


                // Nombre Marca
                $("#editBrandName").val(response.brand_id);

                // Nombre Categoria
                $("#editCategoryName").val(response.categories_id);

                // Estado
                $("#editProductStatus").val(response.active);

                // update the product data function
                $("#editProductForm").unbind('submit').bind('submit', function() {



                    // remove from-group error
                    $(".form-group").removeClass('has-error').removeClass('has-success');
                    // remove text-error 
                    $(".text-danger").remove();

                    // form validation
                    var productImage = $("#editProductImage").val();
                    var productName = $("#editProductName").val();
                    var quantity = $("#editQuantity").val();
                    var rate = $("#editRate").val();
                    var brandName = $("#editBrandName").val();
                    var categoryName = $("#editCategoryName").val();
                    var productStatus = $("#editProductStatus").val();


                    if (productName == "") {
                        $("#editProductName").after('<p class="text-danger">Product Name field is required</p>');
                        $('#editProductName').closest('.form-group').addClass('has-error');
                    } else {
                        // remov error text field
                        $("#editProductName").find('.text-danger').remove();
                        // success out for form 
                        $("#editProductName").closest('.form-group').addClass('has-success');
                    } // /else

                    if (quantity == "") {
                        $("#editQuantity").after('<p class="text-danger">Quantity field is required</p>');
                        $('#editQuantity').closest('.form-group').addClass('has-error');
                    } else {
                        // remov error text field
                        $("#editQuantity").find('.text-danger').remove();
                        // success out for form 
                        $("#editQuantity").closest('.form-group').addClass('has-success');
                    } // /else

                    if (rate == "") {
                        $("#editRate").after('<p class="text-danger">Rate field is required</p>');
                        $('#editRate').closest('.form-group').addClass('has-error');
                    } else {
                        // remov error text field
                        $("#editRate").find('.text-danger').remove();
                        // success out for form 
                        $("#editRate").closest('.form-group').addClass('has-success');
                    } // /else

                    if (brandName == "") {
                        $("#editBrandName").after('<p class="text-danger">Brand Name field is required</p>');
                        $('#editBrandName').closest('.form-group').addClass('has-error');
                    } else {
                        // remov error text field
                        $("#editBrandName").find('.text-danger').remove();
                        // success out for form 
                        $("#editBrandName").closest('.form-group').addClass('has-success');
                    } // /else

                    if (categoryName == "") {
                        $("#editCategoryName").after('<p class="text-danger">Category Name field is required</p>');
                        $('#editCategoryName').closest('.form-group').addClass('has-error');
                    } else {
                        // remov error text field
                        $("#editCategoryName").find('.text-danger').remove();
                        // success out for form 
                        $("#editCategoryName").closest('.form-group').addClass('has-success');
                    } // /else

                    if (productStatus == "") {
                        $("#editProductStatus").after('<p class="text-danger">Product Status field is required</p>');
                        $('#editProductStatus').closest('.form-group').addClass('has-error');
                    } else {
                        // remov error text field
                        $("#editProductStatus").find('.text-danger').remove();
                        // success out for form 
                        $("#editProductStatus").closest('.form-group').addClass('has-success');
                    } // /else					

                    if (productName && quantity && rate && brandName && categoryName && productStatus) {
                        // submit loading button
                        $("#editProductBtn").button('loading');

                        var form = $(this);
                        var formData = new FormData(this);



                        $.ajax({
                            url: form.attr('action'),
                            type: form.attr('method'),
                            data: formData,
                            dataType: 'json',
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: function(response) {
                                    console.log(response);
                                    if (response.success == true) {
                                        // submit loading button
                                        $("#editProductBtn").button('reset');

                                        $("html, body, div.modal, div.modal-content, div.modal-body").animate({ scrollTop: '0' }, 100);

                                        // shows a successful message after operation
                                        $('#edit-product-messages').html('<div class="alert alert-success">' +
                                            '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                                            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> ' + response.messages +
                                            '</div>');

                                        // remove the mesages
                                        $(".alert-success").delay(500).show(10, function() {
                                            $(this).delay(3000).hide(10, function() {
                                                $(this).remove();
                                            });
                                        }); // /.alert

                                        // reload the manage student table
                                        manageProductTable.ajax.reload(null, true);

                                        // remove text-error 
                                        $(".text-danger").remove();
                                        // remove from-group error
                                        $(".form-group").removeClass('has-error').removeClass('has-success');

                                    } // /if response.success

                                } //success function
                                //error: AjaxFailed
                        }); // /ajax function
                    } // /if validation is ok 					

                    return false;
                }); // update the product data function

                // update the product image				
                $("#updateProductImageForm").unbind('submit').bind('submit', function() {
                    // form validation
                    var productImage = $("#editProductImage").val();

                    if (productImage == "") {
                        $("#editProductImage").closest('.center-block').after('<p class="text-danger">El campo Imagen es obligatorio</p>');
                        $('#editProductImage').closest('.form-group').addClass('has-error');
                    } else {
                        // remov error text field
                        $("#editProductImage").find('.text-danger').remove();
                        // success out for form 
                        $("#editProductImage").closest('.form-group').addClass('has-success');
                    } // /else

                    if (productImage) {
                        // submit loading button
                        $("#editProductImageBtn").button('loading');

                        var form = $(this);
                        var formData = new FormData(this);

                        $.ajax({
                            url: form.attr('action'),
                            type: form.attr('method'),
                            data: formData,
                            dataType: 'json',
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: function(response) {

                                    if (response.success == true) {
                                        // submit loading button
                                        $("#editProductImageBtn").button('reset');

                                        $("html, body, div.modal, div.modal-content, div.modal-body").animate({ scrollTop: '0' }, 100);

                                        // shows a successful message after operation
                                        $('#edit-productPhoto-messages').html('<div class="alert alert-success">' +
                                            '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                                            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> ' + response.messages +
                                            '</div>');

                                        // remove the mesages
                                        $(".alert-success").delay(500).show(10, function() {
                                            $(this).delay(3000).hide(10, function() {
                                                $(this).remove();
                                            });
                                        }); // /.alert

                                        // reload the manage student table
                                        manageProductTable.ajax.reload(null, true);

                                        $(".fileinput-remove-button").click();

                                        $.ajax({
                                            url: 'php_action/fetchProductImageUrl.php?i=' + productId,
                                            type: 'post',
                                            success: function(response) {
                                                $("#getProductImage").attr('src', response);
                                            }
                                        });

                                        // remove text-error 
                                        $(".text-danger").remove();
                                        // remove from-group error
                                        $(".form-group").removeClass('has-error').removeClass('has-success');

                                    } // /if response.success

                                } // /success function
                        }); // /ajax function
                    } // /if validation is ok 					

                    return false;
                }); // /update the product image

            }, // /success function
            error: function(xhr, ajaxOptions, thrownError) {
                console.log('Error al obtener producto...');

                console.log(xhr.status);
                console.log(thrownError);
            }

        }); // /ajax to fetch product image


    } else {
        alert('Favor refresque la pagina!!');
    }
} // /edit product function

// remove product 
function removeProduct(productId = null) {
    if (productId) {
        // remove product button clicked
        $("#removeProductBtn").unbind('click').bind('click', function() {
            // loading remove button
            $("#removeProductBtn").button('loading');
            $.ajax({
                url: 'php_action/removeProduct.php',
                type: 'post',
                data: { productId: productId },
                dataType: 'json',
                success: function(response) {
                        // loading remove button
                        $("#removeProductBtn").button('reset');
                        if (response.success == true) {
                            // remove product modal
                            $("#removeProductModal").modal('hide');

                            // update the product table
                            manageProductTable.ajax.reload(null, false);

                            // remove success messages
                            $(".remove-messages").html('<div class="alert alert-success">' +
                                '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                                '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> ' + response.messages +
                                '</div>');

                            // remove the mesages
                            $(".alert-success").delay(500).show(10, function() {
                                $(this).delay(3000).hide(10, function() {
                                    $(this).remove();
                                });
                            }); // /.alert
                        } else {

                            // remove success messages
                            $(".removeProductMessages").html('<div class="alert alert-success">' +
                                '<button type="button" class="close" data-dismiss="alert">&times;</button>' +
                                '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> ' + response.messages +
                                '</div>');

                            // remove the mesages
                            $(".alert-success").delay(500).show(10, function() {
                                $(this).delay(3000).hide(10, function() {
                                    $(this).remove();
                                });
                            }); // /.alert

                        } // /error
                    } // /success function
                    //error: AjaxFailed
            }); // /ajax fucntion to remove the product
            return false;
        }); // /remove product btn clicked
    } // /if productid
} // /remove product function

function clearForm(oForm) {

}

//$("input[id$='productName']").on("keypress", function(e) {
$("#productName, #editProductName").on("keypress", function(e) {
    IsAlphaNumeric(e)
});


function IsAlphaNumeric(e) {

    // remove text-error 
    $(".text-danger").remove();
    // remove from-group error
    $(".form-group").removeClass('has-error').removeClass('has-success');


    var regex = new RegExp("^[a-zA-Z0-9\\-\\s]+$");
    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
    if (regex.test(str)) {
        return true;
    }
    $("#submitProductForm, #editProductForm").after('<p class="text-danger">Los caracteres especiales no son permitidos</p>');
    e.preventDefault();
    return false;

}
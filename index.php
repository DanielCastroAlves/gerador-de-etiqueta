<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerar Etiqueta</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>
        .label-preview {
            border: 2px solid black;
            position: relative;
            margin: 20px 0;
            background-color: #f0f0f0;
            height: 400px;
        }
        .label-section {
            position: absolute;
            border: 1px dashed #ccc;
            padding: 5px;
            box-sizing: border-box;
            background-color: white;
        }
        .draggable {
            cursor: move;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Criar Etiqueta</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="label-form" action="src/generate_label.php" method="post">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="produto">Produto</label>
                            <input type="text" class="form-control" id="produto" name="produto" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="codigo_barras">Código de Barras</label>
                            <input type="text" class="form-control" id="codigo_barras" name="codigo_barras" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="peso">Peso</label>
                            <input type="text" class="form-control" id="peso" name="peso" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="validade">Data de Validade</label>
                            <input type="date" class="form-control" id="validade" name="validade" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="largura">Largura da Etiqueta (mm)</label>
                            <input type="number" class="form-control" id="largura" name="largura" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="altura">Altura da Etiqueta (mm)</label>
                            <input type="number" class="form-control" id="altura" name="altura" required>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary mb-3" id="add-field">Adicionar Campo</button>
                    <div class="label-preview" id="label-preview">
                        <div class="label-section draggable" data-field="produto" id="produto_label">Produto</div>
                        <div class="label-section draggable" data-field="codigo_barras" id="codigo_barras_label">Código de Barras</div>
                        <div class="label-section draggable" data-field="peso" id="peso_label">Peso</div>
                        <div class="label-section draggable" data-field="validade" id="validade_label">Data de Validade</div>
                    </div>
                    <input type="hidden" name="produto_x" id="produto_x" value="0">
                    <input type="hidden" name="produto_y" id="produto_y" value="0">
                    <input type="hidden" name="codigo_barras_x" id="codigo_barras_x" value="0">
                    <input type="hidden" name="codigo_barras_y" id="codigo_barras_y" value="0">
                    <input type="hidden" name="peso_x" id="peso_x" value="0">
                    <input type="hidden" name="peso_y" id="peso_y" value="0">
                    <input type="hidden" name="validade_x" id="validade_x" value="0">
                    <input type="hidden" name="validade_y" id="validade_y" value="0">
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Gerar Etiqueta</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(function() {
            $(".draggable").draggable({
                stop: function(event, ui) {
                    var field = $(this).data('field');
                    var posXmm = ui.position.left * 0.264583; 
                    var posYmm = ui.position.top * 0.264583; 
                    $("#" + field + "_x").val(posXmm.toFixed(2));
                    $("#" + field + "_y").val(posYmm.toFixed(2));
                }
            });

            $("#add-field").click(function() {
                var fieldName = prompt("Nome do campo:");
                if (fieldName) {
                    var newField = $("<div class='label-section draggable' data-field='" + fieldName + "'>" + fieldName + "</div>");
                    $("#label-preview").append(newField);
                    newField.draggable({
                        stop: function(event, ui) {
                            var field = $(this).data('field');
                            var posXmm = ui.position.left * 0.264583; 
                            var posYmm = ui.position.top * 0.264583; 
                            $("input[name='" + field + "_x']").val(posXmm.toFixed(2));
                            $("input[name='" + field + "_y']").val(posYmm.toFixed(2));
                        }
                    });

                    $("#fields").append("<div class='form-group col-md-6'><label for='" + fieldName + "'>" + fieldName + "</label><input type='text' class='form-control' id='" + fieldName + "' name='" + fieldName + "'></div>");
                    $("#fields").append("<input type='hidden' name='" + fieldName + "_x' value='0'>");
                    $("#fields").append("<input type='hidden' name='" + fieldName + "_y' value='0'>");
                }
            });

            $("#largura, #altura").on("input", function() {
                var largura = $("#largura").val();
                var altura = $("#altura").val();
                $("#label-preview").css({
                    width: (largura * 3.7795275591) + 'px', 
                    height: (altura * 3.7795275591) + 'px'   
                });
            });
        });
    </script>
</body>
</html>

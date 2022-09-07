<div class="panel panel-custom">
            <div class="panel-body" style="background: #fafaf5; border-radius: 20px">
                <h5 class="text-center file-title">CADASTRO DE ARQUIVOS</h5>

                <form action="upload.php" enctype="multipart/form-data" id="formulario" method="post">
                    <h5 class="file-title" style="margin-left: 15px">LOCALIDADE</h5>
                    <div class="modal-form">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="regiao">REGIÃO</label>
                                    <select class="form-control" name="regiao" id="regiao" style="padding: 6px 12px;" required>
                                    <option value='' selected> Selecione a região </option>
                                    <?php                                                                                         
                                        $query = "SELECT * FROM pae_regiao where id !='962' and id != '2762' ORDER BY nome";
                                        $res = mysqli_query($conn, $query);
                                        while($row = mysqli_fetch_assoc($res) ) {
                                            echo '<option value="'.$row['id'].'">'.$row['nome'].'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="regiao">DISTRITO</label>
                                    <select class="form-control" name="distrito" id="distrito" style="padding: 6px 12px;">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="regiao">IGREJA</label>
                                    <select class="form-control" name="igreja" id="igreja" style="padding: 6px 12px;">

                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h5 class="file-title" style="margin-left: 15px; margin-top: 10px;">ARQUIVO</h5>
                    <div class="modal-form">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="regiao">CATEGORIA</label>
                                    <select class="form-control" name="categoria" id="categoria" style="padding: 6px 12px;" required>
                                    <option value='' selected> Selecione a categoria </option>
                                    <?php                                                                                         
                                        $query = "SELECT * FROM arq_categoria ORDER BY nome";
                                        $res = mysqli_query($conn, $query);
                                        while($row = mysqli_fetch_assoc($res) ) {
                                            echo '<option value="'.$row['id'].'">'.$row['nome'].'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="regiao">SUBCATEGORIA</label>
                                    <select class="form-control" name="subcategoria" id="subcategoria" style="padding: 6px 12px;" required>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="titulo">TÍTULO</label>
                                    <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Insira o título do arquivo" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="descricao">DESCRIÇÃO</label>
                                    <textarea class="form-control" id="descricao" rows="6" name="descricao" required></textarea>
                                </div>
                            </div>
                        </div>
                        <input type="file" name="arquivo[]" id="arquivo" required ,multiple>

                        <div class="row">
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-save" id="salvar">SALVAR</button>
                            </div>
                        </div>
                    </div>
                </form>  
            </div>
        </div>

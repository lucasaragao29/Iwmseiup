<div class="panel panel-custom">
            <div class="panel-body" style="background: #fafaf5; border-radius: 20px">
                <h5 class="text-center file-title">PESQUISA DE ARQUIVOS</h5>
                <div class="modal-form">
                   <a href="?sessao=newfile"><button class="btn new-file">NOVO ARQUIVO</button></a>
                    <form action="" method="POST" id="formSearch">
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
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="categoria">CATEGORIA</label>
                                    <select class="form-control" name="categoria" id="categoria" style="padding: 6px 12px;">                                    
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
                                    <label for="subcategoria">SUBCATEGORIA</label>
                                    <select class="form-control" name="subcategoria" id="subcategoria" style="padding: 6px 12px;">
                                       
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2">
                                <button class="btn btn-search" id="pesquisar">PESQUISAR</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-table" id="result-search" hidden>
                    <h5 class="file-title">RESULTADO DE PESQUISA</h5>
                    <table class="table table-bordered" id="tbPesquisar" >
                        <thead>
                            <tr class="personal-thead">
                                <th class="text-center" scope="col" style="width: 20%; line-height: 2.4;">TÍTULO</th>
                                <th class="text-center" scope="col" style="width: 05%; line-height: 2.4;">EXT</th>
                                <th class="text-center" scope="col" style="width: 15%; line-height: 2.4;">DISTRITO</th>
                                <th class="text-center" scope="col" style="width: 10%; line-height: 2.4;">IGREJA</th>
                                <th class="text-center" scope="col" style="width: 30%; line-height: 2.4;">DESCRIÇÃO</th>
                                <th class="text-center" scope="col" style="width: 30%; line-height: 2.4;">OPÇÕES</th>
                            </tr>
                        </thead>
                        <tbody>
                           
                        </tbody>
                    </table>
                </div>
            </div>
        </div> 
        
				  
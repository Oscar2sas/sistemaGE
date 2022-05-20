                <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">  
                 <input type="hidden" name="accion" value="buscar">  
                 
                 <div class="form-group">
                    <label for="ndniocuil_persona">D.N.I.  o   C.U.I.L. </label>
                    <input type="number" class="form-control"  name="ndniocuil_persona" size=15 placeholder="Ingrese el DNI O CUIL (sin puntos)..." required>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-9">
                        </div>
                        <div class="title-right" >
                                <button name="buscapordniocuil" class="btn btn-warning" type="submit">Buscar</button>
                        </div>
                     </div>
                </div>


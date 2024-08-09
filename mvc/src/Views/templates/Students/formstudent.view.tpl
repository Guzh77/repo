<h1>{{modedsc}}</h1>

<form action="index.php?page=Students_FormStudent&mode={{mode}}{{if mode=='UPD'}}&id={{student.id_estudiante}}{{endif}}" method="post">
    <div class="grid">
        <div class="row">
            <label class="col-2" for="txtNombre">Nombre:</label>
            <input class="col-10" type="text" name="nombre" id="txtNombre" value="{{student.nombre}}" required />
        </div>
        <div class="row">
            <label class="col-2" for="txtApellido">Apellido:</label>
            <input class="col-10" type="text" name="apellido" id="txtApellido" value="{{student.apellido}}" required />
        </div>
        <div class="row">
            <label class="col-2" for="txtEdad">Edad:</label>
            <input class="col-10" type="number" name="edad" id="txtEdad" value="{{student.edad}}" min="0" required />
        </div>
        <div class="row">
            <label class="col-2" for="txtEspecialidad">Especialidad:</label>
            <input class="col-10" type="text" name="especialidad" id="txtEspecialidad" value="{{student.especialidad}}" required />
        </div>
        <div class="row">
            <div class="col-12 align-center">
                <button type="submit">Guardar</button>
            </div>
        </div>
    </div>
</form>

<h1>Estudiantes de Ciencias Computacionales</h1>

<section class="grid">
    <div class="row">
        <form class="col-12 col-m-8" action="index.php" method="get">
            <div class="flex align-center">
                <div class="col-8 row">
                    <input type="hidden" name="page" value="Students_Students">
                    <label class="col-3" for="partialName">Nombre/Apellido</label> 
                    <input class="col-9" type="text" name="partialName" id="partialName" value="{{partialName}}" />
                    <label class="col-3" for="edad">Edad</label>
                    <input class="col-9" type="number" name="edad" id="edad" value="{{edad}}" min="0" /> 
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
                    {{ifnot OrderById_estudiante}}
                    <a href="index.php?page=Students_Students&orderBy=id_estudiante&orderDescending=0">ID <i class="fas fa-sort"></i></a>
                    {{endifnot OrderById_estudiante}}
                    {{if OrderId_estudianteDesc}}
                    <a href="index.php?page=Students_Students&orderBy=clear&orderDescending=0">ID <i class="fas fa-sort-down"></i></a>
                    {{endif OrderId_estudianteDesc}}
                    {{if OrderId_estudiante}}
                    <a href="index.php?page=Students_Students&orderBy=id_estudiante&orderDescending=1">ID <i class="fas fa-sort-up"></i></a>
                    {{endif OrderId_estudiante}}
                </th>
                <th class="left">
                    {{ifnot OrderByNombre}}
                    <a href="index.php?page=Students_Students&orderBy=nombre&orderDescending=0">Nombre <i class="fas fa-sort"></i></a>
                    {{endifnot OrderByNombre}}
                    {{if OrderNombreDesc}}
                    <a href="index.php?page=Students_Students&orderBy=clear&orderDescending=0">Nombre <i class="fas fa-sort-down"></i></a>
                    {{endif OrderNombreDesc}}
                    {{if OrderNombre}}
                    <a href="index.php?page=Students_Students&orderBy=nombre&orderDescending=1">Nombre <i class="fas fa-sort-up"></i></a>
                    {{endif OrderNombre}}
                </th>
                <th class="left">
                    {{ifnot OrderByApellido}}
                    <a href="index.php?page=Students_Students&orderBy=apellido&orderDescending=0">Apellido <i class="fas fa-sort"></i></a>
                    {{endifnot OrderByApellido}}
                    {{if OrderApellidoDesc}}
                    <a href="index.php?page=Students_Students&orderBy=clear&orderDescending=0">Apellido <i class="fas fa-sort-down"></i></a>
                    {{endif OrderApellidoDesc}}
                    {{if OrderApellido}}
                    <a href="index.php?page=Students_Students&orderBy=apellido&orderDescending=1">Apellido <i class="fas fa-sort-up"></i></a>
                    {{endif OrderApellido}}
                </th>
                <th>
                    {{ifnot OrderByEdad}}
                    <a href="index.php?page=Students_Students&orderBy=edad&orderDescending=0">Edad <i class="fas fa-sort"></i></a>
                    {{endifnot OrderByEdad}}
                    {{if OrderEdadDesc}}
                    <a href="index.php?page=Students_Students&orderBy=clear&orderDescending=0">Edad <i class="fas fa-sort-down"></i></a>
                    {{endif OrderEdadDesc}}
                    {{if OrderEdad}}
                    <a href="index.php?page=Students_Students&orderBy=edad&orderDescending=1">Edad <i class="fas fa-sort-up"></i></a>
                    {{endif OrderEdad}}
                </th>
                <th class="left">
                    {{ifnot OrderByEspecialidad}}
                    <a href="index.php?page=Students_Students&orderBy=especialidad&orderDescending=0">Especialidad <i class="fas fa-sort"></i></a>
                    {{endifnot OrderByEspecialidad}}
                    {{if OrderEspecialidadDesc}}
                    <a href="index.php?page=Students_Students&orderBy=clear&orderDescending=0">Especialidad <i class="fas fa-sort-down"></i></a>
                    {{endif OrderEspecialidadDesc}}
                    {{if OrderEspecialidad}}
                    <a href="index.php?page=Students_Students&orderBy=especialidad&orderDescending=1">Especialidad <i class="fas fa-sort-up"></i></a>
                    {{endif OrderEspecialidad}}
                </th>
                <th><a href="index.php?page=Students_FormStudent&mode=INS">Nuevo</a></th> 
            </tr>
        </thead>
        <tbody>
            {{foreach students}}
            <tr>
                <td>{{id_estudiante}}</td>
                <td>{{nombre}}</td>
                <td>{{apellido}}</td>
                <td class="center">{{edad}}</td>
                <td>{{especialidad}}</td>
                <td class="center">
                    <a href="index.php?page=Students_FormStudent&mode=UPD&id={{id_estudiante}}">Editar</a>
                    &nbsp;
                    <a href="index.php?page=Students_FormStudent&mode=DEL&id={{id_estudiante}}">Eliminar</a>
                </td>
            </tr>
            {{endfor students}}
        </tbody>
    </table>
    {{pagination}}
</section>


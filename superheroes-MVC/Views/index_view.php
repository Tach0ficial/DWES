<form action="" method="POST" class="form-buscar">
    <label for="buscar">Buscar: </label>
    <input type="text" name="buscar" id="buscar" placeholder="buscar superheroe">
    <button type="submit" class="btn btn-primary">buscar</button>
</form>
<table class="table">
    <thead>
        <tr>
            <th>Imagen</th>
            <th>Nombre</th>
            <th>Evolucion</th>
            <th>Habilidades</th>
            <?php
            if ($_SESSION["perfil"] == "superheroeExperto" || $_SESSION["perfil"] == "ciudadano") {
                echo "<th>Acciones</th>";
            }
            ?>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($data as $key => $value) {
            echo "<tr>";
            echo "<td><img src=\"img/".$value["imagen"]."\"> </td>";
            echo "<td>" . $value["nombre"] . "</td>";
            echo "<td>" . $value["evolucion"] . "</td>";
            echo "<td>";
            foreach ($value["habilidades"] as $key => $val) {
                echo $val ;
            }
            echo "</td>";
            if ($_SESSION["perfil"] == "superheroeExperto") {
                echo "<td><a href=\"./edit/" . $value["id"] . "\" class=\"material-icons\">mode_edit</a><a href=\"./delete/" . $value["id"] . "\" class=\"material-icons\">delete</a></td>";
            }
            if ($_SESSION['perfil'] == 'ciudadano') {
                echo "<td><a href=\"./peticion/" . $value["id"] . "\" class=\"material-icons\">add_circle_outline</a>Hacer petición </td>";
            }
            echo "</tr>";
        }
        ?>
    </tbody>
</table>
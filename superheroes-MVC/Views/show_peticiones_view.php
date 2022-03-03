<table class="table">
    <thead>
        <tr>
            <th>Titulo</th>
            <th>Descripcion</th>
            <th>Realizazda</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($data as $key => $peticion) {
            echo "<tr>";
            echo "<td scope=\"row\">" . $peticion["titulo"] . "</td>";
            echo "<td>" . $peticion["descripcion"] . "</td>";
            echo "<td>";
            echo $peticion["realizada"] ? "Si" : "No";
            if (!$peticion["realizada"]) {
                echo "<a href=\"./realizarPeticion/" . $peticion["id"] . "\" class=\"material-icons\">check_circle</a>";
            }
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>
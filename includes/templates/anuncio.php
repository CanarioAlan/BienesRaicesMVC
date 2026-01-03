<?php

use App\Propiedad;

// Consultar BD
// $propiedades = Propiedad::All();
//identificamos de que archivo lo llamamos y mostramos la informacion correspondiente
if ($_SERVER['SCRIPT_NAME'] === '/Anuncios.php') {
    $propiedades = Propiedad::All();
} else {
    $propiedades = Propiedad::get(3);
}

?>
<div class="contenedor-anuncio">
    <!-- iteramos en el resultado -->
    <?php foreach ($propiedades as $propiedad) { ?>
        <div class="anuncio">
            <img loading="lazy" src="imagenes/<?php echo $propiedad->imagen ?>" alt="Anuncio 1">
            <div class="contenido-anuncio">
                <h3><?php echo $propiedad->titulo ?></h3>
                <p><?php echo $propiedad->descripcion ?></p>
                <p class="precio">$ <?php echo $propiedad->precio ?></p>
                <ul class="iconos-caracteristicas">
                    <li>
                        <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="Icono WC">
                        <p><?php echo $propiedad->wc ?></p>
                    </li>
                    <li>
                        <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg"
                            alt="Icono Estacionamiento">
                        <p><?php echo $propiedad->estacionamiento ?></p>
                    </li>
                    <li>
                        <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg"
                            alt="Icono Habitaciones">
                        <p><?php echo $propiedad->habitaciones ?></p>
                    </li>
                </ul>
                <a href="anuncio.php?id=<?php echo $propiedad->id ?>" class="boton boton-amarillo">Ver propiedad</a>
            </div>
        </div> <!--.anuncio-->
    <?php }; ?>
</div> <!--.contenedor-anuncio-->
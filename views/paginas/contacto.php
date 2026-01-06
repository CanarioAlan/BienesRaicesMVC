<main class="contenedor seccion">
    <h1>Contacto</h1>
    <?php
    if ($mensaje) {
        echo "<p class='alerta exito'>" . $mensaje . "</p>";
    }
    ?>
    <picture>
        <source srcset="build/img/blog1.webp" type="image/webp">
        <source srcset="build/img/blog1.jpg" type="image/jpeg">
        <img loading="lazy" src="build/img/blog1.jpg" alt="Anuncio destacado">
    </picture>
    <h2>llene el formulario</h2>
    <form class="formulario" method="POST" action="/contacto">
        <fieldset>
            <legend>Info personal</legend>
            <label for="nombre">Nombre</label>
            <input type="text" placeholder="Tu Nombre" id="nombre" name="contacto[nombre]" />
            <label for="mensaje">Mensaje</label>
            <textarea name="contacto[mensaje]" id="mensaje" placeholder="Deja tu Mensaje"></textarea>
        </fieldset>
        <fieldset>
            <legend>Info sobre la propiedad</legend>
            <label for="opciones">Vende o Compra</label>
            <select name="contacto[tipo]" id="opciones">
                <option value="" disabled selected>-- Seleccione --</option>
                <option value="Compra">Compra</option>
                <option value="Vende">Vende</option>
            </select>
            <label for="presupuesto">Precio o Presupuesto</label>
            <input type="number" placeholder="Tu Precio o Presupuesto" id="presupuesto" name="contacto[precio]" />
        </fieldset>
        <fieldset>
            <legend>Contacto</legend>
            <h5>Como desea ser contactado</h5>
            <div class="forma-contacto">
                <label for="contactar-telefono">Telefono</label>
                <input name="contacto[contacto]" type="radio" value="telefono" id="contactar-telefono" />
                <label for="contactar-email">E-mail</label>
                <input name="contacto[contacto]" type="radio" value="email" id="contactar-email" />
            </div>
            <div id="contacto">
            </div>
        </fieldset>

        <input type="submit" value="Enviar" class="boton-verde" />
    </form>
</main>
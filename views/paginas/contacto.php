<main class="contenedor seccion">
    <h1>Contacto</h1>
    <picture>
        <source srcset="build/img/blog1.webp" type="image/webp">
        <source srcset="build/img/blog1.jpg" type="image/jpeg">
        <img loading="lazy" src="build/img/blog1.jpg" alt="Anuncio destacado">
    </picture>
    <h2>llene el formulario</h2>
    <form class="formulario">
        <fieldset>
            <legend>Info personal</legend>
            <label for="nombre">Nombre</label>
            <input type="text" placeholder="Tu Nombre" id="nombre" />
            <label for="email">E-mail</label>
            <input type="email" name="email" placeholder="Tu Email" id="email" />
            <label for="telefono">Telefono</label>
            <input type="tel" name="email" placeholder="Tu Telefono" id="telefono" />
            <label for="mensaje">Mensaje</label>
            <textarea name="memsaje" id="mensaje" placeholder="Deja tu Mensaje"></textarea>
        </fieldset>
        <fieldset>
            <legend>Info sobre la propiedad</legend>
            <label for="opciones">Vende o Compra</label>
            <select name="opciones" id="opciones">
                <option value="" disabled selected>-- Seleccione --</option>
                <option value="Compra">Compra</option>
                <option value="Vende">Vende</option>
            </select>
            <label for="presupuesto">Precio o Presupuesto</label>
            <input type="number" placeholder="Tu Precio o Presupuesto" id="presupuesto" />
        </fieldset>
        <fieldset>
            <legend>Contacto</legend>
            <p>Como desea ser contactado</p>
            <div class="forma-contacto">
                <label for="contactar-telefono">Telefono</label>
                <input name="contacto" type="radio" value="telefono" id="contactar-telefono" />
                <label for="contactar-email">E-mail</label>
                <input name="contacto" type="radio" value="email" id="contactar-email" />
            </div>
            <p>Si elegio ser Contactado por telefono seleccione hora y fecha</p>
            <div id="contacto">
                <label for="fecha">Fecha:</label>
                <input type="date" id="fecha" />
                <label for="hora">Hora:</label>
                <input type="time" id="hora" min="09:00" max="18:00" />
            </div>
        </fieldset>
        <input type="submit" value="Enviar" class="boton-verde" />
    </form>
</main>
document.addEventListener("DOMContentLoaded", function () {
  eventListeners();
  darkMode();
});
function darkMode() {
  const preferenciaDarkMode = window.matchMedia("prefers-color-scheme: dark");
  if (preferenciaDarkMode.matches) {
    document.body.classList.add("dark-mode");
  } else {
    document.body.classList.remove("dark-mode");
  }
  const darkModeBoton = document.querySelector(".dark-mode-boton");
  darkModeBoton.addEventListener("click", function () {
    document.body.classList.toggle("dark-mode");
  });
}
function eventListeners() {
  const mobileMenu = document.querySelector(".mobile-menu");
  mobileMenu.addEventListener("click", navegacionResponsive);
  //mostrar campos de contacto condicionales
  const metodoContacto = document.querySelectorAll(
    'input[name="contacto[contacto]"]'
  );
  metodoContacto.forEach((input) =>
    input.addEventListener("click", mostrarMetodosContacto)
  );
}
function navegacionResponsive() {
  const navegacion = document.querySelector(".navegacion");
  //   navegacion.classList.toggle("mostrar"); es lo mismo que el codigo de abajo
  if (navegacion.classList.contains("mostrar")) {
    navegacion.classList.remove("mostrar");
  } else {
    navegacion.classList.add("mostrar");
  }
}
function mostrarMetodosContacto(e) {
  const contactoDiv = document.querySelector("#contacto");
  const contactoSelec = e.target.value;
  if (contactoSelec === "telefono") {
    contactoDiv.innerHTML = `
      <label for="telefono">Numero de Telefono</label>
      <input type="tel" name="contacto[telefono]" placeholder="Tu Telefono" id="telefono" />

      <p>Elija el dia y la hora para ser contactado</p>
      <label for="fecha">Fecha:</label>
      <input type="date" id="fecha" name="contacto[fecha]" />
      <label for="hora">Hora:</label>
      <input type="time" id="hora" min="09:00" max="18:00" name="contacto[hora]" />
    `;
  } else {
    contactoDiv.innerHTML = `
    <label for="email">E-mail</label>
    <input type="email" name="contacto[email]" placeholder="Tu Email" id="email" />
    `;
  }
}

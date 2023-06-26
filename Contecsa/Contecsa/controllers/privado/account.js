/*
* Controlador de uso general en las páginas web del sitio privado.
* Sirve para manejar las plantillas del encabezado y pie del documento.
*/

// Constante para completar la ruta de la API.
const USER_API = 'business/dashboard/usuario.php';
// Constantes para establecer las etiquetas de encabezado y pie de la página web.

const sidebar = document.querySelector('.sidebar');


// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', async () => {
    const JSON = await dataFetch(USER_API, 'getUser');
    if (JSON.session) {
        url = `perfil.html?id=${JSON.id}&username=${JSON.username}`;
        // fav = `listadeseos.html?id=${JSON.id}&username=${JSON.username}`;
    }
    sidebar.innerHTML = `
    <div class="logo-details">
    <i class='bx bxl-c-plus-plus'></i>
    <span class="logo_name">CONTECSA</span>
</div>
<ul class="nav-links">
    <li>
        <a href="../../vistas/privado/menu-sidebar.html">
            <i class='bx bx-grid-alt'></i>
            <span class="link_name">Dashboard</span>
        </a>
        <ul class="sub-menu blank">
            <li><a class="link_name" href="../../vistas/privado/menu-sidebar.html">Dashboard</a></li>
        </ul>
    </li>
    <li>
        <div class="icon-link">
            <a href="../../vistas/privado/descuento.html">
                <i class='bx bx-collection'></i>
                <span class="link_name">Descuento</span>
            </a>
            <i class='bx bx-chevron-down arrow'></i>
        </div>
        <ul class="sub-menu">
            <li><a class="link_name" href="../privado/descuento.html">Descuento</a></li>
            <li><a href="../privado/detalle-descuento.html">Detalle descuento</a></li>
            <li><a href="../privado/tipo-descuento.html">Tipo Descuento</a></li>

        </ul>
    </li>
    <li>
        <div class="icon-link">
            <a href="../../vistas/privado/Empleado.html">
                <i class='bx bx-book-alt'></i>
                <span class="link_name">Empleados</span>
            </a>
            <i class='bx bx-chevron-down arrow'></i>

        </div>
        <ul class="sub-menu">
            <li><a class="link_name" href="../../vistas/privado/Empleado.html">Empleados</a></li>

            <li><a href="../../vistas/privado/cargo.html">Cargo</a></li>
            <li><a href="../../vistas/privado/Area.html">Area</a></li>

        </ul>
    </li>
    <li>
        <a href="#">
            <i class='bx bx-pie-chart-alt-2'></i>
            <span class="link_name">Usuario</span>
        </a>
        <ul class="sub-menu blank">
            <li><a class="link_name" href="#">Usuario</a></li>
        </ul>
    </li>
    <li>
        <a href="#">
            <i class='bx bx-pie-chart-alt-2'></i>
            <span class="link_name">Usuario</span>
        </a>
        <ul class="sub-menu blank">
            <li><a class="link_name" href="#">Usuario</a></li>
        </ul>
    </li>
    <li>
        <a href="../../vistas/privado/vacaciones.html">
            <i class='bx bx-line-chart-down'></i>
            <span class="link_name">Vacaciones</span>
        </a>
        <ul class="sub-menu blank">
            <li><a class="link_name" href="../../vistas/privado/vacaciones.html">Vacaciones</a></li>
        </ul>
    </li>
    <li>
        <div class="icon-link">
            <a href="#">
                <i class='bx bx-plug'></i>
                <span class="link_name">Ausencia</span>
            </a>

            <i class='bx bx-chevron-down arrow'></i>

        </div>
        <ul class="sub-menu">
            <li><a class="link_name" href="#">Ausencia</a></li>

            <li><a href="#">Tipo Ausencia</a></li>

        </ul>
    </li>

    <li>
        <a href="../../vistas/privado/servicio.html">
            <i class='bx bx-line-chart-down'></i>
            <span class="link_name">Servicios</span>
        </a>
        <ul class="sub-menu blank">
            <li><a class="link_name" href="../../vistas/privado/servicio.html">Servicios</a></li>
        </ul>
    </li>
    <li>
        <a href="#">
            <i class='bx bx-history'></i>
            <span class="link_name">Historial</span>
        </a>
        <ul class="sub-menu blank">
            <li><a class="link_name" href="#">Historial</a></li>
        </ul>
    </li>
    <li>
        <a href="#">
            <i class='bx bx-grid'></i>
            <span class="link_name">Planilla</span>
        </a>
        <ul class="sub-menu blank">
            <li><a class="link_name" href="#">Planilla</a></li>
        </ul>
    </li>
    <li>
        <a href="#">
            <i class='bx bx-pie-chart-alt-2'></i>
            <span class="link_name">Usuario</span>
        </a>
        <ul class="sub-menu blank">
            <li><a class="link_name" href="#">Usuario</a></li>
        </ul>
    </li>
    <li>
        <a href="../../vistas/privado/perfil.html">
            <i class='bx bx-cog'></i>
            <span class="link_name">Configuracion</span>
        </a>
        <ul class="sub-menu blank">
            <li><a class="link_name" href="../../vistas/privado/perfil.html">Configuracion</a></li>
        </ul>
    </li>
    
    <li>
        <div class="profile-details">
            <div class="profile-content">
                <img src="../../recursos/img/IMG_20220917_122548_675.jpg" alt="profile">
            </div>

            <div class="name-job">
                <div class="profile_name">${JSON.username}</div>
                <div class="job">Administrador</div>
            </div>
            <i class='bx bx-log-out' onclick="logOut()"></i>

        </div>
    </li>

</ul>
`;

    let arrow = document.querySelectorAll(".arrow");
    for (var i = 0; i < arrow.length; i++) {
        arrow[i].addEventListener("click", (e) => {
            let arrowParent = e.target.parentElement.parentElement;
            arrowParent.classList.toggle("showMenu");
        });
    }

    let sidebarBtn = document.querySelector(".bx-menu");
    sidebarBtn.addEventListener("click", () => {
        sidebar.classList.toggle("close");
    });
});


// ==========================================
// LOGIN
// ==========================================

const loginForm = document.getElementById("loginForm");


if (loginForm) {

    const loginMessage =
        document.getElementById("loginMessage");


    loginForm.addEventListener(
        "submit",
        function (event) {

            event.preventDefault();


            const correo =
                document
                    .getElementById("correo")
                    .value
                    .trim();


            const password =
                document
                    .getElementById("password")
                    .value;


            // Comprobar campos

            if (!correo || !password) {

                loginMessage.textContent =
                    "Completa el correo y la contraseña.";

                return;

            }


            /*
                DEMOSTRACIÓN

                Guardamos una sesión en el navegador.

                IMPORTANTE:
                Esto NO es un sistema de usuarios real.
            */

            localStorage.setItem(
                "megatecSesion",
                "true"
            );


            localStorage.setItem(
                "megatecCorreo",
                correo
            );


            // Ir a la página principal

            window.location.href =
                "inicio.html";

        }
    );



    // ======================================
    // CANCELAR
    // ======================================

    document
        .getElementById("cancelLogin")
        .addEventListener(
            "click",
            function () {

                document
                    .getElementById("correo")
                    .value = "";


                document
                    .getElementById("password")
                    .value = "";


                document
                    .getElementById("remember")
                    .checked = false;


                loginMessage.textContent = "";


                document
                    .getElementById("correo")
                    .focus();

            }
        );



    // ======================================
    // OLVIDASTE CONTRASEÑA
    // ======================================

    document
        .getElementById("forgotPassword")
        .addEventListener(
            "click",
            function (event) {

                event.preventDefault();


                alert(
                    "Aquí podrás colocar posteriormente " +
                    "la recuperación de contraseña."
                );

            }
        );

}



// ==========================================
// PÁGINA PRINCIPAL
// ==========================================

if (
    document.body.classList.contains(
        "home-body"
    )
) {


    // ======================================
    // COMPROBAR SESIÓN
    // ======================================

    const sesion =
        localStorage.getItem(
            "megatecSesion"
        );


    if (sesion !== "true") {

        window.location.href =
            "index.html";

    }



    // ======================================
    // CERRAR SESIÓN
    // ======================================

    const logoutButton =
        document.getElementById(
            "logoutButton"
        );


    logoutButton.addEventListener(
        "click",
        function () {

            localStorage.removeItem(
                "megatecSesion"
            );


            localStorage.removeItem(
                "megatecCorreo"
            );


            window.location.href =
                "index.html";

        }
    );



    // ======================================
    // CARRITO
    // ======================================

    let carrito = 0;


    const cartCount =
        document.getElementById(
            "cartCount"
        );


    const toast =
        document.getElementById(
            "toast"
        );


    function mostrarMensaje(texto) {

        toast.textContent = texto;

        toast.classList.add("show");


        setTimeout(
            function () {

                toast.classList.remove(
                    "show"
                );

            },
            2200
        );

    }



    // Agregar productos

    const botonesComprar =
        document.querySelectorAll(
            ".buy-button"
        );


    botonesComprar.forEach(
        function (button) {

            button.addEventListener(
                "click",
                function () {

                    carrito++;


                    cartCount.textContent =
                        carrito;


                    mostrarMensaje(
                        this.dataset.product +
                        " fue agregado al carrito."
                    );

                }
            );

        }
    );



    // ======================================
    // BOTÓN CARRITO
    // ======================================

    document
        .getElementById("cartButton")
        .addEventListener(
            "click",
            function () {

                if (carrito === 0) {

                    mostrarMensaje(
                        "Tu carrito está vacío."
                    );

                } else {

                    mostrarMensaje(
                        "Tienes " +
                        carrito +
                        " producto(s) en el carrito."
                    );

                }

            }
        );



    // ======================================
    // CUENTA
    // ======================================

    document
        .getElementById("accountButton")
        .addEventListener(
            "click",
            function () {

                const correo =
                    localStorage.getItem(
                        "megatecCorreo"
                    ) ||
                    "usuario";


                mostrarMensaje(
                    "Sesión iniciada: " +
                    correo
                );

            }
        );



    // ======================================
    // BUSCADOR
    // ======================================

    const searchInput =
        document.getElementById(
            "searchInput"
        );


    const searchButton =
        document.getElementById(
            "searchButton"
        );


    function buscarProducto() {

        const texto =
            searchInput.value.trim();


        if (!texto) {

            mostrarMensaje(
                "Escribe un producto para buscar."
            );

            return;

        }


        mostrarMensaje(
            'Buscando: "' +
            texto +
            '"'
        );

    }


    searchButton.addEventListener(
        "click",
        buscarProducto
    );


    searchInput.addEventListener(
        "keydown",
        function (event) {

            if (event.key === "Enter") {

                buscarProducto();

            }

        }
    );

}
function togglePassword(id){

    const input =
    document.getElementById(id);

    if(input.type === "password"){

        input.type = "text";

    }else{

        input.type = "password";
    }
}

/* FUERZA PASSWORD */

const password =
document.getElementById("password");

const bar =
document.getElementById("bar");

password.addEventListener("input",function(){

    let val = this.value;

    let strength = 0;

    const rules = {

        rule1: val.length >= 8,

        rule2: /[A-Z]/.test(val),

        rule3: /[a-z]/.test(val),

        rule4: /[0-9]/.test(val),

        rule5: /[\W]/.test(val)
    };

    Object.keys(rules).forEach(id => {

        const element =
        document.getElementById(id);

        if(rules[id]){

            element.classList.add("valid");
            element.classList.remove("invalid");

            strength++;

        }else{

            element.classList.add("invalid");
            element.classList.remove("valid");
        }
    });

    bar.style.width =
    (strength * 20) + "%";

    if(strength <= 2){

        bar.style.background =
        "#ef4444";

    }else if(strength <= 4){

        bar.style.background =
        "#f59e0b";

    }else{

        bar.style.background =
        "#22c55e";
    }
});

/* VERIFICAR PASSWORD */

const confirmarPassword =
document.getElementById("confirmarPassword");

const passwordMatch =
document.getElementById("passwordMatch");

confirmarPassword.addEventListener("keyup",function(){

    if(confirmarPassword.value === password.value){

        passwordMatch.innerHTML =
        "✅ Las contraseñas coinciden";

        passwordMatch.style.color =
        "#22c55e";

    }else{

        passwordMatch.innerHTML =
        "❌ Las contraseñas no coinciden";

        passwordMatch.style.color =
        "#ef4444";
    }
});

/* CAMPOS DINÁMICOS */

const rol =
document.getElementById("rol");

rol.addEventListener("change",mostrarCamposRol);

function mostrarCamposRol(){

    const valor =
    rol.value;

    const campos =
    document.getElementById("camposRol");

    let html = "";

    /* ADMIN */

    if(valor === "ADMIN"){

        html = `

        <div class="extra-box admin-box">

            <h3>
                Datos Administrador
            </h3>

            <div class="input-group">

                <label>
                    Nivel de Acceso
                </label>

                <select name="nivel_admin">

                    <option>
                        TOTAL
                    </option>

                    <option>
                        LIMITADO
                    </option>

                </select>

            </div>

        </div>
        `;
    }

    /* GROOMER */

    else if(valor === "GROOMER"){

        html = `

        <div class="extra-box groomer-box">

            <h3>
                Datos Groomer
            </h3>

            <div class="grid-2">

                <div class="input-group">

                    <label>
                        Especialidad
                    </label>

                    <input
                    type="text"
                    name="especialidad"
                    placeholder="Ej: Corte Premium">

                </div>

                <div class="input-group">

                    <label>
                        Experiencia
                    </label>

                    <input
                    type="text"
                    name="experiencia"
                    placeholder="Ej: 3 años">

                </div>

            </div>

        </div>
        `;
    }

    /* RECEPCIONISTA */

    else if(valor === "RECEPCIONISTA"){

        html = `

        <div class="extra-box recepcionista-box">

            <h3>
                Datos Recepcionista
            </h3>

            <div class="grid-2">

                <div class="input-group">

                    <label>
                        Área
                    </label>

                    <input
                    type="text"
                    name="area"
                    placeholder="Atención Cliente">

                </div>

                <div class="input-group">

                    <label>
                        Escritorio
                    </label>

                    <input
                    type="text"
                    name="escritorio"
                    placeholder="Recepción 1">

                </div>

            </div>

        </div>
        `;
    }

    /* CLIENTE */

    else if(valor === "CLIENTE"){

        html = `

        <div class="extra-box cliente-box">

            <h3>
                Datos Cliente
            </h3>

            <div class="grid-2">

                <div class="input-group">

                    <label>
                        Mascota
                    </label>

                    <input
                    type="text"
                    name="mascota"
                    placeholder="Firulais">

                </div>

                <div class="input-group">

                    <label>
                        Tipo Mascota
                    </label>

                    <select name="tipo_mascota">

                        <option>
                            Perro
                        </option>

                        <option>
                            Gato
                        </option>

                        <option>
                            Otro
                        </option>

                    </select>

                </div>

            </div>

        </div>
        `;
    }

    campos.innerHTML = html;
}

/* BOTÓN */

const form =
document.getElementById("formulario");

form.addEventListener("submit",function(){

    const btn =
    document.querySelector(".btn-submit");

    btn.innerHTML =
    "Creando Usuario...";

    btn.style.opacity = ".8";
});
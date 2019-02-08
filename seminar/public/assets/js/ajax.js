const server = "http://localhost:8000/";

function xss_protection(str) {
    if (typeof str === "string") {
        str = str.replace(/</g, "&lt;");
        str = str.replace(/>/g, "&gt;");
    }

    return str;
}

$(document).ready(function() {

    // Prati svaki klik botuna Uredi
    $(".editBtn").click(function (event) {
        document
            .getElementById("modalPredmetTitle")
            .innerText = "Pričekajte";

        document
            .getElementsByClassName("modal-body")[0]
            .innerHTML = "Informacije o predmetu će doći brzo";

        // Zatraži JSON od navedenog patha
        $.getJSON(server + "mentor/subject/" + event.target.id,
            function(object) { // Funkcija ubacuje dobiveni rezultat u modal

                // Tijelo modala
                document
                    .getElementsByClassName("modal-body")[0]
                    .innerHTML = "";

                // Naslov modala (XSS zaštita)
                document
                    .getElementById("modalPredmetTitle")
                    .innerText = xss_protection(object.ime);

                for (let key in object) {
                    if (object.hasOwnProperty(key)) {
                        // Prvo slovo ključa će biti veliko
                        let key_capitalized = key.charAt(0).toUpperCase()
                            + key.substr(1);

                        object[key] = xss_protection(object[key]);

                        // Zapisuje u HTML
                        document
                            .getElementsByClassName("modal-body")[0]
                            .innerHTML += "<p>" + key_capitalized + " : "
                            + object[key] + "</p>";
                    }
                }
        })
    })

    $(".deleteBtn").click(function (event) {
        if(confirm("Jeste li sigurni da želite izbrisati ovaj predmet?")) {
            window.location.href = server + "mentor/subject/delete/" +
                event.target.id.slice(0, event.target.id.length-1);
        }
    })
})
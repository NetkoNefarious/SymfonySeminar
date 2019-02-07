var localhost = "http://127.0.0.1:8000/";

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
        $.getJSON("http://127.0.0.1:8000/mentor/subject/" + event.target.id,
            function(object) { // Funkcija ubacuje dobiveni rezultat u modal

                // Tijelo modala
                document
                    .getElementsByClassName("modal-body")[0]
                    .innerHTML = "";

                // Naslov modala
                document
                    .getElementById("modalPredmetTitle")
                    .innerText = object.ime;

                for (let key in object) {
                    // Prvo slovo ključa će biti veliko
                    let key_capitalized = key.charAt(0).toUpperCase()
                        + key.substr(1);

                    // Zapisuje u HTML
                    document
                        .getElementsByClassName("modal-body")[0]
                        .innerHTML += "<p>" + key_capitalized + " : "
                            + object[key] + "</p>";
                }
        })
    })

    $(".deleteBtn").click(function (event) {
        if(confirm("Jeste li sigurni da želite izbrisati ovaj predmet?")) {
            window.location.href = localhost + "mentor/subject/delete/" +
                event.target.id.slice(0, event.target.id.length-1);
        }
    })
})


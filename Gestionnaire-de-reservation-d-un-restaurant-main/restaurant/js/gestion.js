let dateActuelle = new Date();
let mois = dateActuelle.getMonth();
let annee = dateActuelle.getFullYear();

function creerCalendrier() {
    let date = new Date(annee, mois);
    let divInfos = document.getElementById("infos");
    divInfos.innerHTML = "";

    let table = '<table cellspacing="10"><tr><th>Lu </th><th>Ma </th><th>Me </th><th>Je </th><th>Ve </th><th>Sa </th><th>Di </th></tr><tr>';

    for (let i = 0; i < getDay(date); i++) {
        table += '<td> </td>';
    }

    while (date.getMonth() == mois) {
        let jour = date.getDate();
        let moisActuel = date.getMonth();
        let anneeActuelle = date.getFullYear();
        let dateStr = `${anneeActuelle}-${String(moisActuel + 1).padStart(2, '0')}-${String(jour).padStart(2, '0')}`; //format yyyy-mm-jj
    
        let resJour = reservations.filter(r => r.date === dateStr);

        const creneaux = {
            "19:00": 0,
            "20:00": 0,
            "21:00": 0,
            "22:00": 0
        };
    
        resJour.forEach(r => {
            let heureStr = r.heure.substring(0, 5);
            if (creneaux[heureStr] !== undefined) {
                creneaux[heureStr] += parseInt(r.nb_personnes);
            }            
        });
    
        if (getDay(date) % 7 === 6){ //dimanche
            table += '<td> </td> </tr><tr>';
        } else {
            table += `<td><div><strong>${jour}</strong><br>`;
    
        for (let heure in creneaux) { //créneaux
            let nb = creneaux[heure];
            let dispo = Math.max(0, 30 - nb);
            let classDispo = dispo > 0 ? 'dispo' : 'Pdispo';

            let idInfo = `infos-${dateStr}-${heure}`.replace(/[:]/g, ''); //id pour chaque span

            table += `<button class="bCreneau" onclick="afficher('${idInfo}')">${heure}</button>`;
            
            let infos = '';
            resJour.forEach(r => {
                let heureRes = r.heure.substring(0, 5);
                if (heureRes === heure) {
                    const id = r.id;
                    infos += `
                        <div class="ligne-resa">
                            ${r.nom ?? 'Inconnu'} (${r.nb_personnes} personnes)<br>  ${r.date}, ${r.heure} <br>
                            <button class="btSupp" onclick="suppResa(${id})">Supprimer</button>
                        </div>`;
                }
            });
            
            if (infos === '') {
                infos = 'Aucune réservation';
            }
            divInfos.innerHTML += `<span id="${idInfo}" class="infos" style="display: none;">${infos}</span>`;
            table += `<span class="${classDispo}">${dispo}</span><br>`;
            
        }
        table += `</div></td>`;
        }
    
        date.setDate(date.getDate() + 1); //jour d'après
    }
    
    if (getDay(date) != 0) {
        for (let i = getDay(date); i < 7; i++) {
            table += '<td></td>';
        }
    }

    table += '</tr></table>';

    let liste_mois = new Array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");

    document.getElementById("mois").innerHTML = `${liste_mois[mois]} ${annee}`;
    document.getElementById("calendrier").innerHTML = table;
}

function getDay(date) { // lundi 0 - dimanche 6
    let day = date.getDay();
    if (day == 0) day = 7; // dimanche 0
    return day - 1;
}

function afficher(id) {
    let span = document.getElementById(id);
    let blocInfos = document.getElementById("infosCreneau");

    blocInfos.style.display = "block";
    blocInfos.querySelectorAll(".infos").forEach(s => s.style.display = "none");

    if (span) {
        span.style.display = "block";
    }
}

function moisSuivant() {
    if (mois < dateActuelle.getMonth() + 2) {
        mois++;
        if (mois > 11) {
            mois = 0;
            annee++;
        }
        creerCalendrier(mois, annee);
    }
}

function moisPrecedent() {
    if (mois > dateActuelle.getMonth()) {
        mois--;
        if (mois < 0) {
            mois = 11;
            annee--;
        }
        creerCalendrier(mois, annee);
    }
}


function suppResa(id) {
    if (confirm("Voulez-vous vraiment supprimer cette réservation ?")) {
        window.location.href = `index.php?action=annulerResaGerant&id=${id}`;
    }
}

function fermer(){
    let blocInfos = document.getElementById("infosCreneau");
    blocInfos.style.display = "none";
}
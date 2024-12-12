function kategoriakFeltolt(adatok){
    let kategoriakTartalom = document.getElementById("kategoriaSzures");
    for (let adat of adatok) {
        kategoriakTartalom.innerHTML += 
        `
            <option value="${adat.id}">${adat.nev}</option>
        `;
    }
}

async function kategoriakLeker() {
    try {
        let eredmeny = await fetch('./termekek_adatok.php/kategoriakleker');
        let adatok = await eredmeny.json();
        kategoriakFeltolt(adatok);
    } catch (error) {
        console.error(error);
    }
}

window.addEventListener("load", kategoriakLeker);

function kategoriakFeltolt(adatok){
    let kategoriakTartalom = document.getElementById("kategoriaSzures");
    for (let adat of adatok) {
        kategoriakTartalom.innerHTML += 
        `
            <option value="${adat.id}">${adat.nev}</option>
        `;
    }
}

function gyartokFeltolt(gyartok){
    let gyartokTartalom = document.getElementById("gyartoSzures");
    for (let adat of gyartok) {
        gyartokTartalom.innerHTML += 
        `
            <option value="${adat.gyartonev}">${adat.gyartonev}</option>
        `;
    }
}

function arakFeltolt(arak){
    let rangeEgy = document.getElementById("rangeEgy");
    let rangeKetto = document.getElementById("rangeKetto");

    for (let adat of arak) {
        rangeEgy.innerHTML = `
            <input type="range" id="minRangeAr" style="width: 150px; accent-color: rgb(61, 61, 61)" 
                min="${adat.arMin}" max="${adat.arMax}" step="10" value="${adat.arMin}" 
                oninput="document.getElementById('minArValue').textContent = this.value;">
            <span id="minArValue">${adat.arMin}</span> Ft
        `;

        rangeKetto.innerHTML = `
            <input type="range" id="maxRangeAr" style="width: 150px; accent-color: rgb(61, 61, 61)" 
                min="${adat.arMin}" max="${adat.arMax}" step="10" value="${adat.arMax}" 
                oninput="document.getElementById('maxArValue').textContent = this.value;">
            <span id="maxArValue">${adat.arMax}</span> Ft
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

async function gyartokLeker() {
    try {
        let eredmenyGy = await fetch('./termekek_adatok.php/gyartokleker');
        let gyartok = await eredmenyGy.json();
        gyartokFeltolt(gyartok);
    } catch (error) {
        console.error(error);
    }
}

async function arakLeker() {
    try {
        let eredmenyA = await fetch('./termekek_adatok.php/arakleker');
        let arak = await eredmenyA.json();
        arakFeltolt(arak);
    } catch (error) {
        console.error(error);
    }
}

async function szures() {
    try {
        
    } catch (error) {
        console.error(error);
    }
}

window.addEventListener("load", kategoriakLeker);
window.addEventListener("load", gyartokLeker);
window.addEventListener("load", arakLeker);
document.getElementById("szures_").addEventListener("input", szures)

let szuresParancs = document.getElementById("szuresParancs");

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
        console.log(adat.arMax);
        
        rangeEgy.innerHTML = `
            <input type="range" id="minRangeAr" style="width: 150px; accent-color: rgb(61, 61, 61)" 
                min="${(adat.arMin)}" max="${(adat.arMax)}" step="5" value="${(adat.arMin)}" 
                oninput="document.getElementById('minArValue').textContent = this.value;">
            <span id="minArValue">${adat.arMin}</span> Ft
        `;

        rangeKetto.innerHTML = `
            <input type="range" id="maxRangeAr" style="width: 150px; accent-color: rgb(61, 61, 61)" 
                min="${(adat.arMin)}" max="${(adat.arMax)}" step="5" value="${(adat.arMax)}" 
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

function szuresEgy(osszesTermek_eredm){
    console.log(osszesTermek_eredm);
    
}

async function termekekLeker() {
    try {
        // Szűrőfeltételek begyűjtése
        let kategoria = document.getElementById("kategoriaSzures").value;
        let gyarto = document.getElementById("gyartoSzures").value;
        let minRangeAr = document.getElementById("minRangeAr").value;
        let maxRangeAr = document.getElementById("maxRangeAr").value;
        let kereses = document.getElementById("keresesSzures").value;
        
        let bodyAdatok = {
            'kategoria': kategoria,
            'gyarto': gyarto,
            'minRangeAr': minRangeAr,
            'maxRangeAr': maxRangeAr,
            'kereses': kereses
        };

        console.log(bodyAdatok);
        

        // AJAX kérés
        let eredmeny = await fetch('./termekek_adatok.php/szures', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(bodyAdatok)
        });

        // Válasz feldolgozása
        let termekek = await eredmeny.json();

        console.log(termekek);
        

        // Termékek megjelenítése
        let termekekTartalom = document.getElementById("termekekTartalom");
        termekekTartalom.innerHTML = ""; // Előző tartalom törlése

        if(termekek.length === 0){
            termekekTartalom.innerHTML = "Nincs termék a szűrőfeltételeknek megfelelően!";
        }else{
            for (let termek of termekek) {
                // Ellenőrizzük, hogy a termék nem tartalmaz-e hibás adatokat (NaN, undefined)
                if (isNaN(termek.egysegar) || termek.egysegar === undefined || termek.nev === undefined) {
                    document.getElementById("valaszSzoveg").innerHTML = "Nincs termék a szűrőfeltételeknek megfelelően!";
                    continue; // Ha hibás adat, akkor nem jelenítjük meg
                    
                }
                document.getElementById("valaszSzoveg").innerHTML = ""
                termekekTartalom.innerHTML += `
                    <div class="col-md-4 col-sm-6 col-xs-12 mb-4">
                        <div class="card shadow">
                            <div id="termekekKartyaKepKozep">
                                <img id="termekekKartyaKep" src="${termek.kep}" class="card-img-top" alt="${termek.nev}">
                            </div>
                            <div class="card-body">
                                <h6 class="card-title">${termek.nev}</h6>
                                <h6><strong>${parseInt(termek.egysegar).toLocaleString()} Ft</strong></h6>
                                <form method="POST" action="kosar_muveletek.php">
                                    <input type="hidden" name="termek_id" value="${termek.id}">
                                    <input type="hidden" name="termek_nev" value="${termek.nev}">
                                    <input type="hidden" name="termek_kep" value="${termek.kep}">
                                    <input type="hidden" name="ar" value="${termek.egysegar}">
                                    <input type="hidden" name="mennyiseg" value="1">
                                    <button type="button" id="termekekKartyaGomb" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_${termek.id}" >Részletek</button>
                                    <button type="submit" id="termekekKartyaGomb" name="add_to_cart" class="btn btn-primary" onclick="mutasdKosarbaModal()">Kosárba</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Kosárba sikeresen hozzáadás modal -->
                    <div id="kosarbaModal" class="modal" tabindex="-1" style="display: none; position: fixed; z-index: 1050; background-color: rgba(0,0,0,0.5); width: 100%; height: 100%; top: 0; left: 0; justify-content: center; align-items: center;">
                        <div class="modal-dialog" style="background-color: #d4edda; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2); text-align: center;">
                            <p style="color: #155724; font-weight: bold;">A termék a kosárba került!</p>
                            <button type="button" id="closeKosarbaModal" style="background-color: #155724; color: white; border: none; padding: 5px 10px; border-radius: 5px;">Bezár</button>
                        </div>
                    </div>
    
                    <!-- Modal -->
                    <div class="modal fade" id="modal_${termek.id}" tabindex="-1" aria-labelledby="modalLabel_${termek.id}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalLabel_${termek.id}">${termek.nev}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <img src="${termek.kep}" alt="${termek.nev}" class="img-fluid mb-3">
                                    <p>${termek.leiras}</p>
                                    <h6><strong>Ár: ${parseInt(termek.egysegar).toLocaleString()} Ft</strong></h6>
                                    <p><strong>Gyártó:</strong> ${termek.gyarto}</p>
                                    <p><strong>Kategória:</strong> ${termek.kategoria_nev}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="modalKartyaGomb" class="btn btn-secondary" data-bs-dismiss="modal">Bezár</button>
                                    <form method="POST" action="kosar_muveletek.php">
                                        <input type="hidden" name="termek_id" value="${termek.t_id}">
                                        <input type="hidden" name="termek_kep" value="${termek.kep}">
                                        <input type="hidden" name="termek_nev" value="${termek.nev}">
                                        <input type="hidden" name="ar" value="${termek.egysegar}">
                                        <input type="hidden" name="mennyiseg" value="1">
                                        <button type="submit" id="termekekKartyaGomb" name="add_to_cart" class="btn btn-primary" onclick="mutasdKosarbaModal()">Kosárba</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }
        }
    } catch (error) {
        console.error("Hiba történt a termékek betöltésekor:", error);
    }
}

async function osszesTermekekLeker() {
    try {
        let bodyAdatok = {
            'kategoria': 'osszes',
            'gyarto': 'osszesGyarto',
            'minRangeAr': 0,
            'maxRangeAr': 9999999,
            'kereses': ''
        };

        // AJAX kérés
        let eredmeny = await fetch('./termekek_adatok.php/szures', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(bodyAdatok)
        });

        // Válasz feldolgozása
        let termekek = await eredmeny.json();

        console.log(termekek)

        // Termékek megjelenítése
        let termekekTartalom = document.getElementById("termekekTartalom");
        termekekTartalom.innerHTML = ""; // Előző tartalom törlése

        if(termekek.length === 0){
            termekekTartalom.innerHTML = "Nincs termék a szűrőfeltételeknek megfelelően!";
        }else{
            for (let termek of termekek) {
                // Ellenőrizzük, hogy a termék nem tartalmaz-e hibás adatokat (NaN, undefined)
                if (isNaN(termek.egysegar) || termek.egysegar === undefined || termek.nev === undefined) {
                    document.getElementById("valaszSzoveg").innerHTML = "Nincs termék a szűrőfeltételeknek megfelelően!";
                    continue; // Ha hibás adat, akkor nem jelenítjük meg
                    
                }

                termekekTartalom.innerHTML += `
                    <div class="col-md-4 col-sm-6 col-xs-12 mb-4">
                        <div class="card shadow">
                            <div id="termekekKartyaKepKozep">
                                <img id="termekekKartyaKep" src="${termek.kep}" class="card-img-top" alt="${termek.t_nev}">
                            </div>
                            <div class="card-body">
                                <h6 class="card-title">${termek.nev}</h6>
                                <h6><strong>${parseInt(termek.egysegar).toLocaleString()} Ft</strong></h6>
                                <form method="POST" action="kosar_muveletek.php">
                                    <input type="hidden" name="termek_id" value="${termek.id}">
                                    <input type="hidden" name="termek_kep" value="${termek.kep}">
                                    <input type="hidden" name="ar" value="${termek.egysegar}">
                                    <input type="hidden" name="mennyiseg" value="1">
                                    <button type="button" id="termekekKartyaGomb" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_${termek.id}">Részletek</button>
                                    <button type="submit" id="termekekKartyaGomb" name="add_to_cart" class="btn btn-primary" onclick="mutasdKosarbaModal()">Kosárba</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Kosárba sikeresen hozzáadás modal -->
                    <div id="kosarbaModal" class="modal" tabindex="-1" style="display: none; position: fixed; z-index: 1050; background-color: rgba(0,0,0,0.5); width: 100%; height: 100%; top: 0; left: 0; justify-content: center; align-items: center;">
                        <div class="modal-dialog" style="background-color: #d4edda; padding: 20px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2); text-align: center;">
                            <p style="color: #155724; font-weight: bold;">A termék a kosárba került!</p>
                            <button type="button" id="closeKosarbaModal" style="background-color: #155724; color: white; border: none; padding: 5px 10px; border-radius: 5px;">Bezár</button>
                        </div>
                    </div>

    
                    <!-- Modal -->
                    <div class="modal fade" id="modal_${termek.id}" tabindex="-1" aria-labelledby="modalLabel_${termek.id}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalLabel_${termek.id}">${termek.nev}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <img src="${termek.kep}" alt="${termek.nev}" class="img-fluid mb-3">
                                    <p>${termek.leiras}</p>
                                    <h6><strong>Ár: ${parseInt(termek.egysegar).toLocaleString()} Ft</strong></h6>
                                    <p><strong>Gyártó:</strong> ${termek.gyarto}</p>
                                    <p><strong>Kategória:</strong> ${termek.kategoria_nev}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="modalKartyaGomb" class="btn btn-secondary" data-bs-dismiss="modal">Bezár</button>
                                    <form method="POST" action="kosar_muveletek.php">
                                        <input type="hidden" name="termek_id" value="${termek.t_id}">
                                        <input type="hidden" name="termek_kep" value="${termek.kep}">
                                        <input type="hidden" name="ar" value="${termek.egysegar}">
                                        <input type="hidden" name="mennyiseg" value="1">
                                        <button type="submit" id="termekekKartyaGomb" name="add_to_cart" class="btn btn-primary" onclick="mutasdKosarbaModal()">Kosárba</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }
        }
    } catch (error) {
        console.error("Hiba történt a termékek betöltésekor:", error);
    }
}

function mutasdKosarbaModal() {
    const modal = document.getElementById("kosarbaModal");
    const closeButton = document.getElementById("closeKosarbaModal");

    // Mutatjuk a modalt
    modal.style.display = "flex";

    // Automatikus bezárás 2 másodperc után
    setTimeout(() => {
        modal.style.display = "none";
    }, 2000);

    // Manuális bezárás gombbal
    closeButton.addEventListener("click", () => {
        modal.style.display = "none";
    });
}



window.addEventListener("load", kategoriakLeker);
window.addEventListener("load", gyartokLeker);
window.addEventListener("load", arakLeker);
window.addEventListener("load", osszesTermekekLeker)




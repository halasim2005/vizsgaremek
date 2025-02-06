let szuresParancs = document.getElementById("szuresParancs");

function kategoriakFeltolt(adatok) {
    let kategoriakTartalom = document.getElementById("kategoriaSzures");
    for (let adat of adatok) {
        kategoriakTartalom.innerHTML +=
            `
            <option value="${adat.id}">${adat.nev}</option>
        `;
    }
}

function gyartokFeltolt(gyartok) {
    let gyartokTartalom = document.getElementById("gyartoSzures");
    for (let adat of gyartok) {
        gyartokTartalom.innerHTML +=
            `
            <option value="${adat.gyartonev}">${adat.gyartonev}</option>
        `;
    }
}

function arakFeltolt(arak) {
    let rangeEgy = document.getElementById("rangeEgy");
    let rangeKetto = document.getElementById("rangeKetto");

    for (let adat of arak) {
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

async function termekekLeker() {
    try {
        let kategoria = document.getElementById("kategoriaSzures").value;
        let gyarto = document.getElementById("gyartoSzures").value;
        let minRangeAr = document.getElementById("minRangeAr").value;
        let maxRangeAr = document.getElementById("maxRangeAr").value;
        let kereses = document.getElementById("keresesSzures").value;
        let rendez = document.getElementById("rendez").value;
        console.log(rendez)

        let bodyAdatok = {
            'kategoria': kategoria,
            'gyarto': gyarto,
            'minRangeAr': minRangeAr,
            'maxRangeAr': maxRangeAr,
            'kereses': kereses,
            'rendez': rendez
        };

        let eredmeny = await fetch('./termekek_adatok.php/szures', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(bodyAdatok)
        });

        let termekek = await eredmeny.json();

        // Termékek megjelenítése
        let termekekTartalom = document.getElementById("termekekTartalom");
        termekekTartalom.innerHTML = ""; // Előző tartalom törlése

        if (termekek.length === 0) {
            termekekTartalom.innerHTML = "Nincs termék a szűrőfeltételeknek megfelelően!";
        } else {
            for (let termek of termekek) {
                // Ellenőrizzük, hogy a termék nem tartalmaz-e hibás adatokat (NaN, undefined)
                if (isNaN(termek.egysegar) || termek.egysegar === undefined || termek.nev === undefined) {
                    document.getElementById("valaszSzoveg").innerHTML = "Nincs termék a szűrőfeltételeknek megfelelően!";
                    continue; // Ha hibás adat, akkor nem jelenítjük meg

                }

                document.getElementById("valaszSzoveg").innerHTML = ""
                if (termek.elerheto_darab == 0) {
                    termekekTartalom.innerHTML += `
                    <div class="col-md-4 col-sm-6 col-xs-12 mb-4">
                        <div class="card shadow">
                            <div id="termekekKartyaKepKozep">
                                <img id="termekekKartyaKep" src="${termek.kep}" class="card-img-top" alt="${termek.t_nev}">
                            </div>
                            <div class="card-body">
                                <h6 class="card-title">${termek.nev}</h6>
                                <h6><strong><span style="color: red">A termék nincs készleten!<span></strong></h6>
                                <form method="POST" action="kosar_muveletek.php">
                                    <input type="hidden" name="termek_id" value="${termek.id}">
                                    <input type="hidden" name="termek_kep" value="${termek.kep}">
                                    <input type="hidden" name="ar" value="${termek.egysegar}">
                                    <input type="hidden" name="mennyiseg" value="1">
                                    <button type="button" id="termekekKartyaGomb" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_${termek.id}">Részletek</button>
                                    <button type="submit" disabled id="termekekKartyaGomb" name="add_to_cart" class="btn btn-primary" onclick="Szamlalo()">Kosárba</button>
                                </form>
                            </div>
                        </div>
                    </div>
    
                    <!-- Modal -->
                    <div class="modal fade" id="modal_${termek.id}" tabindex="-1" aria-labelledby="modalLabel_${termek.id}" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
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
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                } else if (termek.elerheto_darab > 0) {
                    document.getElementById("valaszSzoveg").innerHTML = ""
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
                                    <button type="submit" id="termekekKartyaGomb" name="add_to_cart" class="btn btn-primary" onclick="Szamlalo()">Kosárba</button>
                                </form>
                            </div>
                        </div>
                    </div>

    
                    <!-- Modal -->
                    <div class="modal fade" id="modal_${termek.id}" tabindex="-1" aria-labelledby="modalLabel_${termek.id}" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
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
                                        <button type="submit" id="termekekKartyaGomb" name="add_to_cart" class="btn btn-primary" onclick="Szamlalo()">Kosárba</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                }
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
            'maxRangeAr': 9999999999999,
            'kereses': '',
            'rendez': 'nevAz'
        };

        let eredmeny = await fetch('./termekek_adatok.php/szures', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(bodyAdatok)
        });

        let termekek = await eredmeny.json();

        let termekekTartalom = document.getElementById("termekekTartalom");
        termekekTartalom.innerHTML = "";

        
        if (termekek.length === 0) {
            termekekTartalom.innerHTML = "Nincs termék a szűrőfeltételeknek megfelelően!";
        } else {
            for (let termek of termekek) {
                // Ellenőrizzük, hogy a termék nem tartalmaz-e hibás adatokat (NaN, undefined)
                if (isNaN(termek.egysegar) || termek.egysegar === undefined || termek.nev === undefined) {
                    document.getElementById("valaszSzoveg").innerHTML = "Nincs termék a szűrőfeltételeknek megfelelően!";
                    continue; // Ha hibás adat, akkor nem jelenítjük meg

                }

                if (termek.elerheto_darab == 0) {
                    termekekTartalom.innerHTML += `
                    <div class="col-md-4 col-sm-6 col-xs-12 mb-4">
                        <div class="card shadow">
                            <div id="termekekKartyaKepKozep">
                                <img id="termekekKartyaKep" src="${termek.kep}" class="card-img-top" alt="${termek.t_nev}">
                            </div>
                            <div class="card-body">
                                <h6 class="card-title">${termek.nev}</h6>
                                <h6><strong> <span style="color: red">A termék nincs készleten!<span></strong></h6>
                                <form method="POST" action="kosar_muveletek.php">
                                    <input type="hidden" name="termek_id" value="${termek.id}">
                                    <input type="hidden" name="termek_kep" value="${termek.kep}">
                                    <input type="hidden" name="ar" value="${termek.egysegar}">
                                    <input type="hidden" name="mennyiseg" value="1">
                                    <button type="button" id="termekekKartyaGomb" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal_${termek.id}">Részletek</button>
                                    <button type="submit" disabled id="termekekKartyaGomb" name="add_to_cart" class="btn btn-primary" onclick="Szamlalo()">Kosárba</button>
                                </form>
                            </div>
                        </div>
                    </div>
    
                    <!-- Modal -->
                    <div class="modal fade" id="modal_${termek.id}" tabindex="-1" aria-labelledby="modalLabel_${termek.id}" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
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
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                } else if (termek.elerheto_darab > 0) {
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
                                    <button type="submit" id="termekekKartyaGomb" name="add_to_cart" class="btn btn-primary" onclick="Szamlalo()">Kosárba</button>
                                </form>
                            </div>
                        </div>
                    </div>


                    <!-- Modal -->
                    <div class="modal fade" id="modal_${termek.id}" tabindex="-1" aria-labelledby="modalLabel_${termek.id}" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalLabel_${termek.id}">${termek.nev}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="container">
                                        <!-- Első sor -->
                                        <div class="row">
                                            <div class="col-md-6 text-white">
                                                <img src="${termek.kep}" alt="${termek.nev}" class="img-fluid mb-3" style="width: 65%">
                                            </div>
                                            <div class="col-md-6">
                                                <h3><strong>Ár: ${parseInt(termek.egysegar).toLocaleString()} Ft</strong></h3>
                                                <h4><strong>Gyártó:</strong> ${termek.gyarto}</h4>
                                                <h4><strong>Kategória:</strong> ${termek.kategoria_nev}</h4>
                                            </div>
                                        </div>
                                        <!-- Második sor -->
                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <p>${termek.leiras}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="modalKartyaGomb" class="btn btn-secondary" data-bs-dismiss="modal">Bezár</button>
                                    <form method="POST" action="kosar_muveletek.php">
                                        <input type="hidden" name="termek_id" value="${termek.t_id}">
                                        <input type="hidden" name="termek_kep" value="${termek.kep}">
                                        <input type="hidden" name="ar" value="${termek.egysegar}">
                                        <input type="hidden" name="mennyiseg" value="1">
                                        <button type="submit" id="termekekKartyaGomb" name="add_to_cart" class="btn btn-primary" onclick="Szamlalo()">Kosárba</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    
                `;
                }
            }
        }
    } catch (error) {
        console.error("Hiba történt a termékek betöltésekor:", error);
    }
}

window.addEventListener("load", kategoriakLeker);
window.addEventListener("load", gyartokLeker);
window.addEventListener("load", arakLeker);
window.addEventListener("load", osszesTermekekLeker)
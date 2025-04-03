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
    document.getElementById("hibaKepDiv").style.display = "none";
    try {
        let kategoria = document.getElementById("kategoriaSzures").value;
        let gyarto = document.getElementById("gyartoSzures").value;
        let minRangeAr = document.getElementById("minRangeAr").value;
        let maxRangeAr = document.getElementById("maxRangeAr").value;
        let kereses = document.getElementById("keresesSzures").value;
        let rendez = document.getElementById("rendez").value;

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
            document.getElementById("hibaKepDiv").style.display = "block";
        } else {
            for (let termek of termekek) {
                // Ellenőrizzük, hogy a termék nem tartalmaz-e hibás adatokat (NaN, undefined)
                if (isNaN(termek.egysegar) || termek.egysegar === undefined || termek.nev === undefined) {
                    document.getElementById("valaszSzoveg").innerHTML = "Nincs termék a szűrőfeltételeknek megfelelően!";
                    document.getElementById("hibaKepDiv").style.display = "block";
                    continue; // Ha hibás adat, akkor nem jelenítjük meg

                }

                document.getElementById("valaszSzoveg").innerHTML = ""

                let kartyaArszoveg;
                let akcioSzazalek;
                /*let akcioIdo;

                const date_kezd = new Date(termek.akcio_kezdete);
                const date_vege = new Date(termek.akcio_vege);

                let kezdIdoHonap = date_kezd.getMonth() + 1;
                let kezdIdoNap = date_kezd.getDate();
                let VegeIdoHonap = date_vege.getMonth() + 1;
                let VegeIdoNap = date_vege.getDate();

                let akcioKezd = `${String(kezdIdoHonap).padStart(2, '0')}.${String(kezdIdoNap).padStart(2, '0')}`;
                let akcioVege = `${String(VegeIdoHonap).padStart(2, '0')}.${String(VegeIdoNap).padStart(2, '0')}`;*/
                

                if(termek.elerheto_darab == 0){
                    kartyaArszoveg = `<span style="color: red">A termék nincs készleten!</span>`;
                }else if(termek.elerheto_darab != 0){
                    kartyaArszoveg = `${parseInt(termek.egysegar).toLocaleString()} Ft`;
                }
                
                if(termek.akcios_ar != null && termek.elerheto_darab != 0){
                    kartyaArszoveg = `<span style="text-decoration:line-through;color:gray;font-style:italic;margin-right:5px">${parseInt(termek.egysegar).toLocaleString()} Ft </span><span style="color:red;font-weight:bold"> ${parseInt(termek.akcios_ar).toLocaleString()} Ft</span>`;
                    let akcio = Math.floor(Math.abs((termek.akcios_ar / termek.egysegar * 100)));
                    let akcioRendes = 100 - akcio;
                    akcioSzazalek = `<span style="position:absolute;left:20px;top:15px;color:white;background-color:red;border-radius:50%;font-size:25px" class="badge badge-secondary">-${akcioRendes}%</span>`;
                    //akcioIdo = `<span style="color:red;margin-left:10px">${akcioKezd} - ${akcioVege}</span>`;
                }else{
                    akcioSzazalek = "";
                    //akcioIdo = "";
                }

                termekekTartalom.innerHTML += 
                `
                    <div class="col-md-4 col-sm-6 col-xs-12 mb-4">
                        <div class="card shadow">
                            <div id="termekekKartyaKepKozep">
                                <img id="termekekKartyaKep" src="${termek.kep}" class="card-img-top" alt="${termek.t_nev}">${akcioSzazalek}
                            </div>
                            <div class="card-body">
                                <h6 class="card-title">${termek.nev}</h6>
                                <h6><strong>${kartyaArszoveg} </strong></h6>
                                <form method="POST" action="kosar_muveletek.php">
                                    <input type="hidden" name="termek_id" value="${termek.id}">
                                    <input type="hidden" name="termek_kep" value="${termek.kep}">
                                    <input type="hidden" name="ar" value="${termek.egysegar}">
                                    <input type="hidden" name="mennyiseg" value="1">
                                    <button type="button" id="termekekKartyaGomb" class="btn btn-primary w-100 my-1" onclick="termekMegnyit('${termek.urlnev}')">Részletek</button>
                                    <button type="submit" ${(termek.elerheto_darab == 0) ? `disabled` : ``} id="termekekKartyaKosarGomb" name="add_to_cart" class="btn btn-primary w-100 my-1" onclick="Szamlalo()">Kosárba</button>
                                </form>
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
    document.getElementById("hibaKepDiv").style.display = "none";
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
            document.getElementById("hibaKepDiv").style.display = "block";
        } else {
            for (let termek of termekek) {
                // Ellenőrizzük, hogy a termék nem tartalmaz-e hibás adatokat (NaN, undefined)
                if (isNaN(termek.egysegar) || termek.egysegar === undefined || termek.nev === undefined) {
                    document.getElementById("valaszSzoveg").innerHTML = "Nincs termék a szűrőfeltételeknek megfelelően!";
                    document.getElementById("hibaKepDiv").style.display = "block";
                    continue; // Ha hibás adat, akkor nem jelenítjük meg

                }

                let kartyaArszoveg;
                let akcioSzazalek;
                /*let akcioIdo;

                const date_kezd = new Date(termek.akcio_kezdete);
                const date_vege = new Date(termek.akcio_vege);

                let kezdIdoHonap = date_kezd.getMonth() + 1;
                let kezdIdoNap = date_kezd.getDate();
                let VegeIdoHonap = date_vege.getMonth() + 1;
                let VegeIdoNap = date_vege.getDate();

                let akcioKezd = `${String(kezdIdoHonap).padStart(2, '0')}.${String(kezdIdoNap).padStart(2, '0')}`;
                let akcioVege = `${String(VegeIdoHonap).padStart(2, '0')}.${String(VegeIdoNap).padStart(2, '0')}`;*/
                

                if(termek.elerheto_darab == 0){
                    kartyaArszoveg = `<span style="color: red">A termék nincs készleten!</span>`;
                }else if(termek.elerheto_darab != 0){
                    kartyaArszoveg = `${parseInt(termek.egysegar).toLocaleString()} Ft`;
                }
                
                if(termek.akcios_ar != null && termek.elerheto_darab != 0){
                    kartyaArszoveg = `<span style="text-decoration:line-through;color:gray;font-style:italic;margin-right:5px">${parseInt(termek.egysegar).toLocaleString()} Ft </span><span style="color:red;font-weight:bold"> ${parseInt(termek.akcios_ar).toLocaleString()} Ft</span>`;
                    let akcio = Math.floor(Math.abs((termek.akcios_ar / termek.egysegar * 100)));
                    let akcioRendes = 100 - akcio;
                    akcioSzazalek = `<span style="position:absolute;left:20px;top:15px;color:white;background-color:red;border-radius:50%;font-size:25px" class="badge badge-secondary">-${akcioRendes}%</span>`;
                    //akcioIdo = `<span style="color:red;margin-left:10px">${akcioKezd} - ${akcioVege}</span>`;
                }else{
                    akcioSzazalek = "";
                    //akcioIdo = "";
                }

                termekekTartalom.innerHTML += 
                `
                    <div class="col-md-4 col-sm-6 col-xs-12 mb-4">
                        <div class="card shadow">
                            <div id="termekekKartyaKepKozep">
                                <img id="termekekKartyaKep" src="${termek.kep}" class="card-img-top" alt="${termek.t_nev}">${akcioSzazalek}
                            </div>
                            <div class="card-body">
                                <h6 class="card-title">${termek.nev}</h6>
                                <h6><strong>${kartyaArszoveg} </strong></h6>
                                <form method="POST" action="kosar_muveletek.php">
                                    <input type="hidden" name="termek_id" value="${termek.id}">
                                    <input type="hidden" name="termek_kep" value="${termek.kep}">
                                    <input type="hidden" name="ar" value="${termek.egysegar}">
                                    <input type="hidden" name="mennyiseg" value="1">
                                    <button type="button" id="termekekKartyaGomb" class="btn btn-primary w-100 my-1" onclick="termekMegnyit('${termek.urlnev}')">Részletek</button>
                                    <button type="submit" ${(termek.elerheto_darab == 0) ? `disabled` : ``} id="termekekKartyaKosarGomb" name="add_to_cart" class="btn btn-primary w-100 my-1" onclick="Szamlalo()">Kosárba</button>
                                </form>
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

function termekMegnyit(urlnev){
    window.location.href = `termek_reszletek?termek=${urlnev}`;
}

window.addEventListener("load", kategoriakLeker);
window.addEventListener("load", gyartokLeker);
window.addEventListener("load", arakLeker);
window.addEventListener("load", osszesTermekekLeker)
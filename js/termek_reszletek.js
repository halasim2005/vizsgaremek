async function termek_reszletei() {
    let urlParams = new URLSearchParams(window.location.search);
    let urlnev = urlParams.get('termek');
    
    let adatok = await fetch("./termekek_adatok.php/termek_url", {
        method : "POST",
        headers : {
            "Content-Type" : "application/json"
        },
        body : JSON.stringify({
            "urlnev" : urlnev,
        })
    })
    let termek_reszletei = await adatok.json();

    for (let adat of termek_reszletei) {
        let raktaronSzoveg;
        let raktaronStyle;
        let akcioSzazalek;
        let akciosAr;

        if(adat.akcios_ar != null && adat.elerheto_darab != 0){
            let akcio = Math.floor(Math.abs((adat.akcios_ar / adat.egysegar * 100)));
            let akcioRendes = 100 - akcio;
            akcioSzazalek = `<h4 style="color:red;font-weight:bold">-${akcioRendes}%-os AKCIÓ!</h4>`;
            akciosAr = `<span style="font-weight:bold">Ár:</span> <span style="text-decoration:line-through;color:gray;font-style:italic;margin-right:5px">${parseInt(adat.egysegar).toLocaleString()} Ft</span><span style="color:red;font-weight:bold">${parseInt(adat.akcios_ar).toLocaleString()} Ft</span>`;
        }else{
            akcioSzazalek = "";
            akciosAr = `<span style="font-weight:bold">Ár:</span> <span>${parseInt(adat.egysegar).toLocaleString()} Ft</span>`;
        }

        if(adat.elerheto_darab > 0){
            raktaronSzoveg = adat.elerheto_darab + " db";
            raktaronStyle = `style="color:green;font-weight:bold"`;
        }else{
            raktaronSzoveg = `Nincs a készleten!`;
            raktaronStyle = `style="color:red;font-weight:bold"`;
        }

        document.getElementById("reszletek").innerHTML = 
        `
            <div class="row">
                <div class="col-12">
                    <h4>${adat.nev}</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-12 p-3">
                    ${akcioSzazalek}
                    <img width="230px" src="${adat.kep}">
                </div>
                <div class="col-md-8 col-12 p-3">
                    <h5><span style="font-weight:bold">Gyártó:</span> ${adat.gyarto}</h5>
                    <h5><span style="font-weight:bold">Típus:</span> ${adat.tipus}</h5>
                    <h5><span style="font-weight:bold">Raktáron:</span> <span ${raktaronStyle}>${raktaronSzoveg}</h5>
                    <h5>${akciosAr}</h5>
                    <form method="POST" action="kosar_muveletek.php">
                        <input type="hidden" name="termek_id" value="${adat.id}">
                        <input type="hidden" name="termek_kep" value="${adat.kep}">
                        <input type="hidden" name="ar" value="${adat.egysegar}">
                        <div class="gap-1 align-items-center w-25">
                            <div class="input-group">
                                <button class="btn btn-secondary mpGomb" type="button" onclick="mennyisegValtoztat(-1, '${adat.elerheto_darab}', 'dbszam_${adat.id}')">−</button>
                                <input type="number" class="form-control w-10 text-center" id="dbszam_${adat.id}" min="1" max="${adat.elerheto_darab}" name="mennyiseg" value="1">
                                <button class="btn btn-secondary mpGomb" type="button" onclick="mennyisegValtoztat(1, '${adat.elerheto_darab}', 'dbszam_${adat.id}')">+</button>
                            </div>
                            <button type="submit" ${(adat.elerheto_darab == 0) ? `disabled` : ``} id="termekekKartyaKosarGomb" name="add_to_cart" class="btn btn-primary w-100 my-1" onclick="Szamlalo()">Kosárba</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row mb-5">
                <div class="col-12 p-3">
                    <h5>${adat.leiras}</h5>
                </div>
            </div>
        `
    }
}

function mennyisegValtoztat(valtozas, maxErtek, inputId) {
    const input = document.getElementById(inputId);
    let aktualis = parseInt(input.value) || 1;
    let ujErtek = aktualis + valtozas;

    if (ujErtek < 1) ujErtek = 1;
    if (ujErtek > maxErtek) ujErtek = maxErtek;

    input.value = ujErtek;
}

window.addEventListener("load", termek_reszletei);
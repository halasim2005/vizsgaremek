async function termek_reszletei() {
    let urlParameterek = new URLSearchParams(window.location.search);
    let termekId = urlParameterek.get("id");
    
    let adatok = await fetch("./termekek_adatok.php/termek", {
        method : "POST",
        headers : {
            "Content-Type" : "application/json"
        },
        body : JSON.stringify({
            "id" : termekId,
        })
    })
    let termek_reszletei = await adatok.json();

    for (let adat of termek_reszletei) {
        let raktaronSzoveg;
        let raktaronStyle;
        let akcioSzazalek;
        let akciosAr;
        let akcioIdo;

        const date_kezd = new Date(adat.akcio_kezdete);
        const date_vege = new Date(adat.akcio_vege);

        let kezdIdoHonap = date_kezd.getMonth() + 1;
        let kezdIdoNap = date_kezd.getDate();
        let VegeIdoHonap = date_vege.getMonth() + 1;
        let VegeIdoNap = date_vege.getDate();

        let akcioKezd = `${String(kezdIdoHonap).padStart(2, '0')}.${String(kezdIdoNap).padStart(2, '0')}`;
        let akcioVege = `${String(VegeIdoHonap).padStart(2, '0')}.${String(VegeIdoNap).padStart(2, '0')}`;

        if(adat.akcios_ar != null && adat.elerheto_darab != 0){
            let akcio = Math.floor(Math.abs((adat.akcios_ar / adat.egysegar * 100)));
            let akcioRendes = 100 - akcio;
            akcioSzazalek = `<h4 style="color:red;font-weight:bold">-${akcioRendes}%-os AKCIÓ!</h4>`;
            akciosAr = `<span style="font-weight:bold">Ár:</span> <span style="text-decoration:line-through;color:gray;font-style:italic;margin-right:5px">${parseInt(adat.egysegar).toLocaleString()} Ft</span><span style="color:red;font-weight:bold">${parseInt(adat.akcios_ar).toLocaleString()} Ft</span>`;
            akcioIdo = `<h5 style="font-weight:bold">Akció időtartama: <span style="color:red">${akcioKezd} - ${akcioVege}</h5></span>`;
        }else{
            akcioSzazalek = "";
            akciosAr = `<span style="font-weight:bold">Ár:</span> <span>${parseInt(adat.egysegar).toLocaleString()} Ft</span>`;
            akcioIdo = "";
        }

        if(adat.elerheto_darab > 0){
            raktaronSzoveg = adat.elerheto_darab;
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
                    <h5><span style="font-weight:bold">Raktáron:</span> <span ${raktaronStyle}>${raktaronSzoveg} db</h5>
                    <h5>${akciosAr}</h5>
                    ${akcioIdo}
                    <form method="POST" action="kosar_muveletek.php">
                        <input type="hidden" name="termek_id" value="${adat.id}">
                        <input type="hidden" name="termek_kep" value="${adat.kep}">
                        <input type="hidden" name="ar" value="${adat.egysegar}">
                        <input type="number" placeholder="Mennyiség" class="form-control w-25 my-1" name="mennyiseg" max="${adat.elerheto_darab}" min="1">
                        <button type="submit" ${(adat.elerheto_darab == 0) ? `disabled` : ``}  id="termekekKartyaKosarGomb" name="add_to_cart" class="btn btn-primary my-1 w-25" onclick="Szamlalo()">Kosárba</button>
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

window.addEventListener("load", termek_reszletei);
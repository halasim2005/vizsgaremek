let rendelesek_ = document.getElementById("rendeles");
let rendelesTable = document.getElementById("rendelesTable");
let rendeles_db = 0;

async function rendelesek() {
    try {
        let adatok = await fetch("./rendeles_kovetes_fetch.php/rendelesek");
        let eredmeny = await adatok.json();
        let FetchStatus = adatok.status;
        print_(eredmeny, FetchStatus);
    } catch (error) {
        console.log(error);
    }    
}

function print_(eredmeny, FetchStatus){
    rendeles_db = 0;
    let hibauzenet = document.getElementById("hibauzenet");
    let inputStyle = `border:none;accent-color:rgb(91, 91, 91);background-color:rgb(91, 91, 91);height:20px;-webkit-appearance:none;appearance:none;`;

    if(FetchStatus == 400){
        rendelesTable.innerHTML = "";
        hibauzenet.innerHTML += 
        `
        <div class="text-center">
            Nincsen jelenleg rendelése!<br>
            <img width="300" src="./képek/HaLálip.png" alt="HaLáli Kft. logo"> 
        </div>
        `;
    }else{
        rendelesTable.innerHTML = "";
        rendelesTable.innerHTML = 
        `
            <div class="cell m-1"><img width="50" class="mb-2" src="./képek/feldolgoz.png"><br>Feldolgozás alatt<br><input type="range" class="form-control mt-3" style="${inputStyle}"></div>
            <div class="cell m-1"><img width="50" class="mb-2" src="./képek/csomagolva.png"><br>Csomagolva<br><input type="range" class="form-control mt-3" style="${inputStyle}"></div>
            <div class="cell m-1"><img width="50" class="mb-2" src="./képek/futar.png"><br>Futárnak átadva<br><input type="range" class="form-control mt-3" style="${inputStyle}"></div>
        `;

        for (let elem of eredmeny) {
            let statuszStyle = "";
            let statuszSzoveg = "";
            let trStyle = "style='text-align:left'";
            let oszlopStyle = "style='padding:6px'";
            let oszlopStyleTd = "style='padding:6px'";
            let buttonStyle = "style='border:none;background-color:transparent;width: 20rem'";

            if(elem.statusz == "feldolgozás alatt"){
                statuszStyle = "style='background-color:#ccddff";
                statuszSzoveg= "feldolgozás alatt";
            }else if(elem.statusz == "csomagolva"){
                statuszStyle = "style='background-color:#ffecb3";
                statuszSzoveg= "csomagolva";
            }else{
                statuszStyle = "style='background-color:#ccffcc";
                statuszSzoveg= "futárnak átadva";
            }

            rendelesek_.innerHTML += 
            `
                <button title="Rendelés részletek" ${buttonStyle} onclick="rendeles_allapot('${elem.id}', '${elem.statusz}')">
                    <div class="col-md-3">
                        <div class='card my-2' ${statuszStyle};width: 18rem;font-family:Montserrat'>
                            <div class='card-body'>
                                <table ${trStyle}>
                                    <tr>
                                        <td ${oszlopStyle}>Azonosító:</td>
                                        <th ${oszlopStyleTd}>${elem.id}</th>
                                    </tr>
                                    <tr>
                                        <td ${oszlopStyle}>Dátum:</td>
                                        <th ${oszlopStyleTd}>${elem.leadas_datum}</th>
                                    </tr>
                                    <tr>
                                        <td ${oszlopStyle}>Végösszeg:</td>
                                        <th ${oszlopStyleTd}>${elem.vegosszeg} Ft</th>
                                    </tr>
                                    <tr>
                                        <td ${oszlopStyle}>Állapot:</td>
                                        <th ${oszlopStyleTd}>${statuszSzoveg}</th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </button>
            `;

            rendeles_db++;
        }

        document.getElementById("rendelesCount").innerHTML = `Rendeléseim (${rendeles_db})`;
    }
}

function rendeles_allapot(rend_id, allapot){
    let rendeles_table = document.getElementById("rendelesTable");
    rendeles_table.innerHTML = "";
    let allapotStyle_feldolgoz;
    let allapotStyle_csom;
    let allapotStyle_futar;
    let colorStyle_feldolgoz;
    let colorStyle_csom;
    let colorStyle_futar;

    if(allapot == "feldolgozás alatt"){
        allapotStyle_feldolgoz = `border:none;accent-color:green;background-color:green;height:20px;-webkit-appearance:none;appearance:none;`;
        allapotStyle_csom = `border:none;accent-color:orange;background-color:orange;height:20px;-webkit-appearance:none;appearance:none;`;
        allapotStyle_futar = `border:none;accent-color:rgb(91, 91, 91);background-color:rgb(91, 91, 91);height:20px;-webkit-appearance:none;appearance:none;`;
        colorStyle_feldolgoz = `style="color:green;font-weight:bold"`;
        colorStyle_csom = `style="color:orange;font-weight:bold"`;
        colorStyle_futar = `style="color:rgb(91, 91, 91);font-weight:bold"`;
    }else if(allapot == "csomagolva"){
        allapotStyle_feldolgoz = `border:none;accent-color:green;background-color:green;height:20px;-webkit-appearance:none;appearance:none;`;
        allapotStyle_csom = `border:none;accent-color:green;background-color:green;height:20px;-webkit-appearance:none;appearance:none;`;
        allapotStyle_futar = `border:none;accent-color:orange;background-color:orange;height:20px;-webkit-appearance:none;appearance:none;`;
        colorStyle_feldolgoz = `style="color:green;font-weight:bold"`;
        colorStyle_csom = `style="color:green;font-weight:bold"`;
        colorStyle_futar = `style="color:orange;font-weight:bold"`;
    }else{
        allapotStyle_feldolgoz = `border:none;accent-color:green;background-color:green;height:20px;-webkit-appearance:none;appearance:none;`;
        allapotStyle_csom = `border:none;accent-color:green;background-color:green;height:20px;-webkit-appearance:none;appearance:none;`;
        allapotStyle_futar = `border:none;accent-color:green;background-color:green;height:20px;-webkit-appearance:none;appearance:none;`;
        colorStyle_feldolgoz = `style="color:green;font-weight:bold"`;
        colorStyle_csom = `style="color:green;font-weight:bold"`;
        colorStyle_futar = `style="color:green;font-weight:bold"`;
    }

    rendeles_table.innerHTML = 
    `
        <div class="cell m-1"><img width="50" class="mb-2" src="./képek/feldolgoz.png"><br><span ${colorStyle_feldolgoz}>Feldolgozás alatt</span><br><input type="range" class="form-control mt-3" style="${allapotStyle_feldolgoz}"></div>
        <div class="cell m-1"><img width="50" class="mb-2" src="./képek/csomagolva.png"><br><span ${colorStyle_csom}>Csomagolva</span><br><input type="range" class="form-control mt-3" style="${allapotStyle_csom}"></div>
        <div class="cell m-1"><img width="50" class="mb-2" src="./képek/futar.png"><br><span ${colorStyle_futar}>Futárnak átadva</span><br><input type="range" class="form-control mt-3" style="${allapotStyle_futar}"></div>
    `;

    document.getElementById("rendelesCount").innerHTML = 
    `
        Rendeléseim (${rendeles_db}) <strong>Rendelés azonosító: ${rend_id}</strong>
        <button id="rendelesReszletekBtn" onclick="rendeles_reszletek('${allapot}', '${rend_id}')">
            Részletek
        </button>
        <button id="rendelesReszletekBtn" onclick="vissza()">
            Vissza
        </button>
    `;
}

async function rendeles_reszletek(rendeles_statusz, rendeles_id) {
    try {
        let adatok_2 = await fetch(`./rendeles_kovetes_fetch.php/rendeles_reszletek`, {
            method : "POST",
            headers : {
                "Content-Type" : "application/json"
            },
            body : JSON.stringify({
                "id" : rendeles_id,
                "statusz" : rendeles_statusz
            })
        })
        let rendReszletek = await adatok_2.json();
        Rendeles_adatok_megjelenit(rendReszletek);
    } catch (error) {
        console.log(error);
    }
}

function Rendeles_adatok_megjelenit(rendReszletek){
    rendelesek_.innerHTML = `<h5 class="my-3">Rendelés tételei:</h5>`;
    rendelesek_.innerHTML += 
    `
        <table class="table m-4">
            <thead>
                <tr>
                    <th>Kép</th>
                    <th>Név</th>
                    <th>Mennyiség</th>
                    <th>Ár</th>
                    <th>Összesen</th>
                </tr>
            </thead>
            <tbody id="tbody">
            
            </tbody>
        </table>
    `;
    for (let termek of rendReszletek) {
        document.getElementById("tbody").innerHTML += 
        `
                <tr>
                    <th><img style="width:20%" src="${termek.kep}"></th>
                    <td style="vertical-align:middle">${termek.nev}</td>
                    <td style="vertical-align:middle">${termek.tetelek_mennyiseg} db</td>
                    <td style="vertical-align:middle">${termek.egysegar} Ft</td>
                    <td style="vertical-align:middle">${termek.tetelek_mennyiseg * termek.egysegar} Ft</td>
                </tr>
        `;
    }

    rendelesek_.innerHTML += `<h5 class="my-3">Rendelés adatai: </h5>`;

    rendelesek_.innerHTML += 
    `
        <table class="table">
            <thead>
                <th>Státusz</th>
                <th>Leadás dátuma</th>
                <th>Szállítási mód</th>
                <th>Fizetési mód</th>
                <th>Szállítás</th>
                <th>Végösszeg</th>
            </thead>
            <tbody id="adatokTbody">

            </tbody>
        </table>
    `;

    let adatokTbody = document.getElementById("adatokTbody");

    for (let adat of rendReszletek) {
        let td_style;
        let fizmod;

        if(adat.fizetesi_mod == "utanvet"){
            fizmod = "utánvét"
        }else{
            fizmod = "kártya"
        }

        if(adat.statusz == "csomagolva"){
            td_style = `style="color:orange;font-weight:bold"`;
        }else if(adat.statusz == "kész"){
            td_style = `style="color:green;font-weight:bold"`;
            adat.statusz = "futárnak átadva"
        }else{
            td_style = `style="color:gray;font-weight:bold"`;
        }
        adatokTbody.innerHTML = 
        `
            <tr>
                <td ${td_style}>${adat.statusz}</td>
                <td>${adat.leadas_datum} </td>
                <td>${adat.szallitasi_mod} </td>
                <td>${fizmod} </td>
                <th>${(adat.vegosszeg > 25000) ? "ingyenes" : "1690 Ft"}</th>
                <td>${adat.vegosszeg} Ft</td>
            </tr>
        `;
    }
}

function vissza(){
    rendelesek_.innerHTML = "";
    rendelesek();
}

window.addEventListener("load", rendelesek);

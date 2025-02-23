let rendelesek_ = document.getElementById("rendeles");
let rendelesTable = document.getElementById("rendelesTable");

async function rendelesek() {
    try {
        let adatok = await fetch("./rendeles_kovetes_fetch.php/rendelesek");
        let eredmeny = await adatok.json();
        print_(eredmeny);
    } catch (error) {
        console.log(error);
    }    
}

function print_(eredmeny){
    let rendeles_db = 0;
    let inputStyle = `border:none;accent-color:rgb(91, 91, 91);background-color:rgb(91, 91, 91);height:20px;-webkit-appearance:none;appearance:none;`;

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
            <button title="Rendelés részletek" ${buttonStyle} onclick="rendeles_allapot('${elem.statusz}')">
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

function rendeles_allapot(allapot){
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
}

window.addEventListener("load", rendelesek);

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
    let inputStyle = `accent-color:rgb(91, 91, 91);background-color:rgb(91, 91, 91);height:20px;-webkit-appearance:none;appearance:none;`;

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

function rendeles_allapot(rendeles_id, allapot){
    console.log(1);
    
    rendelesTable.innerHTML = "";
    console.log(1);
    
}

window.addEventListener("load", rendelesek);

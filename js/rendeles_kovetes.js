let rendelesek_ = document.getElementById("rendeles");

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
    for (let elem of eredmeny) {
        let statuszStyle = "";
        let statuszSzoveg = "";

        if(elem.statusz == "feldolgozás alatt"){
            statuszStyle = "style='color:blue'";
            statuszSzoveg= "feldolgozás alatt";
        }else if(elem.statusz == "csomagolva"){
            statuszStyle = "style='color:orange'";
            statuszSzoveg= "csomagolva";
        }else{
            statuszStyle = "style='color:green'";
            statuszSzoveg= "futárnak átadva";
        }

        rendelesek_.innerHTML += 
        `
            <div class="col-md-3">
                <div class='card border m-2' style='width: 18rem'>
                    <div class='card-body'>
                        <table class='table'>
                            <tr>
                                <td>Azonosító:</td>
                                <th>${elem.id}</th>
                            </tr>
                            <tr>
                                <td>Dátum:</td>
                                <th>${elem.leadas_datum}</th>
                            </tr>
                            <tr>
                                <td>Végösszeg:</td>
                                <th>${elem.vegosszeg} Ft</th>
                            </tr>
                            <tr>
                                <td>Állapot:</td>
                                <th ${statuszStyle}>${statuszSzoveg}</th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        `;
    }
}

window.addEventListener("load", rendelesek);

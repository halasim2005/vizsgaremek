function OldalBetolt(){
    document.getElementById("feszesesDiv").style.display = "block";
    document.getElementById("arDiv").style.display = "none";
    document.getElementById("ellenDiv").style.display = "none";
}

function kalkValaszt(){
    let selected = document.querySelector('input[name=kalkulatorRadios]:checked');

    if(selected.value === "feszeses"){
        document.getElementById("feszesesDiv").style.display = "block";
        document.getElementById("arDiv").style.display = "none";
        document.getElementById("ellenDiv").style.display = "none";
    }else if(selected.value === "ellenallas"){
        document.getElementById("feszesesDiv").style.display = "none";
        document.getElementById("arDiv").style.display = "none";
        document.getElementById("ellenDiv").style.display = "block";
    }
}

function Szamolas(){
    let eredmenyModal = document.getElementById("eredmenyModal");
    let A = document.getElementById("vezKereszt").value; //keresztmetszet
    let I = document.getElementById("aram").value; //áramerősség
    let L = document.getElementById("vezHossz").value; //vezeték hossz
    let Z = 0; //impedancia
    let egyFazisRadio = document.getElementById("230");
    let haromFazisRadio = document.getElementById("400");
    let feszEses = 0; //feszültség esés értéke
    let szazalek = 0;
    let hiba = document.getElementById("hiba");

    if((L == "") || (I == "") || (egyFazisRadio.checked == false && haromFazisRadio.checked == false)){
        hiba.innerHTML = '<div class="alert alert-warning">Kérem jelöljön be és töltsön ki minden mezőt!</div>';
    }else{
        if((L == 0 || L < 0) || (I == 0 || I < 0)){
            hiba.innerHTML = '<div class="alert alert-warning">Kérem pozitív értékeket írjon a beviteli mezőkbe!</div>';
        }else{
            if(egyFazisRadio.checked == true){
                if(A == 1){
                    Z = 25.8;
                }
                else if(A == 1.5){
                    Z = 16.5;
                }
                else if(A == 2.5){
                    Z = 9.011;
                }
                else if(A == 4){
                    Z = 5.611;
                }
                else if(A == 6){
                    Z = 3.751;
                }
                else if(A == 10){
                    Z = 2.232;
                }
                else if(A == 16){
                    Z = 1.403;
                }
                else if(A == 25){
                    Z = 0.888;
                }
                else if(A == 35){
                    Z = 0.643;
                }
    
                feszEses = (I * L * 2 * Z)/1000;
                szazalek = (feszEses / 230)*100;
            }
            else if(haromFazisRadio.checked == true){
                if(A == 1){
                    Z = 25.8;
                }
                else if(A == 1.5){
                    Z = 16.5;
                }
                else if(A == 2.5){
                    Z = 9.011;
                }
                else if(A == 4){
                    Z = 5.611;
                }
                else if(A == 6){
                    Z = 3.751;
                }
                else if(A == 10){
                    Z = 2.232;
                }
                else if(A == 16){
                    Z = 1.403;
                }
                else if(A == 25){
                    Z = 0.888;
                }
                else if(A == 35){
                    Z = 0.643;
                }
    
                feszEses = (I * L * Math.sqrt(3) * Z)/1000;
                szazalek = (feszEses / 400)*100;
            }
    
            document.getElementById("eredmeny").innerHTML = Math.floor(feszEses * 100)/100 + "V <br>";
            document.getElementById("eredmeny").innerHTML += Math.floor(szazalek * 100)/100 + "% <br>";
    
            if(szazalek < 3){
                document.getElementById("eredmeny").style.color = "green";
                document.getElementById("eredmeny").style.fontWeight = "900";
            }
            else if(szazalek > 3 && szazalek < 7){
                document.getElementById("eredmeny").style.color = "orange";
                document.getElementById("eredmeny").style.fontWeight = "900";
            }         
            else if(szazalek > 7){
                document.getElementById("eredmeny").style.color = "red";
                document.getElementById("eredmeny").style.fontWeight = "900";
            }
            hiba.innerHTML = "";           
        }
    }
}   

function ellenallas_szamolas(){
    let V = document.getElementById("feszultseg").value; //feszultseg
    let I = document.getElementById("aram_ellenallas").value; //áramerősség
    let ellenallas = 0; //ellenállás értéke
    let hiba = document.getElementById("hiba_ellenallas");

    if(V == "" || I == ""){
        hiba.innerHTML = '<div class="alert alert-warning">Kérem töltse ki az összes mezőt!</div>';
    }else{
        ellenallas = V / I;
        document.getElementById("eredmeny_ellenallas").innerHTML = ellenallas + "Ω";
        document.getElementById("eredmeny_ellenallas").style.color = "green";
        document.getElementById("eredmeny_ellenallas").style.fontSize = "30px"
        document.getElementById("eredmeny_ellenallas").style.fontWeight = "bold"
    }
}


document.getElementById("szamitas").addEventListener("click", Szamolas)
document.getElementById("szamitas_ellenallas").addEventListener("click", ellenallas_szamolas)
window.addEventListener("change", kalkValaszt)
window.addEventListener("load", OldalBetolt)
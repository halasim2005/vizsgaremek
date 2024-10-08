function Szamolas(){

    let A = document.getElementById("vezKereszt").value; //keresztmetszet

    if(A != 1 && A != 1.5 && A != 2.5 && A != 4 && A != 6 && A != 10 && A != 16 && A != 25 && A != 35 ){
        alert("Kérem a felsorolt keresztmetszetek közül válasszon!")
    }else{
        let I = document.getElementById("aram").value; //áramerősség
        let L = document.getElementById("vezHossz").value; //vezeték hossz
        let Z = 0; //impedancia
        let egyFazisRadio = document.getElementById("230");
        let haromFazisRadio = document.getElementById("400");
        let feszEses = 0; //feszültség esés értéke
        let szazalek = 0;

       
    
        if(egyFazisRadio.checked == true){
             ///////////////////////////////////////////////
        //Impedancia számítások keresztmetszet alapján
        if(A = 1){
            Z = 25.8;
        }
        else if(A = 1.5){
            Z = 16.5;
        }
        else if(A = 2.5){
            Z = 9.011;
        }
        else if(A = 4){
            Z = 5.611;
        }
        else if(A = 6){
            Z = 3.751;
        }
        else if(A = 10){
            Z = 2.232;
        }
        else if(A = 16){
            Z = 1.403;
        }
        else if(A = 25){
            Z = 0.888;
        }
        else if(A = 35){
            Z = 0.643;
        }
            feszEses = (I * L * 2 * Z)/1000;
            szazalek = (feszEses / 230)*100;
        }
    
        if(haromFazisRadio.checked == true){
            if(A = 1){
                Z = 25.8;
            }
            else if(A = 1.5){
                Z = 16.5;
            }
            else if(A = 2.5){
                Z = 9.011;
            }
            else if(A = 4){
                Z = 5.611;
            }
            else if(A = 6){
                Z = 3.751;
            }
            else if(A = 10){
                Z = 2.232;
            }
            else if(A = 16){
                Z = 1.403;
            }
            else if(A = 25){
                Z = 0.888;
            }
            else if(A = 35){
                Z = 0.643;
            }
            feszEses = (I * L * Math.sqrt(3) * Z)/1000;
            szazalek = (feszEses / 400)*100;
        }
        
        document.getElementById("eredmeny").innerHTML = feszEses + "V <br>";
        document.getElementById("eredmeny").innerHTML += szazalek + "% <br>";

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
}
}

document.getElementById("szamitas").addEventListener("click", Szamolas)
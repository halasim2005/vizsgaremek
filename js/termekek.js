async function kategoriakLeker() {
    
    try {
        console.log("teszt");
        let eredmeny = await fetch('./termekek_adatok.php/kategoriakleker');
        let szoveg = await eredmeny.json();
        console.log(szoveg);
        
    } catch (error) {
        console.error(error);
    }
}

window.addEventListener("load", kategoriakLeker);

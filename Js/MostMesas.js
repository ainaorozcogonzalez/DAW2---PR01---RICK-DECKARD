function MostComedor(){
    alert("Mesas Comedor");
}
function MostPrivada(){
    alert("Mesas Privada");
}
function MostTerraza(){
    alert("Mesas Terraza");
}
document.getElementById("Comedor").onclick = MostComedor;
document.getElementById("Privada").onclick = MostPrivada;
document.getElementById("Terraza").onclick = MostTerraza;
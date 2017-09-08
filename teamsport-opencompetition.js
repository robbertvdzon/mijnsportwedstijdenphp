/*************************************************
 *
 **************************************************/

function openTeam(teamID) {
    window.location.href = "index.php?team="+teamID+"&section=competitie";
}

function showProgramma(){
   document.getElementById('programma').style.display = ""; 
   document.getElementById('uitslagen').style.display = "none"; 
   document.getElementById('stand').style.display = "none";
   document.getElementById("progImage").src="images/tab-programma2.png"; 
   document.getElementById("progUitslagen").src="images/tab-uitslagen.png"; 
   document.getElementById("progStand").src="images/tab-stand.png"; 
}

function showUitslagen(){
   document.getElementById('programma').style.display = "none"; 
   document.getElementById('uitslagen').style.display = ""; 
   document.getElementById('stand').style.display = "none"; 
   document.getElementById("progImage").src="images/tab-programma.png"; 
   document.getElementById("progUitslagen").src="images/tab-uitslagen2.png"; 
   document.getElementById("progStand").src="images/tab-stand.png"; 
}

function showStand(){
   document.getElementById('programma').style.display = "none"; 
   document.getElementById('uitslagen').style.display = "none"; 
   document.getElementById('stand').style.display = ""; 
   document.getElementById("progImage").src="images/tab-programma.png"; 
   document.getElementById("progUitslagen").src="images/tab-uitslagen.png"; 
   document.getElementById("progStand").src="images/tab-stand2.png"; 
}


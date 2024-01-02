import { resetLocalValue } from "./localDb.js";
resetLocalValue();

// Player char appearance
const charDisplay = document.getElementById('player-character');
const charLists = document.querySelectorAll('#character-list img');

for (const charList of charLists) {   

   // Detect appearance
   if (localStorage.getItem('current-character') == null) charDisplay.src = 'images/jpg/player-icon-4.jpg';   
   else charDisplay.src = localStorage.getItem('current-character');

   charList.onclick = () => {      
      localStorage.setItem('current-character', charList.getAttribute('src'));
      const src = localStorage.getItem('current-character');
      charDisplay.src = src;      
   }   
   
}

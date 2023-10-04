import { words } from "./word.js";

// Input Initialization
const typer = document.getElementById("typer");

// Sentence Setter
const sentencePart = Math.abs(Math.round(Math.random() * words.length - 1));
const sentenceMain = words[sentencePart];
const sentenceIndex = Math.abs(Math.round(Math.random() * sentenceMain.setter.length - 1));

// Set the new sentence + feature
const word = sentenceMain.setter[sentenceIndex];
const sentenceDuration = sentenceMain.duration;

// Word Initialization
const system = document.getElementById("system-container");
const sentence = document.getElementById("sentence");
sentence.textContent = word;

// Sentence Generator
let elements = sentence.textContent.split("");
for (const element of elements) {
   system.innerHTML += `<span class="system">${element}</span>`;
}
const splitedLetter = document.getElementsByClassName("system");

// Calculation
let typeIndex = 0;
let maxWord = elements.length;

// Sensor
splitedLetter[typeIndex].classList.add("bg-body-secondary", "rounded", "p-2");

// Typing System
let isStarted = true;
let isFulfilled = false;
typer.oninput = (e) => {

   // Start the time after do type
   if (isStarted) {
      updateTime();
      isStarted = false;
   }

   // Identify
   const letter = e.target.value.toLowerCase();
   const currentLetter = elements[typeIndex].toLowerCase();
   typer.value = "";

   // Check
   if (letter == currentLetter) splitedLetter[typeIndex].classList.add("text-success");
   else splitedLetter[typeIndex].classList.add("text-warning");

   splitedLetter[typeIndex].classList.remove(
      "bg-body-secondary",
      "rounded",
      "p-2"
   );

   // Prevent Sentence Input Limit
   if (typeIndex >= maxWord - 1) {
      isFulfilled = true;

      // Confirmation
      const bool = confirm("All is set, do another round?");
      if (bool) {
         location.reload();
      }

      // Make some code for stats showcase here
      seeMyResult();
      return;
   }

   // Auto Sensor
   typeIndex++;
   splitedLetter[typeIndex].classList.add(
      "bg-body-secondary",
      "rounded",
      "p-2"
   );
};

// Avoid Bug
window.onmousemove = () => {
   typer.focus();
};
window.onclick = () => {
   typer.focus();
};

// Timer
const fixedDuration = sentenceDuration;
const timer = document.getElementById("timer");

let duration = fixedDuration;

timer.textContent = `${duration}s`;
const updateTime = () => {
   if (isFulfilled) return;

   timer.classList.add("scale");

   if (duration < 0) {
      alert("Time is out!");
      location.reload();
      return;
   }
   timer.textContent = `${duration}s`;
   duration--;

   setTimeout(updateTime, 1000);
};
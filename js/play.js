import { words } from "./word.js";

// Input Initialization
const typer = document.getElementById("typer");

// Sentence Setter
const sentencePart = Math.abs(Math.round(Math.random() * words.length - 1));
const sentenceMain = words[sentencePart];
const sentenceIndex = Math.abs(
   Math.round(Math.random() * sentenceMain.setter.length - 1)
);

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

// Repeater
let localRepeat = localStorage.getItem("repetition");
if (localRepeat === null || "NaN") localStorage.setItem("repetition", 1);

let localSentenceAverage = localStorage.getItem("sentenceAverage");
if (localSentenceAverage === null || "NaN")
   localStorage.setItem("sentenceAverage", 0);

let localScore = localStorage.getItem("score");
if (localScore === null || "NaN") localStorage.setItem("score", 0);

// Showcase Indicator
const repetitonTag = document.getElementById("repetition-tag");
repetitonTag.textContent = parseInt(localRepeat);

// Get the current value of 'repetition' from localStorage
const averageTag = document.getElementById("average-tag");
averageTag.textContent = `${parseFloat(localSentenceAverage).toFixed(2)}%`;

// Sensor
splitedLetter[typeIndex].classList.add("bg-body-secondary", "rounded", "p-2");

// Typing System
let isStarted = true;
let isFulfilled = false;
let isDone = false;
let trueWord = 0;
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
   if (letter == currentLetter) {
      splitedLetter[typeIndex].classList.add("text-success");
      trueWord++;
   } else splitedLetter[typeIndex].classList.add("text-warning");

   splitedLetter[typeIndex].classList.remove(
      "bg-body-secondary",
      "rounded",
      "p-2"
   );

   // Prevent Sentence Input Limit
   if (typeIndex >= maxWord - 1) {
      isFulfilled = true;
      const currentLength = parseInt(localSentenceAverage);
      const average = Math.round((trueWord / maxWord) * 100);
      const totalAverage = parseFloat((currentLength + average) / parseInt(localRepeat));
      const totalScore = parseInt(localScore) + trueWord;

      localStorage.setItem("sentenceAverage", totalAverage);
      localStorage.setItem("score", totalScore);

      console.log(
         average,
         currentLength,
         average,
         parseInt(localRepeat),
         totalAverage,
         totalScore
      );

      // Auto Sensor
      if (isDone) return;

      // Confirmation
      const bool = confirm("All is set, do another round?");
      if (bool) {
         const currentRepeat = parseInt(localRepeat);
         localStorage.setItem("repetition", currentRepeat + 1);
         location.reload();
         return;
      }

      // Make some code for stats showcase here
      averageTag.textContent = `${totalAverage.toFixed(2)}%`;
      const resultBox = document.getElementById("result-bar");
      resultBox.classList.add("active");
      isDone = true;

      // Cookie for localStorage value transmit through php server
      document.cookie = `sessionAverage=${totalAverage}`;
      document.cookie = `score=${totalScore}`;

   }

   if (isDone) return;
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

   // Leave the game when ended
   if (isDone) {
      window.location.href = "./";
   }
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
      alert("Time is out, disqualified.");
      window.location.href = "./";
      return;
   }
   timer.textContent = `${duration}s`;
   duration--;

   setTimeout(updateTime, 1000);
};

window.onkeydown = (e) => {
   if (e.key == "Tab") alert("Tab key is not allowed. 😣");
};

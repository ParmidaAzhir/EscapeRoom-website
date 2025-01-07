function updateClock() {
    let clockElement = document.querySelector('#clock');
    let now = new Date();
    let hours = now.getHours().toString().padStart(2, '0');
    let minutes = now.getMinutes().toString().padStart(2, '0');
    let seconds = now.getSeconds().toString().padStart(2, '0');
 
    // Update the clock element with the current time
    clockElement.innerText = `${hours}:${minutes}:${seconds}`;
 }
 
 // Update the clock every second
 setInterval(updateClock, 1000);
 
 // Run the clock function once when the page loads
 updateClock();
 

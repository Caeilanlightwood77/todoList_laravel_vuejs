const starCount = 100; // Number of stars to create
const shootingStarInterval = 5000; // Interval between shooting stars in milliseconds

export function initializeStarryNight() {
  const starsContainer = document.getElementById("stars");
  if (!starsContainer) return;

  starsContainer.innerHTML = "";

  for (let i = 0; i < starCount; i++) {
    const star = document.createElement("div");
    star.className = "star";
    star.style.top = `${Math.random() * 100}%`;
    star.style.left = `${Math.random() * 100}%`;
    starsContainer.appendChild(star);
  }

  randomizeShootingStarInterval();
}

function createShootingStar() {
  const shootingStar = document.createElement("div");
  shootingStar.className = "shooting-star";
  shootingStar.style.top = `${Math.random() * 100}%`;
  shootingStar.style.left = `${Math.random() * 100}%`;
  document.body.appendChild(shootingStar);

  setTimeout(() => {
    document.body.removeChild(shootingStar);
  }, 3000);
}

function randomizeShootingStarInterval() {
  setInterval(createShootingStar, shootingStarInterval);
}

export function clearStars() {
  const starsContainer = document.getElementById("stars");
  if (starsContainer) {
    starsContainer.innerHTML = "";
  }
}

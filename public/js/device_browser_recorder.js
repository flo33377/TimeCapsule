
document.addEventListener("DOMContentLoaded", () => {
  // Détection device
  let deviceType = "desktop";
  if (window.innerWidth <= 768) deviceType = "mobile";
  else if (window.innerWidth <= 1024) deviceType = "tablet";

  // Détection navigateur
  const ua = navigator.userAgent;
  let browser = "other_browser";
  if (ua.includes("Chrome") && !ua.includes("Edg") && !ua.includes("OPR")) browser = "chrome";
  else if (ua.includes("Firefox")) browser = "firefox";
  else if (ua.includes("Safari") && !ua.includes("Chrome")) browser = "safari";
  else if (ua.includes("Edg")) browser = "edge";

  // Envoi vers le script PHP
  fetch("../../src/recorder/analytics_device_browser.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `device=${deviceType}&browser=${browser}`
  });
});


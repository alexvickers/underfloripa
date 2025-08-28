(() => {
  const header = document.getElementById("site-header");
  const menuToggle = header?.querySelector(".menu-toggle");
  const primaryMenu = document.getElementById("primary-menu");
  const nav = document.getElementById("site-navigation");
  const miniLogo = header?.querySelector(".mini-logo");
  const shrinkThreshold = 180;

  if (!header || !menuToggle || !primaryMenu || !nav) return;

  // Header shrink on scroll
  const handleScroll = () => {
    const scrollY = window.scrollY;
    if (scrollY > shrinkThreshold) {
      header.classList.add("shrink");
      if (miniLogo) miniLogo.style.opacity = 1;
    } else {
      header.classList.remove("shrink");
      if (miniLogo) miniLogo.style.opacity = 0;
    }
  };
  window.addEventListener("scroll", handleScroll);
  handleScroll();

  // Mobile menu toggle
  menuToggle.addEventListener("click", () => {
    nav.classList.toggle("is-open");
    menuToggle.classList.toggle("is-active");
    primaryMenu.classList.toggle("open");
  });

  // Close menu with Escape
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && nav.classList.contains("is-open")) {
      nav.classList.remove("is-open");
      menuToggle.classList.remove("is-active");
      primaryMenu.classList.remove("open");
    }
  });
})();

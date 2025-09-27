(() => {
  const header = document.getElementById("site-header");
  const menuToggle = header?.querySelector(".menu-toggle");
  const primaryMenu = document.getElementById("primary-menu");
  const nav = document.getElementById("site-navigation");
  const miniLogo = header?.querySelector(".mini-logo");
  const shrinkThreshold = 180;

  if (!header || !menuToggle || !primaryMenu || !nav) return;

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

  menuToggle.addEventListener("click", () => {
    const isOpen = nav.classList.toggle("is-open");
    menuToggle.classList.toggle("is-active");
    primaryMenu.classList.toggle("open");

    if (isOpen) {
      document.body.classList.add("no-scroll");
    } else {
      document.body.classList.remove("no-scroll");
    }
  });

  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && nav.classList.contains("is-open")) {
      nav.classList.remove("is-open");
      menuToggle.classList.remove("is-active");
      primaryMenu.classList.remove("open");
      document.body.classList.remove("no-scroll");
    }
  });
})();

document.addEventListener("DOMContentLoaded", () => {
  const searchToggle = document.querySelector(".search-toggle");
  const searchForm = document.querySelector("#header-search");

  if (searchToggle && searchForm) {
    searchToggle.addEventListener("click", () => {
      const expanded = searchToggle.getAttribute("aria-expanded") === "true";
      searchToggle.setAttribute("aria-expanded", !expanded);
      searchForm.classList.toggle("active");
    });
  }
});

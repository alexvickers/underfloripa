(() => {
  const header = document.getElementById('site-header');
  const menuToggle = header?.querySelector('.menu-toggle');
  const primaryMenu = document.getElementById('primary-menu');
  const nav = document.getElementById('site-navigation');
  const miniLogo = header?.querySelector('.mini-logo');
  const shrinkThreshold = 180;

  if (!header || !menuToggle || !primaryMenu || !nav) return;

  // Handle header shrink on scroll
  const handleScroll = () => {
    const scrollY = window.scrollY;
    if (scrollY > shrinkThreshold) {
      header.classList.add('shrink');
      if (miniLogo) miniLogo.style.opacity = 1;
    } else {
      header.classList.remove('shrink');
      if (miniLogo) miniLogo.style.opacity = 0;
    }
  };
  window.addEventListener('scroll', handleScroll);
  handleScroll();

  // Toggle mobile menu
  const closeMenu = () => {
    nav.classList.remove('is-open');
    menuToggle.classList.remove('is-active');
    menuToggle.setAttribute('aria-expanded', 'false');
    primaryMenu.classList.remove('open');
  };

  menuToggle.addEventListener('click', () => {
    const isOpen = nav.classList.toggle('is-open');
    menuToggle.classList.toggle('is-active', isOpen);
    menuToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    primaryMenu.classList.toggle('open', isOpen);
  });

  // Close menu with Escape key
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && nav.classList.contains('is-open')) {
      closeMenu();
    }
  });

  // Collapse all submenus by default
  primaryMenu.querySelectorAll('.menu-item-has-children').forEach((li) => {
    const subMenu = li.querySelector('.sub-menu');
    if (subMenu) subMenu.style.display = 'none';

    // Toggle submenu on parent click
    const link = li.querySelector('a');
    link?.addEventListener('click', (e) => {
      // Only toggle on mobile
      if (window.innerWidth <= 768) {
        e.preventDefault();
        const isVisible = subMenu.style.display === 'block';
        subMenu.style.display = isVisible ? 'none' : 'block';
      }
    });
  });
})();

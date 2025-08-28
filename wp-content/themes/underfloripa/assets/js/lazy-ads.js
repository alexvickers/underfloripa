document.addEventListener("DOMContentLoaded", function () {
  const ads = document.querySelectorAll(".lazy-google-ad");

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          const container = entry.target;

          // Skip header ad on mobile
          if (
            container.classList.contains("header-ad") &&
            window.innerWidth < 768
          ) {
            observer.unobserve(container);
            return;
          }

          if (!container.hasChildNodes()) {
            const ins = document.createElement("ins");
            ins.className = "adsbygoogle";
            ins.style.display = "block";

            // Header ad fixed size
            if (container.classList.contains("header-ad")) {
              ins.style.width = container.style.width;
              ins.style.height = container.style.height;
            } else {
              ins.style.width = "100%";
              ins.style.height = "100%";
            }

            ins.setAttribute("data-ad-client", container.dataset.adClient);
            ins.setAttribute("data-ad-slot", container.dataset.adSlot);

            container.appendChild(ins);
            (adsbygoogle = window.adsbygoogle || []).push({});
          }

          observer.unobserve(container);
        }
      });
    },
    { threshold: 0.1 }
  );

  ads.forEach((ad) => observer.observe(ad));
});

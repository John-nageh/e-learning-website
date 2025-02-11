document.addEventListener("DOMContentLoaded", () => {
    const statsSection = document.getElementById("stats");
    const stats = document.querySelectorAll(".stat-number");
  
    const startCounting = (entries, observer) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          stats.forEach((stat) => {
            const updateCount = () => {
              const target = +stat.getAttribute("data-target");
              const current = +stat.innerText;
              const increment = target / 100; // Adjust the speed by changing the divisor
  
              if (current < target) {
                stat.innerText = Math.ceil(current + increment);
                setTimeout(updateCount, 20); // Adjust the speed by changing the timeout
              } else {
                stat.innerText = target;
              }
            };
  
            updateCount();
          });
  
          observer.disconnect(); // Stop observing after animation is done
        }
      });
    };
  
    const observer = new IntersectionObserver(startCounting, {
      threshold: 0.5, // Trigger when 50% of the section is visible
    });
  
    observer.observe(statsSection);
  });
  
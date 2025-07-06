document.addEventListener("DOMContentLoaded", function () {
  const results = document.getElementById("property-tab-results");
  console.log(results);

  const loadMoreBtn = document.getElementById("load-more-tabbed");
  const noMoreProperties = document.getElementById("no-more-properties");
  let currentTerm = results.dataset.term;
  let offset = 0;

  function loadProperties(reset = false) {
    fetch(ajax_params.ajax_url, {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: new URLSearchParams({
        action: "load_properties",
        nonce: ajax_params.nonce,
        offset,
        term_id: currentTerm,
      }),
    })
      .then((res) => res.text())
      .then((html) => {
        if (html === "No more properties found.") {
          noMoreProperties.style.display = "block";
        } else {
          if (reset) results.innerHTML = html;
          else results.insertAdjacentHTML("beforeend", html);
          offset += 6;
        }
      });
  }

  loadProperties(true);

  document.querySelectorAll(".property-tab").forEach((tab) => {
    tab.addEventListener("click", function () {
      document
        .querySelectorAll(".property-tab")
        .forEach((t) => t.classList.remove("active"));
      this.classList.add("active");
      currentTerm = this.dataset.term;
      offset = 0;
      loadProperties(true);
    });
  });

  loadMoreBtn.addEventListener("click", function () {
    loadProperties();
  });
});

document.addEventListener("DOMContentLoaded", function () {
  const menuToggle = document.getElementById("menu-toggle");
  const nav = document.querySelector(".main-navigation");

  menuToggle.addEventListener("click", function () {
    nav.classList.toggle("open");
  });
});

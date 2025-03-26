document.addEventListener("DOMContentLoaded", function () {
  // fetchSocialmedia();
  fetch("api/products.php")
    .then((response) => response.json())
    .then((data) => {
      console.log(data.products);
      renderProducts(data.products);
    })
    .catch((error) => console.error("Error:", error));

  fetch("api/socialmedia.php")
    .then((response) => response.json())
    .then((data) => {
      console.log(data);
      fetchSocialmedia(data.socialmedia);
    });
});

function fetchSocialmedia(socialmedia) {
  const html_footer = socialmedia
    .map(
      (s) => `
        <a href="${s.url}" class="text-sm hover:text-warning">
          ${s.platform}
        </a>
      `
    )
    .join(""); // Important!

  const footer = document.getElementById("socialmedia_footer");
  footer.innerHTML = html_footer;
}

document
  .getElementById("filterForm")
  .addEventListener("submit", function (event) {
    event.preventDefault();

    const search = document.getElementById("search").value;
    const category = document.getElementById("category").value;

    const newUrl = `?search=${encodeURIComponent(
      search
    )}&category=${encodeURIComponent(category)}`;
    window.history.pushState({}, "", newUrl);

    fetch(`api/products.php?search=${search}&category=${category}`)
      .then((response) => response.json())
      .then((data) => {
        renderProducts(data.products);
        console.log(data.products);
      })
      .catch((error) => console.error("Error fetching products:", error));
  });

function renderProducts(products) {
  const productGrid = document.getElementById("productGrid");
  productGrid.innerHTML = "";
  productGrid.classList.add(
    "grid",
    "items-stretch",
    "grid-cols-2",
    "xl:grid-cols-3"
  );

  if (products.length === 0) {
    productGrid.innerHTML = '<p class="text-center">No products found</p>';
    return;
  }

  products.forEach((product, productIndex) => {
    console.log(product);
    const productCard = document.createElement("div");
    productCard.classList.add("w-full", "p-2");

    const imageUrls = JSON.parse(product.urls);
    const carouselId = `carousel-${productIndex}`;

    const carouselSlides = imageUrls
      .map(
        (url, index) => `
      <div class="shrink-0 w-1/2 h-24 rounded">
        <img src="${url}" class="shrink-0 w-full snap-center rounded" alt="Product Image ${
          index + 1
        }" />
      </div>
    `
      )
      .join("");

    console.log(carouselSlides);

    productCard.innerHTML = `
     <button
  class="card shadow-md p-2 h-full w-full text-left view-details-btn"
  data-name="${product.name}"
  data-category="${product.category ? product.category : "N/A"}"
  data-price="${product.price}"
  data-brand="${product.brand}"
  data-description="${product.description}"
  data-detail="${product.detail}"
  data-images='${JSON.stringify(imageUrls)}'
>
  <div class="flex flex-col md:flex-row h-full">
    <!-- Carousel Section -->
    <div class="h-full w-full rounded-lg overflow-hidden relative md:w-5/12">
      <div class="w-full h-full snap-x snap-mandatory overflow-x-auto">
        <div id="${carouselId}" class="flex flex-nowrap w-full h-full">
          <div class="shrink-0 w-full flex items-start justify-center relative">
            <!-- Wrapper to maintain aspect ratio -->
            <div class="w-full sm:pb-0 pb-[75%] sm:static relative">
              <img
                src="${imageUrls[0]}"
                alt="img"
                class="absolute top-0 left-0 w-full h-full object-contain snap-center rounded-md"
              />
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Product Info Section -->
    <div class="flex flex-col justify-between items-end md:pl-4 w-full md:w-7/12">
      <div class="flex flex-col w-full pt-2">
        <div class="flex flex-wrap flex-row md:flex-nowrap w-full items-start justify-between">
          <!-- Left section: name + category -->
          <div class="flex flex-col p-0 m-0 items-start gap-0 md:w-2/3 justify-start">
            <h2 class="text-xs lg:text-lg font-semibold text-start md:text-left">${
              product.name
            }</h2>
            <span class="badge badge-warning text-black badge-sm lg:badge-md">
            <ul class="flex flex-row gap-1 ">
            ${
              product.category
                ? product.category.map((c) => `<li>${c.name}</li>`)
                : "N/A"
            }
            </ul>
            </span>
          </div>

          <!-- Right section: price -->
          <div class="md:w-1/3 text-center md:text-right">
            <p class="text-xs md:text-md lg:text-lg font-bold">฿${
              product.price
            }</p>
          </div>
        </div>

        <div class="mt-2 max-h-24 overflow text-xs lg:text-md text-gray-600 w-full line-clamp-3">
          <p>Brand: ${product.brand ? product.brand : "N/A"}</p>
        </div>
        <div class="mt-2 max-h-24 overflow text-xs lg:text-md text-gray-600 w-full line-clamp-3">
          <p>${product.description}</p>
        </div>
      </div>

      <!-- "View Details" button style but non-clickable -->
      
    </div>
  </div>
</button>


    `;

    productGrid.appendChild(productCard);
  });

  // Open modal and populate data
  document.querySelectorAll(".view-details-btn").forEach((btn) => {
    btn.addEventListener("click", () => {
      const name = btn.dataset.name;
      const category = btn.dataset.category;
      console.log(category);
      const price = btn.dataset.price;
      const description = btn.dataset.description;
      const detail = btn.dataset.detail;
      const brand = btn.dataset.brand;
      console.log("Product Detail:", detail);
      console.log(btn.dataset);
      const images = JSON.parse(btn.dataset.images);
      const modalCarousel = document.getElementById("modalCarousel");
      modalCarousel.innerHTML = `
  <div class=" snap-x snap-mandatory overflow-x-auto  flex flex-nowrap w-full h-full">
    
      ${images
        .map(
          (url) => `
          <div class="shrink-0 w-full flex items-start justify-center relative h-full ">
            <div class="max-w-max  sm:static relative h-full">
              <img
                src="${url}"
                alt="img"
                class="absolute top-0 left-0 w-full h-full object-contain snap-center rounded-md"
              />
            </div>
          </div>
        `
        )
        .join("")}
   
  </div>
`;

      document.getElementById("modalProductName").textContent = name;
      document.getElementById("modalProductCategory").textContent = category
        ? category
        : "ไม่ระบุ";
      document.getElementById("modalProductDetail").textContent = detail;
      document.getElementById("modalProductBrand").textContent = brand;
      document.getElementById("modalProductPrice").textContent = `฿${price}`;
      document.getElementById("modalProductDescription").textContent =
        description;

      document.getElementById("productModal").classList.remove("hidden");
    });
  });

  // Close modal
  document.getElementById("modalClose").addEventListener("click", () => {
    document.getElementById("productModal").classList.add("hidden");
  });

  // Optional: Close modal when clicking outside modal content
  document.getElementById("productModal").addEventListener("click", (e) => {
    if (e.target === e.currentTarget) {
      e.currentTarget.classList.add("hidden");
    }
  });
}

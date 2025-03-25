window.addEventListener("load", function () {
  fetch("api/categories.php") // Update the path if needed
    .then((response) => response.json())
    .then((data) => {
      console.log(data);
      const categorySelect = document.getElementById("category");
      console.log(categorySelect);
      // Loop through the categories and add them as options to the select element
      data.categories.forEach((category) => {
        const option = document.createElement("option");
        option.value = category.id; // Assuming the 'name' field contains the category name
        option.textContent = category.cate_name || "ไม่ระบุ"; // Display the category name as option text
        categorySelect.appendChild(option);
      });
    })
    .catch((error) => console.error("Error fetching categories:", error));
});

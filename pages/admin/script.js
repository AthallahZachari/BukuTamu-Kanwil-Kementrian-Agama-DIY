document.getElementById("tableBtn").addEventListener("click", function () {
  document.getElementById("admin-table").classList.remove("hidden");
  document.getElementById("show-edit").classList.add("hidden");
  document
    .getElementById("tableBtn")
    .classList.add("border-b-2", "border-green-500");
  document
    .getElementById("editBtn")
    .classList.remove("border-b-2", "border-green-500");
});

document.getElementById("editBtn").addEventListener("click", function () {
  document.getElementById("show-edit").classList.remove("hidden");
  document.getElementById("admin-table").classList.add("hidden");
  document
    .getElementById("editBtn")
    .classList.add("border-b-2", "border-green-500");
  document
    .getElementById("tableBtn")
    .classList.remove("border-b-2", "border-green-500");
});

// Function to toggle the visibility of an element
function toggleVisibility(element) {
  if (element) {
    element.classList.toggle("hidden");
  } else {
    console.error("Element not found.");
  }
}

// Function to handle dropdown selection
function handleDropdownSelection(e) {
  const selectedValue = e.target.getAttribute("data-value");
  const dropdownButton = document.getElementById("dropdownButton");
  const hiddenInput = document.getElementById("kepentinganID");
  const dropdownMenu = document.getElementById("dropdownMenu");
  const form = document.getElementById("filterBidang");

  if (selectedValue && hiddenInput && dropdownButton && dropdownMenu && form) {
    hiddenInput.value = selectedValue;
    dropdownButton.textContent = e.target.textContent;
    dropdownMenu.classList.add("hidden");
    form.submit();
  } else {
    console.error("One or more elements not found.");
  }
}

// Attach event listener to the dropdown filter button
document
  .getElementById("dropdownButton")
  .addEventListener("click", function () {
    const dropdownMenu = document.getElementById("dropdownMenu");
    toggleVisibility(dropdownMenu);
  });

// Attach event listeners to the dropdown menu items
document.querySelectorAll("#dropdownMenu li").forEach(function (item) {
  item.addEventListener("click", handleDropdownSelection);
});

// Handle btnDropdownBidang click
document.querySelectorAll(".btnDropdownBidang").forEach(function (button) {
  button.addEventListener("click", function (e) {
    e.preventDefault();
    const id = e.target.id.split("-")[1];
    const listDropdown = document.getElementById(`listDropdownBidang-${id}`);
    toggleVisibility(listDropdown);
  });
});

// Handle dropdown items for btnDropdownBidang
document.querySelectorAll(".listDropdownBidang li").forEach(function (item) {
  item.addEventListener("click", function (e) {
    const selectedValue = e.target.getAttribute("data-value");
    const parentForm = e.target.closest("form");
    const hiddenInput = parentForm.querySelector(".bidangID");

    if (selectedValue && hiddenInput) {
      hiddenInput.value = selectedValue;
      parentForm.submit();
    } else {
      console.error("Selected value or hidden input not found.");
    }
  });
});

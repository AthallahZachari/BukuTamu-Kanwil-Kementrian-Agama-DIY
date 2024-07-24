document
  .getElementById("dropdownFilter")
  .addEventListener("click", function () {
    document.getElementById("dropdownMenu").classList.toggle("hidden");
  });

document.querySelectorAll("#dropdownMenu li").forEach(function (item) {
  item.addEventListener("click", function () {
    const selectedValue = this.getAttribute("data-value");
    document.getElementById("kepentinganID").value = selectedValue;
    document.getElementById("dropdownFilter").textContent = this.textContent;
    document.getElementById("dropdownMenu").classList.add("hidden");

    // Submit form setelah nilai diset
    document.getElementById("filterBidang").submit();
  });
});


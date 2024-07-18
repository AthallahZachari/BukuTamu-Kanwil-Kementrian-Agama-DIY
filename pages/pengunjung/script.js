document.getElementById('dropdownButton').addEventListener('click', function() {
    document.getElementById('dropdownMenu').classList.toggle('hidden');
});

document.querySelectorAll('#dropdownMenu li').forEach(function(item) {
    item.addEventListener('click', function() {
        const selectedValue = this.getAttribute('data-value');
        document.getElementById('kepentinganID').value = selectedValue;
        document.getElementById('dropdownButton').textContent = this.textContent;
        document.getElementById('dropdownMenu').classList.add('hidden');
    });
});

function togglePopup() {
    var popup = document.getElementById("popup-form");
    popup.classList.toggle("hidden");
    popup.classList.toggle("flex");
}
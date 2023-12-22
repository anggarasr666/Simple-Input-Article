function filterCarousel() {
    var input, filter, cards, card, title, i;
    input = document.getElementById("filterInput");
    filter = input.value.toUpperCase();
    cards = document.querySelectorAll(".card");

    for (i = 0; i < cards.length; i++) {
        card = cards[i];
        title = card.querySelector(".card-title");
        var cardText = title.innerText.toUpperCase();
        if (cardText.includes(filter)) {
            card.style.display = "block";
        } else {
            card.style.display = "none";
        }
    }
}

// Jalankan fungsi filterCarousel saat halaman dimuat
window.onload = filterCarousel;
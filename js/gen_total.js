const total_box = document.getElementById("total");
const qty_box = document.getElementById("qty");
qty_box.addEventListener("change", function() {
    gen();
});

gen();

function gen() {
    const hargaj_box = document.getElementById("hargajual");
    if (hargaj_box == null) {
        const hargab_box = document.getElementById("hargabeli");
        hargab_box.addEventListener("change", function() {
            gen();
        });
        total_box.value = qty_box.value * hargab_box.value;
    } else {
        hargaj_box.addEventListener("change", function() {
            gen();
        });
        total_box.value = qty_box.value * hargaj_box.value;
    }
}

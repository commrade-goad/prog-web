const select = document.getElementById("overview");

const url_params = new URLSearchParams(window.location.search);
const overview_value = url_params.get('overview');

if (overview_value !== null) {
    select.value = overview_value;
}

select.addEventListener("change", function() {
    const selval = select.value;
    window.location = `/dashboard?overview=${selval}`;
});

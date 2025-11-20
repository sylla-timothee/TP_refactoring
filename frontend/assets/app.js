async function refreshServices() {
    const res = await fetch("api.php?action=listServices");
    const services = await res.json();

    const div = document.getElementById("services");
    div.innerHTML = services.map(s => `
        <div class="service-card ${s.type ?? 'autre'}">
            <b>${s.name}</b> (${s.type ?? 'autre'})<br>
            ${s.description ? `<i>${s.description}</i><br>` : ""}
            Durée: ${s.duration ?? 30} min<br>
            Créneaux: ${s.slots.length ? s.slots.join(", ") : "Aucun"}
        </div>
    `).join("");
}

async function refreshBookings() {
    const email = getCookie("email");
    const res = await fetch(`api.php?action=listBookings&email=${email}`);
    const bookings = await res.json();

    const div = document.getElementById("bookings");
    if(bookings.length === 0){
        div.innerHTML = "<p>Aucune réservation</p>";
        return;
    }
    div.innerHTML = bookings.map(b => `
        <div class="booking-card">
            Service ID: ${b.service}<br>
            Créneau: ${b.slot}
        </div>
    `).join("");
}

function getCookie(name){
    return document.cookie.split("; ")
        .find(row => row.startsWith(name + "="))
        ?.split("=")[1];
}

window.onload = () => {
    refreshServices();
    refreshBookings();
};

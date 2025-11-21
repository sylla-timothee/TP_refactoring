function getCookie(name){
    return document.cookie.split("; ").find(row => row.startsWith(name + "="))?.split("=")[1] ?? null;
}

async function fetchJSON(url, options = {}) {
    const res = await fetch(url, {
        credentials: 'same-origin', // ⚡ Important pour envoyer les cookies
        ...options
    });
    return await res.json();
}


async function refreshServices(){
    const services = await fetchJSON("api.php?action=listServices");
    const div = document.getElementById("services");
    if(!services.length){
        div.innerHTML = "<p>Aucun service disponible</p>";
        return;
    }

    div.innerHTML = services.map(s => `
        <div class="service-card ${s.type ?? 'autre'}">
            <b>${s.name}</b> (${s.type ?? 'autre'})<br>
            ${s.description ? `<i>${s.description}</i><br>` : ""}
            Durée: ${s.duration ?? 30} min<br>
            Créneaux: ${s.slots.length ? s.slots.map(slot => `
                <button class="btn btn-slot" onclick="bookSlot(${s.id}, '${slot}')">${slot}</button>
            `).join(" ") : "Aucun"}
        </div>
    `).join("");
}

async function refreshBookings(){
    const email = getCookie("email");
    if(!email) return;

    const bookings = await fetchJSON(`api.php?action=listBookings&email=${email}`);
    const div = document.getElementById("bookings");

    if(!bookings.length){
        div.innerHTML = "<p>Aucune réservation</p>";
        return;
    }

    div.innerHTML = bookings.map(b => `
        <div class="booking-card">
            Service ID: ${b.service}<br>
            Créneau: ${b.slot}<br>
            <button class="btn danger" onclick="cancelBooking(${b.id})">Annuler</button>
        </div>
    `).join("");
}

async function bookSlot(serviceId, slot){
    const res = await fetchJSON("api.php?action=bookService", {
        method: "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: `serviceId=${serviceId}&slot=${encodeURIComponent(slot)}`
    });
    alert(res.msg ?? (res.success ? "Réservé !" : "Erreur"));
    refreshBookings();
}

async function cancelBooking(bookingId){
    const email = getCookie("email");
    if(!email) return alert("Email non trouvé, reconnectez-vous.");

    const res = await fetchJSON("api.php?action=cancelBooking", {
        method: "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: `bookingId=${bookingId}&email=${encodeURIComponent(email)}`
    });

    alert(res.msg ?? (res.success ? "Annulé !" : "Erreur"));
    refreshBookings();
}
window.onload = function(){
    refreshServices();
    refreshBookings();
};

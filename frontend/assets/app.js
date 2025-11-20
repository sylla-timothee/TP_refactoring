async function refreshServices() {
    const res = await fetch("api.php?action=listServices");
    const services = await res.json();

    const div = document.getElementById("services");
    div.innerHTML = services.map(s => `
        <div>
            <b>${s.name}</b> (${s.type})<br>
            Créneaux: ${s.slots.join(", ")}
        </div>
    `).join("<hr>");
}

async function refreshBookings() {
    const email = getCookie("email");
    const res = await fetch(`api.php?action=listBookings&email=${email}`);
    const bookings = await res.json();

    const div = document.getElementById("bookings");
    div.innerHTML = bookings.map(b => `
        <div>
            Service ID: ${b.service} — ${b.slot}
        </div>
    `).join("<hr>");
}

function getCookie(name) {
    return document.cookie.split("; ")
        .find(row => row.startsWith(name + "="))
        ?.split("=")[1];
}

window.onload = () => {
    refreshServices();
    refreshBookings();
};

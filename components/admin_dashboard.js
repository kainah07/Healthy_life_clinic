document.addEventListener("DOMContentLoaded", function () {

    const sidebar = document.querySelector('.sidebar');
    const toggle = document.querySelector('.toggle');

    // Debug logs
    console.log("JS loaded");
    console.log("toggle =", toggle);
    console.log("sidebar =", sidebar);

    // Sidebar toggle only
    if (toggle) {
        toggle.addEventListener('click', () => {
            sidebar.classList.toggle('close');
        });
    }
});

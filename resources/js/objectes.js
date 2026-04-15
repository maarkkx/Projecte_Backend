//quan carreguin els objectes
document.addEventListener("DOMContentLoaded", () => {
    const input = document.getElementById("searchInput");
    const items = document.querySelectorAll(".articles-list li");

    if (!input || !items.length) return;

    input.addEventListener("input", () => {
        const text = input.value.toLowerCase().trim();

        items.forEach(item => {
            const title = item.querySelector("strong")?.textContent.toLowerCase() || "";
            const body = item.querySelector(".article-body")?.textContent.toLowerCase() || "";
            const user = item.querySelector(".article-user")?.textContent.toLowerCase() || "";

            const match = title.includes(text) || body.includes(text) || user.includes(text);
            item.style.display = match ? "" : "none";
        });
    });
});
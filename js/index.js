document.addEventListener("DOMContentLoaded", () => {
    const menu = document.querySelector(".drop_menu");
    const toggleButton = document.querySelector(".upload");
    const avatarInput = document.getElementById("avatarInput");


    toggleButton.addEventListener("click", (e) => {
        e.stopPropagation(); // зупиняє "спливання" події, щоб подія не дійшла до document і не спрацювало закриття меню.
        menu.style.display = menu.style.display === "flex" ? "none" : "flex";
    });


    document.addEventListener("click", (e) => {
        if (!menu.contains(e.target)) {
            menu.style.display = "none";
        }
    });

 
    document.querySelectorAll(".drop_menu .but_none img").forEach(img => {
    img.addEventListener("click", () => {
        const avatarSrc = img.src;
        avatarInput.value = avatarSrc;

    fetch("functions/user_cabinet.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `avatar=${encodeURIComponent(avatarSrc)}`
    })
    .then(res => res.text())
    .then(data => {
        console.log("Відповідь:", data);
        location.reload(); 
    })
    .catch(err => console.error("Помилка:", err));

    });
    });
    });
    
    document.addEventListener("DOMContentLoaded", () => {
        const favoriteBtns = document.querySelectorAll(".favorite_btn");

        favoriteBtns.forEach((btn) => {
            const tourId = btn.getAttribute("data-tour-id");
             if (localStorage.getItem("favorite_" + tourId)) {
                btn.classList.add("active");
            }
            btn.addEventListener("click", (e) => {
                e.stopPropagation();
                const isNowActive = btn.classList.toggle("active");

                
                if (isNowActive) 
                    localStorage.setItem("favorite_" + tourId, "true");
                else 
                    localStorage.removeItem("favorite_" + tourId);
                fetch("functions/user_cabinet.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body:
                        "product_id=" +
                        encodeURIComponent(tourId) +
                        "&action=" +
                        (isNowActive ? "add" : "remove"),
                    })
                    
                    .then((res) => res.text())
                    .then((data) => {
                        console.log("Відповідь сервера:", data);
                        location.reload();
                    })
                    .catch((err) => {
                        console.error("Помилка:", err);
                    });
            });
            
        });
        document.addEventListener("DOMContentLoaded", () => {
        const logoutBtn = document.getElementById("logoutBtn");
        const logoutForm = document.getElementById("logoutForm");

        logoutBtn.addEventListener("click", () => {
            // Очищення localStorage
            for (let key in localStorage) {
                if (key.startsWith("favorite_")) {
                localStorage.removeItem(key);
                }
            }

            // Відправка форми (submit)
            logoutForm.submit();
        });
});
});



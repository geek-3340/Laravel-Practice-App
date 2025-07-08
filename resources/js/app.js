import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener("DOMContentLoaded", function () {
    const posts = document.querySelectorAll(".post");

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add("visible");
                observer.unobserve(entry.target); // 表示後は監視しない
            }
        });
    }, {
        threshold: 0.1 // 10%見えたら実行
    });

    posts.forEach(post => {
        observer.observe(post);
    });
});



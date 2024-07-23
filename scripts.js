// loading.js
document.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
        document.getElementById('loading-screen').style.display = 'none';
    }, 500); // Hide loading screen after 500 milliseconds
});

// scripts.js
document.addEventListener('DOMContentLoaded', function() {
    const scrollButton = document.querySelector('.scroll-button');
    const bottomButton = document.querySelector('.bottom-button');

    function handleScroll() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const threshold = 500; // Adjust this value as needed

        if (scrollTop > threshold) {
            scrollButton.classList.add('visible'); // Show the scroll button
            bottomButton.classList.add('visible'); // Show the bottom button
        } else {
            scrollButton.classList.remove('visible'); // Hide the scroll button
            bottomButton.classList.remove('visible'); // Hide the bottom button
        }
    }

    window.addEventListener('scroll', handleScroll);
});

document.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
        document.getElementById('loading-screen').style.display = 'none';
    }, 500); // Hide loading screen after 500 milliseconds
});

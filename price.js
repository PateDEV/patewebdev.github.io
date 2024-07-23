document.addEventListener('mousemove', (e) => {
    const cards = document.querySelectorAll('.card');

    cards.forEach(card => {
        const { left, top, width, height } = card.getBoundingClientRect();
        const { clientX: mouseX, clientY: mouseY } = e;

        const centerX = left + width / 2;
        const centerY = top + height / 2;

        const xRotation = ((mouseY - centerY) / height) * 15; // Rotate based on vertical position
        const yRotation = ((mouseX - centerX) / width) * -15; // Rotate based on horizontal position

        card.style.transform = `rotateX(${xRotation}deg) rotateY(${yRotation}deg)`;
    });
});

document.addEventListener('mouseleave', () => {
    document.querySelectorAll('.card').forEach(card => {
        card.style.transform = 'rotateX(0) rotateY(0)'; // Reset rotation
    });
});

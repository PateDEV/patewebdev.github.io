document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('.home-btn').addEventListener('click', function() {
        window.location.href = 'index.html';
    });
    
    // Function to start countdown
    window.startCountdown = function(type) {
        const durationInput = document.getElementById(`${type}-duration`);
        const countdownElement = document.getElementById(`${type}-countdown`);
        
        const duration = parseInt(durationInput.value);
        if (isNaN(duration) || duration <= 0) {
            alert('Please enter a valid duration.');
            return;
        }

        let timeRemaining = duration;
        const intervalId = setInterval(() => {
            const minutes = Math.floor(timeRemaining / 60);
            const seconds = timeRemaining % 60;
            countdownElement.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

            timeRemaining--;

            if (timeRemaining < 0) {
                clearInterval(intervalId);
                countdownElement.textContent = '00:00';
                alert('Time is up!');
            }
        }, 1000);
    };
});

document.addEventListener('DOMContentLoaded', function() {
    const ratingStars = document.querySelectorAll('.rating-star');
    const ratingInput = document.getElementById('rating');

    ratingStars.forEach(star => {
        star.addEventListener('click', function() {
            const rating = this.dataset.rating;
            ratingInput.value = rating;
            
            // Update star colors
            ratingStars.forEach(s => {
                const starIcon = s.querySelector('svg');
                if (s.dataset.rating <= rating) {
                    starIcon.classList.remove('text-gray-300');
                    starIcon.classList.add('text-yellow-400');
                } else {
                    starIcon.classList.remove('text-yellow-400');
                    starIcon.classList.add('text-gray-300');
                }
            });
        });

        // Hover effects
        star.addEventListener('mouseenter', function() {
            const rating = this.dataset.rating;
            ratingStars.forEach(s => {
                const starIcon = s.querySelector('svg');
                if (s.dataset.rating <= rating) {
                    starIcon.classList.add('text-yellow-400');
                }
            });
        });

        star.addEventListener('mouseleave', function() {
            const currentRating = ratingInput.value;
            ratingStars.forEach(s => {
                const starIcon = s.querySelector('svg');
                if (s.dataset.rating <= currentRating) {
                    starIcon.classList.add('text-yellow-400');
                } else {
                    starIcon.classList.remove('text-yellow-400');
                    starIcon.classList.add('text-gray-300');
                }
            });
        });
    });
}); 
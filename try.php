<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        .stars span {
            font-size: 1.5rem;
            cursor: pointer;
            color: #ccc;
        }
        .stars span.selected {
            color: #f4b400;
        }
        textarea {
            width: 97%;
            margin-top: 10px;
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ddd;
            resize: none;
            height: 100px; 
        }
        button {
            margin-top: 15px;
            background: #f06292;
            border: none;
            color: #fff;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background: #e91e63;
        }
        .reviews {
            margin-top: 30px;
        }
        .review-item {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Review System</h1>
        <div>
            <h2>Rate Vendor:</h2>
            <div class="stars" id="rating-stars">
                <span data-value="1">&#9733;</span>
                <span data-value="2">&#9733;</span>
                <span data-value="3">&#9733;</span>
                <span data-value="4">&#9733;</span>
                <span data-value="5">&#9733;</span>
            </div>
        </div>
        <textarea id="review-text" placeholder="Tell us about your experience"></textarea>
        <button id="submit-review">Submit Review</button>

        <div class="reviews" id="reviews">
            <h2>Reviews</h2>
        </div>
    </div>

    <script>
        const stars = document.querySelectorAll('#rating-stars span');
        const reviewText = document.getElementById('review-text');
        const submitButton = document.getElementById('submit-review');
        const reviewsContainer = document.getElementById('reviews');
        let selectedRating = 0;

        // Array to store reviews
        const reviews = [];

        // Highlight selected stars with cascading effect
        stars.forEach(star => {
            star.addEventListener('click', () => {
                selectedRating = parseInt(star.getAttribute('data-value'));
                stars.forEach(s => {
                    if (parseInt(s.getAttribute('data-value')) <= selectedRating) {
                        s.classList.add('selected');
                    } else {
                        s.classList.remove('selected');
                    }
                });
            });
        });

        // Submit review
        submitButton.addEventListener('click', () => {
            if (!selectedRating || !reviewText.value.trim()) {
                alert('Please provide a rating and a review.');
                return;
            }

            // Add the review to the array
            const review = {
                rating: selectedRating,
                text: reviewText.value.trim(),
                date: new Date().toLocaleString(),
            };
            reviews.push(review);

            // Reset inputs
            reviewText.value = '';
            stars.forEach(star => star.classList.remove('selected'));
            selectedRating = 0;

            // Refresh reviews display
            displayReviews();
        });

        // Display all reviews
        function displayReviews() {
            reviewsContainer.innerHTML = '<h2>Reviews</h2>';
            reviews.forEach(review => {
                reviewsContainer.innerHTML += `
                    <div class="review-item">
                        <p><strong>Rating:</strong> ${'⭐'.repeat(review.rating)}</p>
                        <p>${review.text}</p>
                        <small>${review.date}</small>
                    </div>
                `;
            });
        }
    </script>
</body>
</html>

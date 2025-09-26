<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>DJ Details and Booking Form</title>
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
        <style>
            .container {
                max-width: 1400px;
                margin-top: 50px;
                padding: 20px;
                background-color: #f9f9f9;
                border-radius: 8px;
                box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            }

            h2 {
                text-align: center;
                color: #333;
                margin-bottom: 20px;
                font-family: Arial, sans-serif;
                font-size: 24px;
            }

            .venue-detail {
                font-family: Arial, sans-serif;
                font-size: 16px;
                color: #555;
                margin-bottom: 15px;
            }

            .venue-detail p {
                margin: 5px 0;
            }

            .venue-detail strong {
                color: #333;
            }

            hr {
                border: none;
                height: 1px;
                background-color: #e0e0e0;
                margin: 20px 0;
            }

            .details-container {
                display: flex;
                margin-bottom: 15px;
            }

            .image-container {
                flex: 1;
                max-width: 300px;
                margin-right: 20px;
            }

            .image-container img {
                width: 100%;
                height: auto;
                max-height: 200px;
                border-radius: 8px;
                box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
                object-fit: cover;
            }

            .details {
                flex: 2;
            }

            .booking-form {
                padding: 20px;
                background-color: #f9f9f9;
                border-radius: 8px;
                box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            }

            .btn-primary {
                background-color: #007bff;
                border: none;
            }

            .image-gallery {
                display: flex;
                flex-wrap: wrap;
                gap: 15px;
                margin-top: 15px;
            }

            .image-gallery .card {
                flex: 1 1 calc(33.333% - 15px);
                max-width: calc(33.333% - 15px);
                box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
                border-radius: 8px;
                overflow: hidden;
            }

            .image-gallery .card img {
                width: 100%;
                height: 200px;
                object-fit: cover;
                display: block;
                border-radius: 8px;
                transition: transform 0.3s;
            }

            .image-gallery .card:hover img {
                transform: scale(1.05);
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h2>DJ Details</h2>
            <div class="row">
                <div class="col-md-8">
                    <?php
                    session_start();
                    include 'config.php';

                    $VendorID = $_GET['vendor_id'] ?? '';
                    $VenueDetailID = $_GET['venue_detail_id'] ?? '';

                    if (!empty($VendorID) && is_numeric($VendorID) && !empty($VenueDetailID) && is_numeric($VenueDetailID)) {
                        $sql = "SELECT v.Name AS VendorName, v.Contact_Number, v.CompanyName, vv.VenueType, vd.Name AS VenueName, vd.Capacity, vd.FeatureDescription, vd.Address, a.Name as AreaName, vd.Price, vd.BookingPrice, vd.DisplayImg 
                                FROM tbl_venue_detail vd 
                                JOIN tbl_vendor v ON vd.VendorID = v.ID
                                JOIN tbl_area a ON vd.AreaID = a.ID
                                JOIN tbl_venue vv ON vd.VenueID = vv.ID
                                WHERE vd.VendorID = $VendorID AND vd.ID = $VenueDetailID";

                        $result = mysqli_query($conn, $sql);
                        $venue = null;

                        if ($result && mysqli_num_rows($result) > 0) {
                            $venue = mysqli_fetch_assoc($result);

                            echo "<div class='details-container'>";
                            echo "<div class='image-container'>";
                            if (!empty($venue['DisplayImg'])) {
                                echo "<img src='uploads/vendor_images/" . htmlspecialchars($venue['DisplayImg']) . "' alt='Venue Image'>";
                            } else {
                                echo "<p>No image available for this venue.</p>";
                            }
                            echo "</div>";
                            echo "<div class='details'>";
                            echo "<div class='venue-detail'>";
                            echo "<p><strong>Name:</strong> " . htmlspecialchars($venue['VenueName']) . "</p>";
                            echo "<p><strong>Venue Type:</strong> " . htmlspecialchars($venue['VenueType']) . "</p>";
                            echo "<p><strong>Capacity:</strong> " . htmlspecialchars($venue['Capacity']) . "</p>";
                            echo "<p><strong>Feature Description:</strong> " . htmlspecialchars($venue['FeatureDescription']) . "</p>";
                            echo "<p><strong>Price:</strong> ₹" . htmlspecialchars($venue['Price']) . "</p>";
                            echo "<p><strong>Booking Price:</strong> ₹" . htmlspecialchars($venue['BookingPrice']) . "</p>";
                            echo "<p><strong>Contact Number:</strong> " . htmlspecialchars($venue['Contact_Number']) . "</p>";
                            echo "<p><strong>Address:</strong> " . htmlspecialchars($venue['Address']) . "</p>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                            echo "<hr>";
                        } else {
                            echo "<p>No venue details found for the selected Vendor ID and Venue Detail ID.</p>";
                        }

                        $bookingPrice = $venue['BookingPrice'] ?? 0;

                        $sqlImages = "SELECT * FROM tbl_image WHERE VendorID = $VendorID";
                        $resultImages = mysqli_query($conn, $sqlImages);

                        if ($resultImages && mysqli_num_rows($resultImages) > 0) {
                            echo "<h3>Uploaded Images</h3>";
                            echo "<div class='image-gallery'>";
                            while ($image = mysqli_fetch_assoc($resultImages)) {
                                echo "<div class='card'>";
                                echo "<img src='uploads/album_images/" . htmlspecialchars($image['Image']) . "' alt='Vendor Image'>";
                                echo "</div>";
                            }
                            echo "</div>";
                        } else {
                            echo "<p>No images found for this vendor.</p>";
                        }
                    } else {
                        echo "<p>Invalid or missing Vendor ID.</p>";
                    }

                    mysqli_close($conn);
                    ?>
                </div>
                <div class="col-md-4 booking-form">
                    <h3>Booking Form</h3>
                    <form id="bookingForm" action="process_booking.php" method="POST">
                        <div class="form-group">
                            <label for="customerName">Name</label>
                            <input type="text" class="form-control" id="customerName" name="customer_name" value="<?php echo isset($_SESSION['user']['Name']) ? htmlspecialchars($_SESSION['user']['Name']) : ''; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="contactNumber">Contact Number</label>
                            <input type="tel" class="form-control" id="contactNumber" name="contact_number" value="<?php echo isset($_SESSION['user']['Contact_Number']) ? htmlspecialchars($_SESSION['user']['Contact_Number']) : ''; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="email">Email ID</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : ''; ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label>Event Type</label>
                            <select class="form-control" id="event_type" name="event_type" required>
                                <option value="wedding">Wedding</option>
                                <option value="engagement">Engagement</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="start_event_date_time">Start Event Date and Time</label>
                            <input type="datetime-local" class="form-control" id="startEventDateTime" name="start_event_date_time" required>
                        </div>
                        <div class="form-group">
                            <label for="end_event_date_time">End Event Date and Time</label>
                            <input type="datetime-local" class="form-control" id="endEventDateTime" name="end_event_date_time" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Event Location</label>
                            <textarea class="form-control" id="address" name="address"><?php echo isset($venue) ? htmlspecialchars($venue['Address']) : ''; ?></textarea>
                        </div>
                        <input type="hidden" name="booking_price" id="booking_price" value="<?php echo htmlspecialchars($bookingPrice); ?>">
                        <input type="hidden" name="venue_detail_id" id="venue_detail_id" value="<?php echo htmlspecialchars($VenueDetailID); ?>">
                        <input type="hidden" name="vendor_id" id="vendor_id" value="<?php echo htmlspecialchars($VendorID); ?>">
                        <button type="submit" class="btn btn-primary">Book Now</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>

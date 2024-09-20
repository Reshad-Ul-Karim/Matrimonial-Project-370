<?php

function generateUserId($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Connect to the database (use your DBconnect file)
    require 'DBconnect.php';
    
    // Sanitize and collect form inputs
    $userId = generateUserId(); // Generate user ID
    $firstName = htmlspecialchars($_POST['first_name']);
    $middleName = isset($_POST['middle_name']) ? htmlspecialchars($_POST['middle_name']) : ''; // Set to empty if not provided
    $lastName = htmlspecialchars($_POST['last_name']);
    $dob = htmlspecialchars($_POST['dob']);
    $gender = htmlspecialchars($_POST['gender']);
    $profession = htmlspecialchars($_POST['profession']);
    $religion = htmlspecialchars($_POST['religion']);
    $ethnicity = htmlspecialchars($_POST['ethnicity']);  // Capture ethnicity
    $email = htmlspecialchars($_POST['email']);
    $nid = htmlspecialchars($_POST['nid']);  // Ensure NID is captured
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Start a database transaction to ensure data consistency
    mysqli_begin_transaction($conn);

    try {
        // Insert the data into the 'User' table
        $query = "INSERT INTO User (user_id, First_Name, Middle_Name, Last_Name, DOB, Gender, Profession, Religion, Ethnicity, Email, NID, Password, Registration_Date, Account_Status) 
                  VALUES ('$userId', '$firstName', '$middleName', '$lastName', '$dob', '$gender', '$profession', '$religion', '$ethnicity', '$email', '$nid', '$password', CURDATE(), 'Active')";
        
        if (!mysqli_query($conn, $query)) {
            throw new Exception("Error inserting user data: " . mysqli_error($conn));
        }

        // Insert default values into the 'Profile_Details' table
        $profileQuery = "INSERT INTO Profile_Details (user_id, Secondary_Education, Higher_Secondary, road_number, street_number, building_number, phone_number, Marital_Status, Height, Weight, Complexion, Biography) 
                         VALUES ('$userId', '', '', '', '', '', '', 'Single', 0, 0, 'Medium', '')";
        
        if (!mysqli_query($conn, $profileQuery)) {
            throw new Exception("Error inserting profile details: " . mysqli_error($conn));
        }

        // Insert default preferences into the 'Preferences' table
        $preferencesQuery = "INSERT INTO Preferences (user_id) VALUES ('$userId')";
        
        if (!mysqli_query($conn, $preferencesQuery)) {
            throw new Exception("Error inserting preferences: " . mysqli_error($conn));
        }

        // Insert the registration activity into the 'User_Activity_Log' table
        $activityLogQuery = "INSERT INTO User_Activity_Log (user_id, activity) VALUES ('$userId', 'User registered')";
        
        if (!mysqli_query($conn, $activityLogQuery)) {
            throw new Exception("Error inserting activity log: " . mysqli_error($conn));
        }

        // Commit the transaction
        mysqli_commit($conn);

        // Redirect to login or logout page on success
        header("Location: logout.php");
        exit();

    } catch (Exception $e) {
        // Rollback the transaction if something goes wrong
        mysqli_rollback($conn);
        echo $e->getMessage();
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Profile</title>
    <style>
        /* Gradient background */
        /* Gradient background */
                    body {
                        margin: 0;
                        font-family: 'Arial', sans-serif;
                        background: linear-gradient(135deg, #ff6f61, #ffe5b4);
                        min-height: 100vh; /* Use min-height instead of height for better scaling */
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        padding: 20px; /* Add padding to ensure spacing on small screens */
                    }

                    /* Form container */
                    .profile-container {
                        background-color: #ffffff;
                        padding: 20px;
                        width: 100%; /* Adjust width for small screens */
                        max-width: 400px; /* Keep a max-width for larger screens */
                        border-radius: 15px;
                        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
                        animation: slideIn 0.6s ease-out; /* Slide-in animation */
                    }

                    /* Input fields styling */
                    input[type="text"], input[type="date"], input[type="email"], input[type="password"], select {
                        width: 100%; /* Use 100% width for better responsiveness */
                        padding: 10px;
                        margin-bottom: 15px;
                        border-radius: 5px;
                        border: 1px solid #ccc;
                        box-sizing: border-box;
                        transition: border-color 0.3s ease;
                    }

                    input:focus {
                        border-color: #ff6f61; /* Highlight border on focus */
                        outline: none;
                    }

                    /* Submit button styling */
                    .submit-btn {
                        width: 100%;
                        padding: 10px;
                        background-color: #ff6f61;
                        color: white;
                        border: none;
                        border-radius: 5px;
                        font-size: 16px;
                        cursor: pointer;
                        transition: background-color 0.3s ease;
                        margin: 2px;
                    }

                    .submit-btn:hover {
                        background-color: #ff4f41; /* Darker color on hover */
                    }

                    /* Heading styling */
                    h2 {
                        text-align: center;
                        color: #ff6f61;
                        margin-bottom: 20px;
                    }

                    /* Keyframe animation for form container */
                    @keyframes slideIn {
                        from {
                            opacity: 0;
                            transform: translateY(30px);
                        }
                        to {
                            opacity: 1;
                            transform: translateY(0);
                        }
                    }

                    /* Animation for input fields */
                    .profile-container input, .profile-container select {
                        animation: fadeIn 1s ease forwards;
                    }

                    @keyframes fadeIn {
                        from {
                            opacity: 0;
                        }
                        to {
                            opacity: 1;
                        }
                    }

                    /* Subtle background animation */
                    body:before {
                        content: '';
                        position: absolute;
                        top: -50px;
                        left: -50px;
                        right: -50px;
                        bottom: -50px;
                        background: linear-gradient(135deg, rgba(255, 111, 97, 0.6), rgba(255, 229, 180, 0.6));
                        z-index: -1;
                        animation: animateBg 5s ease-in-out infinite;
                    }

                    @keyframes animateBg {
                        0% {
                            background-position: 0 0;
                        }
                        50% {
                            background-position: 100% 100%;
                        }
                        100% {
                            background-position: 0 0;
                        }
                    }

                    /* Add responsive scaling for smaller screens */
                    @media (max-width: 600px) {
                        .profile-container {
                            padding: 15px;
                            max-width: 100%; /* Allow container to take full width on small screens */
                        }
                    }

    </style>
</head>
<body>

<div class="profile-container">
    <h2>Create Your Profile</h2>
    <form method="POST">
        <label for="first_name">First Name</label>
        <input type="text" name="first_name" id="first_name" required>
        <label for="Middle_name">Middle Name</label>
        <input type="text" name="middle_name" id="middle_name">
        <label for="last_name">Last Name</label>
        <input type="text" name="last_name" id="last_name" required>

        <label for="dob">Date of Birth</label>
        <input type="date" name="dob" id="dob" required>

        <label for="gender">Gender</label>
        <select name="gender" id="gender" required>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select>
    
        <label for="profession">Profession</label>
        <select name="profession" id="profession" required>
        <optgroup label="Technology and IT">
            <option value="software-engineer">Software Engineer</option>
            <option value="data-scientist">Data Scientist</option>
            <option value="it-support-specialist">IT Support Specialist</option>
            <option value="web-developer">Web Developer</option>
            <option value="cybersecurity-analyst">Cybersecurity Analyst</option>
            <option value="cloud-engineer">Cloud Engineer</option>
            <option value="network-administrator">Network Administrator</option>
            <option value="mobile-app-developer">Mobile App Developer</option>
            <option value="ux-ui-designer">UX/UI Designer</option>
        <option value="blockchain-developer">Blockchain Developer</option>
            <option value="ai-engineer">Artificial Intelligence Engineer</option>
        <option value="game-developer">Game Developer</option>
    </optgroup>
    <optgroup label="Healthcare and Medicine">
        <option value="doctor">Doctor/Physician</option>
        <option value="nurse">Nurse</option>
        <option value="dentist">Dentist</option>
        <option value="pharmacist">Pharmacist</option>
        <option value="physical-therapist">Physical Therapist</option>
        <option value="psychologist">Psychologist</option>
        <option value="medical-research-scientist">Medical Research Scientist</option>
        <option value="occupational-therapist">Occupational Therapist</option>
        <option value="radiologist">Radiologist</option>
        <option value="paramedic">Paramedic</option>
        <option value="optometrist">Optometrist</option>
        <option value="veterinarian">Veterinarian</option>
    </optgroup>
    <optgroup label="Engineering and Architecture">
        <option value="civil-engineer">Civil Engineer</option>
        <option value="mechanical-engineer">Mechanical Engineer</option>
        <option value="electrical-engineer">Electrical Engineer</option>
        <option value="chemical-engineer">Chemical Engineer</option>
        <option value="aerospace-engineer">Aerospace Engineer</option>
        <option value="environmental-engineer">Environmental Engineer</option>
        <option value="biomedical-engineer">Biomedical Engineer</option>
        <option value="industrial-engineer">Industrial Engineer</option>
        <option value="architect">Architect</option>
        <option value="urban-planner">Urban Planner</option>
        <option value="structural-engineer">Structural Engineer</option>
    </optgroup>
    <optgroup label="Business and Finance">
        <option value="accountant">Accountant</option>
        <option value="financial-analyst">Financial Analyst</option>
        <option value="investment-banker">Investment Banker</option>
        <option value="hr-manager">Human Resources Manager</option>
        <option value="marketing-manager">Marketing Manager</option>
        <option value="sales-manager">Sales Manager</option>
        <option value="business-consultant">Business Consultant</option>
        <option value="project-manager">Project Manager</option>
        <option value="entrepreneur">Entrepreneur</option>
        <option value="economist">Economist</option>
        <option value="real-estate-agent">Real Estate Agent</option>
        <option value="operations-manager">Operations Manager</option>
    </optgroup>
    <optgroup label="Creative Arts and Design">
        <option value="graphic-designer">Graphic Designer</option>
        <option value="interior-designer">Interior Designer</option>
        <option value="fashion-designer">Fashion Designer</option>
        <option value="photographer">Photographer</option>
        <option value="animator">Animator</option>
        <option value="art-director">Art Director</option>
        <option value="copywriter">Copywriter</option>
        <option value="music-producer">Music Producer</option>
        <option value="video-editor">Video Editor</option>
        <option value="game-designer">Game Designer</option>
        <option value="illustrator">Illustrator</option>
    </optgroup>
    <optgroup label="Education and Training">
        <option value="teacher">Teacher</option>
        <option value="university-professor">University Professor</option>
        <option value="school-counselor">School Counselor</option>
        <option value="corporate-trainer">Corporate Trainer</option>
        <option value="educational-consultant">Educational Consultant</option>
        <option value="librarian">Librarian</option>
        <option value="curriculum-developer">Curriculum Developer</option>
        <option value="special-education-teacher">Special Education Teacher</option>
        <option value="researcher">Researcher</option>
    </optgroup> 
    <optgroup label="Law and Public Services">
        <option value="lawyer">Lawyer</option>
        <option value="paralegal">Paralegal</option>
        <option value="judge">Judge</option>
        <option value="police-officer">Police Officer</option>
        <option value="firefighter">Firefighter</option>
        <option value="social-worker">Social Worker</option>
        <option value="politician">Politician</option>
        <option value="diplomat">Diplomat</option>
        <option value="public-relations-specialist">Public Relations Specialist</option>
        <option value="probation-officer">Probation Officer</option>
    </optgroup>
    <optgroup label="Science and Research">
        <option value="biologist">Biologist</option>
        <option value="chemist">Chemist</option>
        <option value="physicist">Physicist</option>
        <option value="environmental-scientist">Environmental Scientist</option>
        <option value="geologist">Geologist</option>
        <option value="astronomer">Astronomer</option>
        <option value="forensic-scientist">Forensic Scientist</option>
        <option value="marine-biologist">Marine Biologist</option>
        <option value="meteorologist">Meteorologist</option>
        <option value="geneticist">Geneticist</option>
    </optgroup>
    <optgroup label="Media and Communication">
        <option value="journalist">Journalist</option>
        <option value="news-anchor">News Anchor</option>
        <option value="public-relations-specialist">Public Relations Specialist</option>
        <option value="content-writer">Content Writer</option>
        <option value="editor">Editor</option>
        <option value="blogger">Blogger</option>
        <option value="radio-host">Radio Host</option>
        <option value="film-director">Film Director</option>
        <option value="social-media-manager">Social Media Manager</option>
        <option value="podcast-producer">Podcast Producer</option>
    </optgroup>
    <optgroup label="Trades and Skilled Labor">
        <option value="electrician">Electrician</option>
        <option value="plumber">Plumber</option>
        <option value="carpenter">Carpenter</option>
        <option value="mechanic">Mechanic</option>
        <option value="welder">Welder</option>
        <option value="hvac-technician">HVAC Technician</option>
        <option value="truck-driver">Truck Driver</option>
        <option value="construction-worker">Construction Worker</option>
        <option value="landscaper">Landscaper</option>
        <option value="painter">Painter</option>
    </optgroup>
    <optgroup label="Hospitality and Tourism">
        <option value="hotel-manager">Hotel Manager</option>
        <option value="travel-agent">Travel Agent</option>
        <option value="chef">Chef</option>
        <option value="event-planner">Event Planner</option>
        <option value="flight-attendant">Flight Attendant</option>
        <option value="tour-guide">Tour Guide</option>
        <option value="restaurant-manager">Restaurant Manager</option>
        <option value="cruise-director">Cruise Director</option>
    </optgroup>
    <optgroup label="Sports and Fitness">
        <option value="professional-athlete">Professional Athlete</option>
        <option value="fitness-trainer">Fitness Trainer</option>
        <option value="sports-coach">Sports Coach</option>
        <option value="sports-analyst">Sports Analyst</option>
        <option value="physical-education-teacher">Physical Education Teacher</option>
        <option value="sports-psychologist">Sports Psychologist</option>
        <option value="sports-manager">Sports Manager</option>
    </optgroup>
    <optgroup label="Environment and Sustainability">
        <option value="environmental-consultant">Environmental Consultant</option>
        <option value="conservation-scientist">Conservation Scientist</option>
        <option value="ecologist">Ecologist</option>
        <option value="agricultural-scientist">Agricultural Scientist</option>
        <option value="renewable-energy-specialist">Renewable Energy Specialist</option>
        <option value="sustainability-coordinator">Sustainability Coordinator</option>
        <option value="wildlife-biologist">Wildlife Biologist</option>
    </optgroup>
    <optgroup label="Freelance and Remote Work">
        <option value="virtual-assistant">Virtual Assistant</option>
        <option value="freelance-writer">Freelance Writer</option>
        <option value="freelance-graphic-designer">Freelance Graphic Designer</option>
        <option value="online-tutor">Online Tutor</option>
        <option value="digital-marketing-consultant">Digital Marketing Consultant</option>
        <option value="e-commerce-specialist">E-commerce Specialist</option>
        <option value="freelance-software-developer">Freelance Software Developer</option>
    </optgroup>
</select>


        <label for="religion">Religion</label>
        <select name="religion" id="religion" required>
            <option value="Muslim">Muslim</option>
            <option value="Hindu">Hindu</option>
            <option value="Christian">Christian</option>
            <option value="Buddhist">Buddhist</option>
        </select>

        <label for="ethnicity">Ethnicity</label>
            <select name="ethnicity" id="ethnicity" required>
                <option value="Caucasian">Caucasian</option>
                <option value="African">African</option>
                <option value="Asian">Asian</option>
                <option value="Hispanic">Hispanic</option>
                <option value="Middle Eastern">Middle Eastern</option>
                <option value="Native American">Native American</option>
                <option value="Pacific Islander">Pacific Islander</option>
                <option value="Other">Other</option>
            </select>


        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>

        <label for="nid">NID NO.</label>
        <input type="text" name="nid" id="nid" required>
        
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>

        <button type="submit" class="submit-btn">Create Profile</button>

        <button type="submit" class="submit-btn" onclick="window.location.href='index.php';">Already have an account</button>
    </form>


</div>

</body>
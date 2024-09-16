<?php
// Start session to access session variables
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirect to login page if not logged in
    exit();
}

// Include database connection file
include('DBconnect.php'); // Modify this line according to your database connection setup

// Get the user_id from session
$user_id = $_SESSION['user_id'];

// Initialize default values as empty in case no profile details are found
$email = $profession = $dob = $gender = $religion = $ethnicity = $first_name = $middle_name = $last_name = $profile_photo_url = '';
$secondary_education = $higher_secondary = $undergrade = $post_grade = $road_number = $street_number = $building_number = $phone_number = $marital_status = $interest = $hobbies = $height = $weight = $complexion = $biography = $family_background = '';

// Handle form submission for editing the profile
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $profession = $_POST['profession'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $religion = $_POST['religion'];
    $ethnicity = $_POST['ethnicity'];
    $marital_status = $_POST['marital_status'];
    $secondary_education = $_POST['secondary_education'];
    $higher_secondary = $_POST['higher_secondary'];
    $undergrade = $_POST['undergrade'];
    $post_grade = $_POST['post_grade'];
    $road_number = $_POST['road_number'];
    $street_number = $_POST['street_number'];
    $building_number = $_POST['building_number'];
    $interest = $_POST['interest'];
    $hobbies = $_POST['hobbies'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];
    $complexion = $_POST['complexion'];
    $biography = $_POST['biography'];
    $family_background = $_POST['family_background'];

    // Update profile details in the database
    $sql_update = "
    UPDATE User u
    JOIN Profile_Details pd ON u.user_id = pd.user_id
    SET 
        u.First_Name = ?, u.Middle_Name = ?, u.Last_Name = ?, u.Profession = ?, u.Email = ?, u.DOB = ?, u.Gender = ?, u.Religion = ?, u.Ethnicity = ?,
        pd.phone_number = ?, pd.Marital_Status = ?, pd.Secondary_Education = ?, pd.Higher_Secondary = ?, pd.Undergrade = ?, pd.Post_Grade = ?, pd.road_number = ?, pd.street_number = ?, pd.building_number = ?, pd.Interest = ?, pd.Hobbies = ?, pd.Height = ?, pd.Weight = ?, pd.Complexion = ?, pd.Biography = ?, pd.Family_Background = ?
    WHERE u.user_id = ?
    ";

    if ($stmt = $conn->prepare($sql_update)) {
        $stmt->bind_param(
            "ssssssssssssssssssssssssss", // 26 placeholders
            $first_name, $middle_name, $last_name, $profession, $email, $dob, $gender, $religion, $ethnicity, 
            $phone_number, $marital_status, $secondary_education, $higher_secondary, $undergrade, $post_grade, 
            $road_number, $street_number, $building_number, $interest, $hobbies, $height, $weight, $complexion, 
            $biography, $family_background, $user_id // 26 variables
        );

        if ($stmt->execute()) {
            echo "<script>alert('Profile updated successfully!');</script>"; // Changed echo to alert
        } else {
            echo "<script>alert('Error updating profile.');</script>"; // Changed echo to alert
        }
        $stmt->close();
    } else {
        echo "<script>alert('Error in query execution.');</script>"; // Changed echo to alert
    }
}

// Fetch profile details query
$sql = "
SELECT 
    u.Email, u.Profession, u.DOB, u.Gender, u.Religion, u.Ethnicity, u.First_Name, u.Middle_Name, u.Last_Name, 
    pd.Secondary_Education, pd.Higher_Secondary, pd.Undergrade, pd.Post_Grade, 
    pd.road_number, pd.street_number, pd.building_number, pd.phone_number, 
    pd.Marital_Status, pd.Interest, pd.Hobbies, pd.Height, pd.Weight, pd.Complexion, pd.Biography, pd.Family_Background,
    u.Profile_Photo_URL
FROM User u
LEFT JOIN Profile_Details pd ON u.user_id = pd.user_id
WHERE u.user_id = ?
";

// Prepare and execute query
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("s", $user_id); // Bind the user_id parameter
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any user details are found
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Assign values from the query to variables, use the default empty if not found
        $email = $row['Email'];
        $profession = $row['Profession'];
        $dob = $row['DOB'];
        $gender = $row['Gender'];
        $religion = $row['Religion'];
        $ethnicity = $row['Ethnicity'];
        $first_name = $row['First_Name'];
        $middle_name = $row['Middle_Name'];
        $last_name = $row['Last_Name'];
        $profile_photo_url = $row['Profile_Photo_URL'];
        
        $secondary_education = $row['Secondary_Education'];
        $higher_secondary = $row['Higher_Secondary'];
        $undergrade = $row['Undergrade'];
        $post_grade = $row['Post_Grade'];
        $road_number = $row['road_number'];
        $street_number = $row['street_number'];
        $building_number = $row['building_number'];
        $phone_number = $row['phone_number'];
        $marital_status = $row['Marital_Status'];
        $interest = $row['Interest'];
        $hobbies = $row['Hobbies'];
        $height = $row['Height'];
        $weight = $row['Weight'];
        $complexion = $row['Complexion'];
        $biography = $row['Biography'];
        $family_background = $row['Family_Background'];
    }
    $stmt->close();
} else {
    echo "Error in query execution.";
    exit();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Product+Sans&display=swap');
        /* Styling for the form */
        body {
            margin: 0;
            font-family: 'Product Sans', Arial, sans-serif;
            background: linear-gradient(135deg, #ff6f61, #ffe5b4);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .profile-container {
            background-color: #ffffff;
            padding: 20px;
            width: 600px;
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            margin: 40px 0;
        }
        input[type="text"], input[type="date"], input[type="email"], input[type="password"], input[type="number"], select, textarea {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }
        input[type="checkbox"] { margin-right: 10px; }
        input:focus, select:focus, textarea:focus { border-color: #ff6f61; outline: none; }
        .submit-btn { margin:2px; width: 100%; padding: 10px; background-color: #ff6f61; color: white; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; transition: background-color 0.3s ease; }
        .submit-btn:hover { background-color: #ff4f41; }
        h2 { text-align: center; color: #ff6f61; margin-bottom: 20px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        .checkbox-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 10px; margin-bottom: 15px; }
        textarea { resize: vertical; }
        body:before { content: ''; position: absolute; top: -50px; left: -50px; right: -50px; bottom: -50px; background: linear-gradient(135deg, rgba(255, 111, 97, 0.6), rgba(255, 229, 180, 0.6)); z-index: -1; }
    </style>
</head>
<body>

<div class="profile-container">
    <h2>Edit Profile</h2>
    <form method="POST" action="my_profile_details.php">
        <!-- Personal Information -->
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" value="<?= htmlspecialchars($first_name) ?>" required>

        <label for="middle_name">Middle Name:</label>
        <input type="text" name="middle_name" value="<?= htmlspecialchars($middle_name) ?>">

        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" value="<?= htmlspecialchars($last_name) ?>" required>

        <label for="dob">Date of Birth:</label>
        <input type="date" name="dob" value="<?= htmlspecialchars($dob) ?>" required>

        <label for="gender">Gender:</label>
        <select name="gender" required>
            <option value="Male" <?= ($gender == 'Male') ? 'selected' : '' ?>>Male</option>
            <option value="Female" <?= ($gender == 'Female') ? 'selected' : '' ?>>Female</option>
            <option value="Other" <?= ($gender == 'Other') ? 'selected' : '' ?>>Other</option>
        </select>

        <label for="religion">Religion</label>
        <select name="religion" required>
            <option value="Muslim" <?= ($religion == 'Muslim') ? 'selected' : '' ?>>Muslim</option>
            <option value="Hindu" <?= ($religion == 'Hindu') ? 'selected' : '' ?>>Hindu</option>
            <option value="Christian" <?= ($religion == 'Christian') ? 'selected' : '' ?>>Christian</option>
            <option value="Buddhist" <?= ($religion == 'Buddhist') ? 'selected' : '' ?>>Buddhist</option>
        </select>

        <label for="ethnicity">Ethnicity</label>
        <select name="ethnicity" required>
            <option value="Caucasian" <?= ($ethnicity == 'Caucasian') ? 'selected' : '' ?>>Caucasian</option>
            <option value="African" <?= ($ethnicity == 'African') ? 'selected' : '' ?>>African</option>
            <option value="Asian" <?= ($ethnicity == 'Asian') ? 'selected' : '' ?>>Asian</option>
            <option value="Hispanic" <?= ($ethnicity == 'Hispanic') ? 'selected' : '' ?>>Hispanic</option>
            <option value="Middle Eastern" <?= ($ethnicity == 'Middle Eastern') ? 'selected' : '' ?>>Middle Eastern</option>
            <option value="Native American" <?= ($ethnicity == 'Native American') ? 'selected' : '' ?>>Native American</option>
            <option value="Pacific Islander" <?= ($ethnicity == 'Pacific Islander') ? 'selected' : '' ?>>Pacific Islander</option>
            <option value="Other" <?= ($ethnicity == 'Other') ? 'selected' : '' ?>>Other</option>
        </select>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" required>

        <label for="phone_number">Phone Number:</label>
        <input type="text" name="phone_number" value="<?= htmlspecialchars($phone_number) ?>">

        <!-- Education Details -->
        <h2>Education</h2>
        <label for="secondary_education">Secondary Education:</label>
        <input type="text" name="secondary_education" value="<?= htmlspecialchars($secondary_education) ?>">

        <label for="higher_secondary">Higher Secondary:</label>
        <input type="text" name="higher_secondary" value="<?= htmlspecialchars($higher_secondary) ?>">

        <label for="undergrade">Undergraduate:</label>
        <input type="text" name="undergrade" value="<?= htmlspecialchars($undergrade) ?>">

        <label for="post_grade">Postgraduate:</label>
        <input type="text" name="post_grade" value="<?= htmlspecialchars($post_grade) ?>">

        <!-- Address Information -->
        <h2>Address</h2>
        <label for="road_number">Road Number:</label>
        <input type="text" name="road_number" value="<?= htmlspecialchars($road_number) ?>">

        <label for="street_number">Street Number:</label>
        <input type="text" name="street_number" value="<?= htmlspecialchars($street_number) ?>">

        <label for="building_number">Building Number:</label>
        <input type="text" name="building_number" value="<?= htmlspecialchars($building_number) ?>">

        <!-- Additional Details -->
        <h2>Personal Details</h2>
        <label for="marital_status">Marital Status:</label>
        <select name="marital_status" required>
            <option value="Single" <?= ($marital_status == 'Single') ? 'selected' : '' ?>>Single</option>
            <option value="Married" <?= ($marital_status == 'Married') ? 'selected' : '' ?>>Married</option>
            <option value="Divorced" <?= ($marital_status == 'Divorced') ? 'selected' : '' ?>>Divorced</option>
        </select>

        <label for="profession">Profession</label>
        <select name="profession" required>
            <optgroup label="Technology and IT">
                <option value="software-engineer" <?= ($profession == 'software-engineer') ? 'selected' : '' ?>>Software Engineer</option>
                <option value="data-scientist" <?= ($profession == 'data-scientist') ? 'selected' : '' ?>>Data Scientist</option>
                <option value="it-support-specialist" <?= ($profession == 'it-support-specialist') ? 'selected' : '' ?>>IT Support Specialist</option>
                <option value="web-developer" <?= ($profession == 'web-developer') ? 'selected' : '' ?>>Web Developer</option>
                <option value="cybersecurity-analyst" <?= ($profession == 'cybersecurity-analyst') ? 'selected' : '' ?>>Cybersecurity Analyst</option>
                <option value="cloud-engineer" <?= ($profession == 'cloud-engineer') ? 'selected' : '' ?>>Cloud Engineer</option>
                <option value="network-administrator" <?= ($profession == 'network-administrator') ? 'selected' : '' ?>>Network Administrator</option>
                <option value="mobile-app-developer" <?= ($profession == 'mobile-app-developer') ? 'selected' : '' ?>>Mobile App Developer</option>
                <option value="ux-ui-designer" <?= ($profession == 'ux-ui-designer') ? 'selected' : '' ?>>UX/UI Designer</option>
                <option value="blockchain-developer" <?= ($profession == 'blockchain-developer') ? 'selected' : '' ?>>Blockchain Developer</option>
                <option value="ai-engineer" <?= ($profession == 'ai-engineer') ? 'selected' : '' ?>>Artificial Intelligence Engineer</option>
                <option value="game-developer" <?= ($profession == 'game-developer') ? 'selected' : '' ?>>Game Developer</option>
            </optgroup>
            
            <optgroup label="Healthcare and Medicine">
                <option value="doctor" <?= ($profession == 'doctor') ? 'selected' : '' ?>>Doctor/Physician</option>
                <option value="nurse" <?= ($profession == 'nurse') ? 'selected' : '' ?>>Nurse</option>
                <option value="dentist" <?= ($profession == 'dentist') ? 'selected' : '' ?>>Dentist</option>
                <option value="pharmacist" <?= ($profession == 'pharmacist') ? 'selected' : '' ?>>Pharmacist</option>
                <option value="physical-therapist" <?= ($profession == 'physical-therapist') ? 'selected' : '' ?>>Physical Therapist</option>
                <option value="psychologist" <?= ($profession == 'psychologist') ? 'selected' : '' ?>>Psychologist</option>
                <option value="medical-research-scientist" <?= ($profession == 'medical-research-scientist') ? 'selected' : '' ?>>Medical Research Scientist</option>
                <option value="occupational-therapist" <?= ($profession == 'occupational-therapist') ? 'selected' : '' ?>>Occupational Therapist</option>
                <option value="radiologist" <?= ($profession == 'radiologist') ? 'selected' : '' ?>>Radiologist</option>
                <option value="paramedic" <?= ($profession == 'paramedic') ? 'selected' : '' ?>>Paramedic</option>
                <option value="optometrist" <?= ($profession == 'optometrist') ? 'selected' : '' ?>>Optometrist</option>
                <option value="veterinarian" <?= ($profession == 'veterinarian') ? 'selected' : '' ?>>Veterinarian</option>
            </optgroup>
            
            <optgroup label="Engineering and Architecture">
                <option value="civil-engineer" <?= ($profession == 'civil-engineer') ? 'selected' : '' ?>>Civil Engineer</option>
                <option value="mechanical-engineer" <?= ($profession == 'mechanical-engineer') ? 'selected' : '' ?>>Mechanical Engineer</option>
                <option value="electrical-engineer" <?= ($profession == 'electrical-engineer') ? 'selected' : '' ?>>Electrical Engineer</option>
                <option value="chemical-engineer" <?= ($profession == 'chemical-engineer') ? 'selected' : '' ?>>Chemical Engineer</option>
                <option value="aerospace-engineer" <?= ($profession == 'aerospace-engineer') ? 'selected' : '' ?>>Aerospace Engineer</option>
                <option value="environmental-engineer" <?= ($profession == 'environmental-engineer') ? 'selected' : '' ?>>Environmental Engineer</option>
                <option value="biomedical-engineer" <?= ($profession == 'biomedical-engineer') ? 'selected' : '' ?>>Biomedical Engineer</option>
                <option value="industrial-engineer" <?= ($profession == 'industrial-engineer') ? 'selected' : '' ?>>Industrial Engineer</option>
                <option value="architect" <?= ($profession == 'architect') ? 'selected' : '' ?>>Architect</option>
                <option value="urban-planner" <?= ($profession == 'urban-planner') ? 'selected' : '' ?>>Urban Planner</option>
                <option value="structural-engineer" <?= ($profession == 'structural-engineer') ? 'selected' : '' ?>>Structural Engineer</option>
            </optgroup>
            
            <optgroup label="Business and Finance">
                <option value="accountant" <?= ($profession == 'accountant') ? 'selected' : '' ?>>Accountant</option>
                <option value="financial-analyst" <?= ($profession == 'financial-analyst') ? 'selected' : '' ?>>Financial Analyst</option>
                <option value="investment-banker" <?= ($profession == 'investment-banker') ? 'selected' : '' ?>>Investment Banker</option>
                <option value="hr-manager" <?= ($profession == 'hr-manager') ? 'selected' : '' ?>>Human Resources Manager</option>
                <option value="marketing-manager" <?= ($profession == 'marketing-manager') ? 'selected' : '' ?>>Marketing Manager</option>
                <option value="sales-manager" <?= ($profession == 'sales-manager') ? 'selected' : '' ?>>Sales Manager</option>
                <option value="business-consultant" <?= ($profession == 'business-consultant') ? 'selected' : '' ?>>Business Consultant</option>
                <option value="project-manager" <?= ($profession == 'project-manager') ? 'selected' : '' ?>>Project Manager</option>
                <option value="entrepreneur" <?= ($profession == 'entrepreneur') ? 'selected' : '' ?>>Entrepreneur</option>
                <option value="economist" <?= ($profession == 'economist') ? 'selected' : '' ?>>Economist</option>
                <option value="real-estate-agent" <?= ($profession == 'real-estate-agent') ? 'selected' : '' ?>>Real Estate Agent</option>
                <option value="operations-manager" <?= ($profession == 'operations-manager') ? 'selected' : '' ?>>Operations Manager</option>
            </optgroup>
            
            <optgroup label="Creative Arts and Design">
                <option value="graphic-designer" <?= ($profession == 'graphic-designer') ? 'selected' : '' ?>>Graphic Designer</option>
                <option value="interior-designer" <?= ($profession == 'interior-designer') ? 'selected' : '' ?>>Interior Designer</option>
                <option value="fashion-designer" <?= ($profession == 'fashion-designer') ? 'selected' : '' ?>>Fashion Designer</option>
                <option value="photographer" <?= ($profession == 'photographer') ? 'selected' : '' ?>>Photographer</option>
                <option value="animator" <?= ($profession == 'animator') ? 'selected' : '' ?>>Animator</option>
                <option value="art-director" <?= ($profession == 'art-director') ? 'selected' : '' ?>>Art Director</option>
                <option value="copywriter" <?= ($profession == 'copywriter') ? 'selected' : '' ?>>Copywriter</option>
                <option value="music-producer" <?= ($profession == 'music-producer') ? 'selected' : '' ?>>Music Producer</option>
                <option value="video-editor" <?= ($profession == 'video-editor') ? 'selected' : '' ?>>Video Editor</option>
                <option value="game-designer" <?= ($profession == 'game-designer') ? 'selected' : '' ?>>Game Designer</option>
                <option value="illustrator" <?= ($profession == 'illustrator') ? 'selected' : '' ?>>Illustrator</option>
            </optgroup>
            
            <optgroup label="Education and Training">
                <option value="teacher" <?= ($profession == 'teacher') ? 'selected' : '' ?>>Teacher</option>
                <option value="university-professor" <?= ($profession == 'university-professor') ? 'selected' : '' ?>>University Professor</option>
                <option value="school-counselor" <?= ($profession == 'school-counselor') ? 'selected' : '' ?>>School Counselor</option>
                <option value="corporate-trainer" <?= ($profession == 'corporate-trainer') ? 'selected' : '' ?>>Corporate Trainer</option>
                <option value="educational-consultant" <?= ($profession == 'educational-consultant') ? 'selected' : '' ?>>Educational Consultant</option>
                <option value="librarian" <?= ($profession == 'librarian') ? 'selected' : '' ?>>Librarian</option>
                <option value="curriculum-developer" <?= ($profession == 'curriculum-developer') ? 'selected' : '' ?>>Curriculum Developer</option>
                <option value="special-education-teacher" <?= ($profession == 'special-education-teacher') ? 'selected' : '' ?>>Special Education Teacher</option>
                <option value="researcher" <?= ($profession == 'researcher') ? 'selected' : '' ?>>Researcher</option>
            </optgroup>
            
            <optgroup label="Law and Public Services">
                <option value="lawyer" <?= ($profession == 'lawyer') ? 'selected' : '' ?>>Lawyer</option>
                <option value="paralegal" <?= ($profession == 'paralegal') ? 'selected' : '' ?>>Paralegal</option>
                <option value="judge" <?= ($profession == 'judge') ? 'selected' : '' ?>>Judge</option>
                <option value="police-officer" <?= ($profession == 'police-officer') ? 'selected' : '' ?>>Police Officer</option>
                <option value="firefighter" <?= ($profession == 'firefighter') ? 'selected' : '' ?>>Firefighter</option>
                <option value="social-worker" <?= ($profession == 'social-worker') ? 'selected' : '' ?>>Social Worker</option>
                <option value="politician" <?= ($profession == 'politician') ? 'selected' : '' ?>>Politician</option>
                <option value="diplomat" <?= ($profession == 'diplomat') ? 'selected' : '' ?>>Diplomat</option>
                <option value="public-relations-specialist" <?= ($profession == 'public-relations-specialist') ? 'selected' : '' ?>>Public Relations Specialist</option>
                <option value="probation-officer" <?= ($profession == 'probation-officer') ? 'selected' : '' ?>>Probation Officer</option>
            </optgroup>
            
            <optgroup label="Science and Research">
                <option value="biologist" <?= ($profession == 'biologist') ? 'selected' : '' ?>>Biologist</option>
                <option value="chemist" <?= ($profession == 'chemist') ? 'selected' : '' ?>>Chemist</option>
                <option value="physicist" <?= ($profession == 'physicist') ? 'selected' : '' ?>>Physicist</option>
                <option value="environmental-scientist" <?= ($profession == 'environmental-scientist') ? 'selected' : '' ?>>Environmental Scientist</option>
                <option value="geologist" <?= ($profession == 'geologist') ? 'selected' : '' ?>>Geologist</option>
                <option value="astronomer" <?= ($profession == 'astronomer') ? 'selected' : '' ?>>Astronomer</option>
                <option value="forensic-scientist" <?= ($profession == 'forensic-scientist') ? 'selected' : '' ?>>Forensic Scientist</option>
                <option value="marine-biologist" <?= ($profession == 'marine-biologist') ? 'selected' : '' ?>>Marine Biologist</option>
                <option value="meteorologist" <?= ($profession == 'meteorologist') ? 'selected' : '' ?>>Meteorologist</option>
                <option value="geneticist" <?= ($profession == 'geneticist') ? 'selected' : '' ?>>Geneticist</option>
            </optgroup>
            
            <optgroup label="Media and Communication">
                <option value="journalist" <?= ($profession == 'journalist') ? 'selected' : '' ?>>Journalist</option>
                <option value="news-anchor" <?= ($profession == 'news-anchor') ? 'selected' : '' ?>>News Anchor</option>
                <option value="public-relations-specialist" <?= ($profession == 'public-relations-specialist') ? 'selected' : '' ?>>Public Relations Specialist</option>
                <option value="content-writer" <?= ($profession == 'content-writer') ? 'selected' : '' ?>>Content Writer</option>
                <option value="editor" <?= ($profession == 'editor') ? 'selected' : '' ?>>Editor</option>
                <option value="blogger" <?= ($profession == 'blogger') ? 'selected' : '' ?>>Blogger</option>
                <option value="radio-host" <?= ($profession == 'radio-host') ? 'selected' : '' ?>>Radio Host</option>
                <option value="film-director" <?= ($profession == 'film-director') ? 'selected' : '' ?>>Film Director</option>
                <option value="social-media-manager" <?= ($profession == 'social-media-manager') ? 'selected' : '' ?>>Social Media Manager</option>
                <option value="podcast-producer" <?= ($profession == 'podcast-producer') ? 'selected' : '' ?>>Podcast Producer</option>
            </optgroup>
            
            <optgroup label="Trades and Skilled Labor">
                <option value="electrician" <?= ($profession == 'electrician') ? 'selected' : '' ?>>Electrician</option>
                <option value="plumber" <?= ($profession == 'plumber') ? 'selected' : '' ?>>Plumber</option>
                <option value="carpenter" <?= ($profession == 'carpenter') ? 'selected' : '' ?>>Carpenter</option>
                <option value="mechanic" <?= ($profession == 'mechanic') ? 'selected' : '' ?>>Mechanic</option>
                <option value="welder" <?= ($profession == 'welder') ? 'selected' : '' ?>>Welder</option>
                <option value="hvac-technician" <?= ($profession == 'hvac-technician') ? 'selected' : '' ?>>HVAC Technician</option>
                <option value="truck-driver" <?= ($profession == 'truck-driver') ? 'selected' : '' ?>>Truck Driver</option>
                <option value="construction-worker" <?= ($profession == 'construction-worker') ? 'selected' : '' ?>>Construction Worker</option>
                <option value="landscaper" <?= ($profession == 'landscaper') ? 'selected' : '' ?>>Landscaper</option>
                <option value="painter" <?= ($profession == 'painter') ? 'selected' : '' ?>>Painter</option>
            </optgroup>
            
            <optgroup label="Hospitality and Tourism">
                <option value="hotel-manager" <?= ($profession == 'hotel-manager') ? 'selected' : '' ?>>Hotel Manager</option>
                <option value="travel-agent" <?= ($profession == 'travel-agent') ? 'selected' : '' ?>>Travel Agent</option>
                <option value="chef" <?= ($profession == 'chef') ? 'selected' : '' ?>>Chef</option>
                <option value="event-planner" <?= ($profession == 'event-planner') ? 'selected' : '' ?>>Event Planner</option>
                <option value="flight-attendant" <?= ($profession == 'flight-attendant') ? 'selected' : '' ?>>Flight Attendant</option>
                <option value="tour-guide" <?= ($profession == 'tour-guide') ? 'selected' : '' ?>>Tour Guide</option>
                <option value="restaurant-manager" <?= ($profession == 'restaurant-manager') ? 'selected' : '' ?>>Restaurant Manager</option>
                <option value="cruise-director" <?= ($profession == 'cruise-director') ? 'selected' : '' ?>>Cruise Director</option>
            </optgroup>
            
            <optgroup label="Sports and Fitness">
                <option value="professional-athlete" <?= ($profession == 'professional-athlete') ? 'selected' : '' ?>>Professional Athlete</option>
                <option value="fitness-trainer" <?= ($profession == 'fitness-trainer') ? 'selected' : '' ?>>Fitness Trainer</option>
                <option value="sports-coach" <?= ($profession == 'sports-coach') ? 'selected' : '' ?>>Sports Coach</option>
                <option value="sports-analyst" <?= ($profession == 'sports-analyst') ? 'selected' : '' ?>>Sports Analyst</option>
                <option value="physical-education-teacher" <?= ($profession == 'physical-education-teacher') ? 'selected' : '' ?>>Physical Education Teacher</option>
                <option value="sports-psychologist" <?= ($profession == 'sports-psychologist') ? 'selected' : '' ?>>Sports Psychologist</option>
                <option value="sports-manager" <?= ($profession == 'sports-manager') ? 'selected' : '' ?>>Sports Manager</option>
            </optgroup>
            
            <optgroup label="Environment and Sustainability">
                <option value="environmental-consultant" <?= ($profession == 'environmental-consultant') ? 'selected' : '' ?>>Environmental Consultant</option>
                <option value="conservation-scientist" <?= ($profession == 'conservation-scientist') ? 'selected' : '' ?>>Conservation Scientist</option>
                <option value="ecologist" <?= ($profession == 'ecologist') ? 'selected' : '' ?>>Ecologist</option>
                <option value="agricultural-scientist" <?= ($profession == 'agricultural-scientist') ? 'selected' : '' ?>>Agricultural Scientist</option>
                <option value="renewable-energy-specialist" <?= ($profession == 'renewable-energy-specialist') ? 'selected' : '' ?>>Renewable Energy Specialist</option>
                <option value="sustainability-coordinator" <?= ($profession == 'sustainability-coordinator') ? 'selected' : '' ?>>Sustainability Coordinator</option>
                <option value="wildlife-biologist" <?= ($profession == 'wildlife-biologist') ? 'selected' : '' ?>>Wildlife Biologist</option>
            </optgroup>
            
            <optgroup label="Freelance and Remote Work">
                <option value="virtual-assistant" <?= ($profession == 'virtual-assistant') ? 'selected' : '' ?>>Virtual Assistant</option>
                <option value="freelance-writer" <?= ($profession == 'freelance-writer') ? 'selected' : '' ?>>Freelance Writer</option>
                <option value="freelance-graphic-designer" <?= ($profession == 'freelance-graphic-designer') ? 'selected' : '' ?>>Freelance Graphic Designer</option>
                <option value="online-tutor" <?= ($profession == 'online-tutor') ? 'selected' : '' ?>>Online Tutor</option>
                <option value="digital-marketing-consultant" <?= ($profession == 'digital-marketing-consultant') ? 'selected' : '' ?>>Digital Marketing Consultant</option>
                <option value="e-commerce-specialist" <?= ($profession == 'e-commerce-specialist') ? 'selected' : '' ?>>E-commerce Specialist</option>
                <option value="freelance-software-developer" <?= ($profession == 'freelance-software-developer') ? 'selected' : '' ?>>Freelance Software Developer</option>
            </optgroup>
        </select>


        <label for="complexion">Complexion:</label>
        <select name="complexion" required>
            <option value="Fair" <?= ($complexion == 'Fair') ? 'selected' : '' ?>>Fair</option>
            <option value="Medium" <?= ($complexion == 'Medium') ? 'selected' : '' ?>>Medium</option>
            <option value="Olive" <?= ($complexion == 'Olive') ? 'selected' : '' ?>>Olive</option>
            <option value="Tan" <?= ($complexion == 'Tan') ? 'selected' : '' ?>>Tan</option>
            <option value="Dark" <?= ($complexion == 'Dark') ? 'selected' : '' ?>>Dark</option>
        </select>
        <label for="height">Height (cm):</label>
        <input type="number" name="height" value="<?= htmlspecialchars($height) ?>" step="0.01" required>


        <label for="weight">Weight (kg):</label>
        <input type="number" name="weight" value="<?= htmlspecialchars($weight) ?>" required>

        <label for="biography">Biography:</label>
        <textarea name="biography"><?= htmlspecialchars($biography) ?></textarea>

        <label for="family_background">Family Background:</label>
        <textarea name="family_background"><?= htmlspecialchars($family_background) ?></textarea>

        <!-- Interests and Hobbies -->
        <h2>Interests</h2>
        <textarea name="interest"><?= htmlspecialchars($interest) ?></textarea>

        <h2>Hobbies</h2>
        <textarea name="hobbies"><?= htmlspecialchars($hobbies) ?></textarea>

        <!-- Submit Button -->
        <button type="submit" class="submit-btn">Save Changes</button>
    </form>
    <button type="submit" class="submit-btn" onclick="window.location.href='index.php';">Back to dashboard</button>
</div>

</body>
</html>
